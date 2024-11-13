@extends(config('theme.layouts.admin'),[
    'title' => 'Permission',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        ['label' => 'System'],
        ['label' => 'Permission'],
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

                    <button id="button-discover" type="button" class="btn btn-light-primary btn-md me-2" data-bs-toggle="modal" data-bs-target="#modal-discover" onclick="getDiscover()">
                    <i class="ki-duotone ki-coffee fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                        <span class="path5"></span>
                        <span class="path6"></span>
                    </i>Discover</button>
                    
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

            <div id="content-loading" >
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

            <div id="content-data" style="display:none;">
                <div class="px-3" style="min-height: 225px;">

                    <table class="table align-middle table-row-dashed fs-6 gy-3" id="table-permission">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="column-group">Group</th>
                                <th class="">Permissions</th>
                                
                            </tr>
                        </thead>
                        <tbody class="fw-semibold" id="table-container">

                            <tr>
                                <td class="column-group">
                                    <div>
                                        <a href="javascript:void(0)" class="text-dark text-hover-info fw-bolder fs-5">
                                            <span>Group A</span>
                                        </a>
                                    </div>

                                    <div class="badge badge-info mt-2">group-a</div>
                                </td>
                                <td class="td-permission">
                                    <div class="div-permission">

                                        <div class="d-flex my-2">

                                            <a href="javascript:void(0)" class="text-dark border border-gray-600 border-dashed rounded py-4 px-5 me-5 bg-hover-light-warning">
                                                <div class="d-flex">
                                                    <span>Action #1</span>
                                                </div>

                                                <div class="badge badge-dark mt-2">group-a.action#1</div>
                                            </a>

                                            <a href="javascript:void(0)" class="text-dark border border-gray-600 border-dashed rounded py-4 px-5 me-5 bg-hover-light-warning">
                                                <div class="d-flex">
                                                    <span>Action #2</span>
                                                </div>

                                                <div class="badge badge-dark mt-2">group-a.action#2</div>
                                            </a>

                                            <a href="javascript:void(0)" class="text-dark border border-gray-600 border-dashed rounded py-4 px-5 me-5 bg-hover-light-warning">
                                                <div class="d-flex">
                                                    <span>Action #2</span>
                                                </div>

                                                <div class="badge badge-dark mt-2">group-a.action#2</div>
                                            </a>

                                            <a href="javascript:void(0)" class="text-dark border border-gray-600 border-dashed rounded py-4 px-5 me-5 bg-hover-light-warning">
                                                <div class="d-flex">
                                                    <span>Action #2</span>
                                                </div>

                                                <div class="badge badge-dark mt-2">group-a.action#2</div>
                                            </a>

                                            <a href="javascript:void(0)" class="text-dark border border-gray-600 border-dashed rounded py-4 px-5 me-5 bg-hover-light-warning">
                                                <div class="d-flex">
                                                    <span>Action #2</span>
                                                </div>

                                                <div class="badge badge-dark mt-2">group-a.action#2</div>
                                            </a>

                                          

                                        </div>

                                    </div>

                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div>
                                        <a href="javascript:void(0)" class="text-dark text-hover-info fw-bolder fs-5">
                                            <span>Group B</span>
                                        </a>
                                    </div>

                                    <div class="badge badge-info mt-2">group-b</div>
                                </td>
                                <td class="td-permission">
                                    <div class="div-permission">

                                        <div class="d-flex my-2">

                                            <a href="javascript:void(0)" class="text-dark border border-gray-600 border-dashed rounded py-4 px-5 me-5 bg-hover-light-warning">
                                                <div class="d-flex">
                                                    <span>Action #1</span>
                                                </div>

                                                <div class="badge badge-dark mt-2">group-b.action#1</div>
                                            </a>

                                            <a href="javascript:void(0)" class="text-dark border border-gray-600 border-dashed rounded py-4 px-5 me-5 bg-hover-light-warning">
                                                <div class="d-flex">
                                                    <span>Action #2</span>
                                                </div>

                                                <div class="badge badge-dark mt-2">group-b.action#2</div>
                                            </a>

                                            <a href="javascript:void(0)" class="text-dark border border-gray-600 border-dashed rounded py-4 px-5 me-5 bg-hover-light-warning">
                                                <div class="d-flex">
                                                    <span>Action #2</span>
                                                </div>

                                                <div class="badge badge-dark mt-2">group-b.action#2</div>
                                            </a>

                                            <a href="javascript:void(0)" class="text-dark border border-gray-600 border-dashed rounded py-4 px-5 me-5 bg-hover-light-warning">
                                                <div class="d-flex">
                                                    <span>Action #2</span>
                                                </div>

                                                <div class="badge badge-dark mt-2">group-b.action#2</div>
                                            </a>

                                            <a href="javascript:void(0)" class="text-dark border border-gray-600 border-dashed rounded py-4 px-5 me-5 bg-hover-light-warning">
                                                <div class="d-flex">
                                                    <span>Action #2</span>
                                                </div>

                                                <div class="badge badge-dark mt-2">group-b.action#2</div>
                                            </a>

                                          

                                        </div>

                                    </div>

                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

    @include('acl.permission.modals.modal_form')
    @include('acl.permission.modals.modal_group')
    @include('acl.permission.modals.modal_discover')

@endsection

@push('additional-css')

<style type="text/css">
    .column-group {
        width: 20% !important;
    }

    .icon-hover>i {
        color: #7E829C;
    }

    .prm-item {
        border-style: dashed !important;
    }

    .td-permission {
        max-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .div-permission {
        overflow-x: auto; 
        width: 100%;
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

        var blockLoading = new KTBlockUI(document.querySelector("#modal-discover-loading"), {
            overlayClass: "bg-white bg-opacity-0",
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Discovering permissions, please wait...</div>',
        });

        blockLoading.block();

        getData();

    })

    $('#button-create').click(function(){
        // getBlockUI().block();
        $('#modal-form-title').html('Create');
    });

    function getData(search = '') {
        
        var data = {};
        if(search) data.search = search

        $.ajax({
            type: "POST",
            url:  '{{ route('permission.list') }}',
            data: data,
            beforeSend: function(){
                switchContent();
            },
            success: function (res) {
                // log(res.data)

                if(res.data.length){
                    var renderResult = renderData(res.data);

                    if(renderResult){
                        switchContent('data')
                    }else{
                        switchContent('empty')
                    }
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

    function renderData(data) {

        var rendered = false;

        var html = '';
        $('#table-container').html('');
        
        $.each(data, function(groupIndex, group){
            var rendering = renderGroup(group);
            html += rendering;
            if(rendering != '') rendered = true;
        });

        $('#table-container').html(html);

        return rendered;
    }

    function renderGroup(data) {

        var actions = '';
        $.each(data.actions, function(actionIndex, action){
            actions += renderAction(action);
        });

        var href = '<a onclick="editGroup(\''+data.key+'\', \''+data.label+'\')" href="javascript:void(0)" class="text-dark text-hover-primary fw-bolder fs-5"><span>'+data.label+'</span></a>';
        var badge = '<div class="badge badge-primary mt-2">'+data.key+'</div>';

        if(data.key === '#'){
            href = '<span class="fw-bolder">'+data.label+'</span>';
            badge = '<span class="text-muted fs-7 mt-1">Single Permission</span>';
        }
            
        if(actions == '') return ''

        return '<tr>'+
                    '<td>'+
                        '<div>'+
                            href+
                        '</div>'+

                        badge+
                    '</td>'+
                    '<td class="td-permission">'+
                        '<div class="div-permission">'+
                            '<div class="d-flex my-2">'+
                                actions
                            '</div>'+
                        '</div>'+
                    '</td>'+
                '</tr>';

    }

    function renderAction(data) {

        var url = '';
        var url_method = '';
        if(data.url_method){
            url_method = '<div class="badge badge-info ms-0 mt-2" style="border-top-right-radius: 0px;border-bottom-right-radius: 0px;">'+
                            data.url_method+
                        '</div>';
        }

        if(data.url){
            url =   '<div class="badge badge-secondary ms-'+(data.url_method ? '0' : '1')+' mt-2" '+(data.url_method ? 'style="border-top-left-radius: 0px;border-bottom-left-radius: 0px;"' : '')+'>'+
                        data.url+
                    '</div>';
        }

        return '<a onclick="editAction('+data.id+')" href="javascript:void(0)" class="text-dark border border-gray-600 border-dashed rounded py-4 px-5 me-5 bg-hover-light-warning">'+
                    '<div class="d-flex align-items-center">'+
                        // '<span class="bullet bg-primary me-3"></span>'+
                        '<span class="fw-bold ms-1">'+data.action_label+'</span>'+
                    '</div>'+

                    '<div>'+url_method+url+'</div>'+
                    '<div class="badge badge-dark mt-2">'+data.permission_key+'</div>'+
                    // url_method+url+
                '</a>';
    }

    function editGroup(key, label) {
        

        $('#modal-group').modal('show');
        $('#edit_group_key').val(key);
        $('#edit_group_old_key').val(key);
        $('#edit_group_label').val(label);

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

    function editAction(id) {

        $.ajax({
            type: "GET",
            url:  '{{ url('permission/detail') }}' + '/' + id,
            beforeSend: function(){
                getBlockUI().block();
            },
            success: function (res) {
                // log('RES', res) 

                if(res.data){

                    // displayErrorInput($('#form-permission'), result.errors);
                    $('.error-container').html('');

                    let data = res.data

                    $('#id').val(data.id)
                    $('#group_key').val(data.group_key)
                    $('#group_label').val(data.group_label)
                    $('#action_key').val(data.action_key)
                    $('#action_label').val(data.action_label)
                    $('#url').val(data.url)
                    $("#select2-url_method").val(data.url_method).trigger('change');

                    if(data.group_key) $('#group-key-addon').html(data.group_key+'.')

                    $('#discover-delete-button').show()

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

    $('#filter-search').keyup(delay(function (e) {
        getData($('#filter-search').val())
    }, 500));

    function checkForm() {
        
        $('#discover-delete-button').hide()

        if($('#id').val()){
            $('#discover-delete-button').show()
            $('#id').val('')
            clearForm()
        }
    }

</script>

@endpush
