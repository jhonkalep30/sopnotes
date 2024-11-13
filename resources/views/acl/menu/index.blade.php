@extends(config('theme.layouts.admin'),[
    'title' => 'Menu',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        ['label' => 'System'],
        ['label' => 'Menu'],
    ]

])

@section('content')

    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" id="filter-search" class="form-control form-control-solid w-250px ps-13" placeholder="Search">
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    
                    <button id="button-create" type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#modal-form" onclick="checkForm()">
                    <i class="ki-duotone ki-abstract-10 fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>Create</button>
                    
                </div>
                <!--end::Toolbar-->

            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-4 pb-15">

            <div id="content-loading">
                <div class="d-flex flex-column flex-center" style="height: 225px;">
                    {{-- <img src="{{ asset(config('theme.assets.back-office').'/media/illustrations/sigma-1/5.png') }}" style="max-width: 175px;">
                    <div class="fs-1 fw-bolder text-dark mb-4">Loading</div>
                    <div class="fs-6">Hang in there, we are getting data ...</div> --}}
                </div>
            </div>

            <div id="content-error" style="display: none;">
                <div class="d-flex flex-column flex-center" style="height: 225px;">
                    <img src="{{ asset(config('theme.assets.back-office').'/media/illustrations/sigma-1/20.png') }}" style="max-width: 175px;">
                    <div class="fs-1 fw-bolder text-dark mb-4">Error</div>
                    <div class="fs-6">Oops, something went wrong ...</div>
                </div>
            </div>
            
            <div id="content-empty" style="display: none;">
                <div class="d-flex flex-column flex-center" style="height: 225px;">
                    <img src="{{ asset('images/21.png') }}" style="max-width: 175px;">
                    <div class="fs-1 fw-bolder text-dark mb-4">No data found</div>
                    <div class="fs-6">Sorry we couldn't find any data</div>
                </div>
            </div>

            <div id="content-data" style="display: none;">
                <div class="flex-column flex-center px-3" style="min-height: 225px;">

                    <table class="table align-middle table-row-dashed fs-6 gy-3" id="table-menu">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">Menu</th>
                                <th class="column-action">Actions</th>
                                
                            </tr>
                        </thead>
                        <tbody class="fw-semibold" id="menu-container"></tbody>
                    </table>
                </div>
            </div>

        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

    @include('acl.menu.modal_form')

@endsection

@push('additional-css')

<style type="text/css">
    .column-action {
        width: 90px !important;
        align-items: center;
        text-align: center;
    }

    .icon-hover>i {
        color: #7E829C;
    }

    .text-menu>.d-flex>.ki-duotone{
        font-size: 1.5rem !important;
    }
</style>

@endpush

@push('additional-js')

<script type="text/javascript">

    $(document).ready(function(){
        
        var blockLoading = new KTBlockUI(document.querySelector("#content-loading"), {
            overlayClass: "bg-white bg-opacity-0",
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
        });

        blockLoading.block();

        // setTimeout(function(){
        //     blockLoading.release();

        //     $('#content-loading').hide()
        //     // $('#content-empty').show()
        //     $('#content-data').show()
        // }, 2000);

        // DATATABLE
        // $('#table-menu').DataTable({
        //     "info": false,
        //     'order': [],
        //     "pageLength": 10,
        //     "lengthChange": false,
        //     'columnDefs': [
        //         { orderable: false, targets: '_all' }
        //     ]
        // });

        getMenus();

    })

    $('#button-create').click(function(){
        // getBlockUI().block();
        $('#modal-form-title').html('Create');
    });

    function getMenus(search = '') {
        
        var data = {};
        if(search) data.search = search

        $.ajax({
            type: "POST",
            url:  '{{ route('menu.list') }}',
            data: data,
            beforeSend: function(){
                switchContent();
            },
            success: function (res) {
                log(res.data)

                if(res.data.length){
                    switchContent('data')
                    renderMenus(res.data);
                }else{
                    switchContent('empty')
                }
            },
            error: function(xhr, textStatus, errorThrown){
                log(errorThrown);
                // toastr.error("Request Failed.", "System Error");
                switchContent('error')
            }
        });

    }

    function renderMenus(menus) {

        var html = '';
        $('#menu-container').html('');
        
        $.each(menus, function(sectionIndex, section){
            // log('SECTION', section);

            html += renderItem(section);

            $.each(section.groups, function(groupIndex, group){
                // log('GROUP', group);

                html += renderItem(group, 'group');

                $.each(group.links, function(linkIndex, link){
                    // log('LINK', link);

                    html += renderItem(link);

                });  
            });    
        });

        $('#menu-container').html(html);

    }

    function renderItem(data, forceType = null) {
        
        var icon = '';
        if(data.icon) icon = data.icon + '<span class="ms-2"></span';

        var tdClass = '';
        var type = forceType ? forceType : data.type;
        if(type == 'group') tdClass = 'ps-6';
        if(type == 'link') tdClass = 'ps-15';

        return '<tr>'+
                    '<td class="'+tdClass+'">'+
                        '<div class="d-flex">'+
                            '<a onclick="editMenu('+data.id+')" href="javascript:void(0)" class="'+(data.is_hidden ? 'text-muted' : 'text-dark')+' text-hover-primary text-menu">'+
                                '<div class="d-flex">'+
                                    icon+
                                    '<span>'+data.label+'</span>'+
                                '</div>'+
                            '</a>'+

                            '<div class="badge badge-secondary ms-2">'+data.type+'</div>'+
                            (data.url ? badgeUrl(data) : '')+
                            (data.permission_key ? badgePermission(data) : '')+
                        '</div>'+
                    '</td>'+
                    actionButton(data)+
                '</tr>';
    }

    function badgeUrl(data) {
        var url = '';
        if(data.url){
            url = '<div class="badge badge-primary ms-2 fs-8 ps-3 pe-4">'+
                        '<i class="ki-duotone ki-fasten text-white me-1">'+
                         '<i class="path1"></i>'+
                         '<i class="path2"></i>'+
                        '</i>'+

                        data.url+
                    '</div>';
        }

        return url;

    }

    function badgePermission(data) {
        var permission = '';
        if(data.permission_key){
            permission = '<div class="badge badge-info ms-2 fs-8 ps-3 pe-4">'+
                                '<i class="ki-duotone ki-key text-white me-1">'+
                                 '<i class="path1"></i>'+
                                 '<i class="path2"></i>'+
                                '</i>'+

                                data.permission_key+
                            '</div>';
        }

        return permission;
    }

    function actionButton(data) {

        var hideIcon = '<i class="ki-duotone ki-eye-slash fs-2">'+
                            '<span class="path1"></span>'+
                            '<span class="path2"></span>'+
                            '<span class="path3"></span>'+
                            '<span class="path4"></span>'+
                        '</i></button>';

        if(data.is_hidden == 1){
            hideIcon = '<i class="ki-duotone ki-eye fs-2">'+
                            '<span class="path1"></span>'+
                            '<span class="path2"></span>'+
                            '<span class="path3"></span>'+
                            '<span class="path4"></span>'+
                        '</i></button>';
        }
        
        return '<td class="column-action">'+
                    '<button onclick="hideMenu('+data.id+')" type="button" class="btn btn-sm btn-icon btn-icon-muted btn-active-icon-primary">'+
                    hideIcon+

                    '<button onclick="deleteMenu('+data.id+')" type="button" class="btn btn-sm btn-icon btn-icon-muted btn-active-icon-danger ms-2">'+
                    '<i class="ki-duotone ki-trash fs-2">'+
                        '<span class="path1"></span>'+
                        '<span class="path2"></span>'+
                        '<span class="path3"></span>'+
                        '<span class="path4"></span>'+
                        '<span class="path5"></span>'+
                    '</i></button>'+
                '</td>';

    }

    function switchContent(mode = 'loading') {
        
        $('#content-empty').hide();
        $('#content-data').hide();
        $('#content-loading').hide();
        $('#content-error').hide();

        if(mode == 'loading') $('#content-loading').show();
        if(mode == 'data') $('#content-data').show();
        if(mode == 'empty') $('#content-empty').show();
        if(mode == 'error') $('#content-error').show();

    }

    function editMenu(id) {

        $('#modal-form-title').html('Edit');

        // SET FILTER ID :: PARENT SECTION ID
        // select2Options_parent_section_id.additionalParams.selectedId = id;
        // initSelect2_parent_section_id

        // SET FILTER ID :: PARENT GROUP ID
        // select2Options_parent_group_id.additionalParams.selectedId = id;
        // initSelect2_parent_group_id
        
        $.ajax({
            type: "GET",
            url:  '{{ url('menu/detail') }}' + '/' + id,
            beforeSend: function(){
                getBlockUI().block();
            },
            success: function (res) {
                // log(res)

                if(res.data){

                    clearForm()
                    let data = res.data

                    $('#id').val(data.id)
                    $('#label').val(data.label)
                    $("#select2-type").val(data.type).trigger('change');
                    $('#order').val(data.order)
                    $('#url').val(data.url)
                    $('#icon').val(data.icon)
                    $('#permission').val(data.permission)

                    if(data.type == 'group' && data.parent_id){
                        // log($('#select2-parent_section_id').val());
                        // $('#select2-parent_section_id').val(1).trigger('change');
                        select2_setValue_parent_section_id([data.parent_id, data.parent.label])
                    }

                    if(data.type == 'link' && data.parent_id){
                        // $('#select2-parent_group_id').val(data.parent_id).trigger('change');
                        select2_setValue_parent_group_id([data.parent_id, data.parent.label])
                    }

                    if(data.type == 'link' && data.permission_id){
                        // $('#select2-permission_id').val(data.permission_id).trigger('change');
                        select2_setValue_permission_id([data.permission_id, data.permission.select2_label])
                    }

                    $('#modal-form').modal('show')
                }
            },
            error: function(xhr, textStatus, errorThrown){
                log(errorThrown);
                toastr.error("Request Failed.", "System Error");
            }
        }).always(function(){
            getBlockUI().release();
        })

    }

    function hideMenu(id) {

        $.ajax({
            type: "GET",
            url:  '{{ url('menu/hide') }}' + '/' + id,
            success: function (res) {
                if(res.data){

                    log('DATA', res.data)

                    $.each(res.data.ids, function(index, id){

                        var elText = $('[onclick="editMenu('+id+')"]')
                        var elButton = $('[onclick="hideMenu('+id+')"]')

                        var icon = '<i class="ki-duotone ki-eye-slash fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>';

                        elText.removeClass('text-muted').addClass('text-dark')

                        if(res.data.hidden){
                            elText.removeClass('text-dark').addClass('text-muted')

                            icon = '<i class="ki-duotone ki-eye fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>';
                        }

                        elButton.html(icon)

                    })

                    

                }
            },
            error: function(xhr, textStatus, errorThrown){
                log(errorThrown);
                toastr.error("Request Failed.", "System Error");
            }
        });

    }

    function deleteMenu(id) {

        Swal.fire({
            text: 'All child menu will be deleted too!',
            icon: 'warning',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            stopKeydownPropagation: false,
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-active-light"
            }
        }).then(function(choice) {

            if (choice.value) {
        
                $.ajax({
                    type: "DELETE",
                    url:  '{{ url('menu/delete') }}' + '/' + id,
                    success: function (result) {
                        if(result.success){
                            getMenus();
                        }else{
                            swaling({'text': result.message, 'icon': 'error'})
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        log(errorThrown);
                        toasting()
                    }
                });

            }

        });

    }

    $('#filter-search').keyup(delay(function (e) {
        getMenus($('#filter-search').val())
    }, 500));

    function checkForm() {
        if($('#id').val()){
            $('#id').val('')
            clearForm()
        }
    }

</script>

@endpush
{{-- 
@section('datatable-resource')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
@endsection --}}
