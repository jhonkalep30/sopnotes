<div class="modal fade" tabindex="-1" id="modal-form">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><span id="modal-form-title">Add New</span> Role</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body" style="max-height: 68vh; overflow-y: scroll;">
                <form id="form-data" enctype="multipart/form-data">

                    <input type="hidden" id="id" name="id" value="">

                    {{ 
                        Form::textInput('role', null, [
                            'required' => 'required',
                            'labelText' => 'Role',
                            'formAlignment' => 'vertical'
                        ]) 
                    }}

                    {{-- <div class="form-group mb-5 1">
                        <div class="row">
                            <div class="col-md-3">
                                <label class=" col-form-label">
                                    <strong>Access</strong>
                                </label>
                            </div>
                            <div class="col-md-9 align-items-center">
                                <label class="form-check form-control-group form-check-solid me-9">
                                    <input class="form-check-input" type="checkbox" value="" id="kt_roles_select_all">
                                    <span class="form-check-label" for="kt_roles_select_all">All Access</span>
                                </label>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="form-group mb-5 1">
                        <div class="row">
                            <div class="col-md-3">
                                <label class=" col-form-label">
                                    <strong>Products</strong>
                                </label>
                            </div>
                            <div class="col-md-9">
                            </div>
                        </div>
                    </div> --}}

                    <label class="fs-5 fw-bold form-label mt-4">Role Permissions</label>

                    <div id="modal-form-loading" style="display: none;">
                        <div class="d-flex flex-column flex-center" style="height: 200px;">
                            
                        </div>
                    </div>

                    <div id="modal-form-no-data" style="display: none;">
                        <div class="d-flex flex-column flex-center" style="height: 200px;">
                            <img src="{{ asset('images/21.png') }}" style="max-width: 150px;">
                            {{-- <div class="fs-1 fw-bolder text-dark mb-4">No data found</div> --}}
                            <div class="fs-6 mt-3">No permissions were found, please add some first</div>
                        </div>
                    </div>

                    <div id="modal-form-data" >

                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-2">
                                <!--begin::Table body-->
                                <tbody class="text-gray-600 fw-semibold" id="permission-container">

                                    <!--begin::Table row-->
                                    <tr>
                                        {{-- <td style="width: 10px !important;">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input cursor-pointer" type="checkbox" id="modal-form-checkbox-group-all">
                                            </div>
                                        </td> --}}
                                        {{-- <td class="text-gray-800 fw-bold fs-5" style="width: 20% !important;">Group Permissions</td> --}}

                                        <td class="text-gray-800 my-2" style="width: 30% !important;">
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                <input id="acl-all" class="form-check-input" type="checkbox" value="">
                                                <span class="form-check-label text-gray-800 ms-3 fw-bold fs-5">Select All</span>
                                            </label>
                                        </td>

                                        <td class="my-2" style="float: right; border: none !important;">
                                            <!--begin::Checkbox-->
                                            {{-- <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                                <input class="form-check-input" type="checkbox" value="" id="kt_roles_select_all">
                                                <span class="form-check-label" for="kt_roles_select_all">Select all</span>
                                            </label> --}}
                                            <!--end::Checkbox-->

                                            <div class="d-flex align-items-center position-relative my-1">
                                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <input type="text" id="filter-search" class="form-control form-control-solid w-200px ps-13" placeholder="Filter">
                                            </div>
                                        </td>
                                    </tr>
                                    <!--end::Table row-->


                                    <!--begin::Table row-->
                                    <tr class="permission-row my-2">
                                        <!--begin::Label-->
                                        <td class="text-gray-800" style="width: 30% !important; vertical-align: text-top !important;">
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20 my-1">
                                                <input acl="product" acl-type="parent" class="form-check-input" type="checkbox" value="">
                                                <span class="form-check-label text-gray-700 ms-3">Product</span>
                                            </label>
                                        </td>
                                        <!--end::Label-->
                                        <!--begin::Input group-->
                                        <td class="grid-container" style="border: none !important;">

                                            <div class="my-1">
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input acl="product" acl-type="child" class="form-check-input" type="checkbox" name="permissions[]" value="product.list">
                                                    <span class="form-check-label">List</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>

                                            <div class="my-1">
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input acl="product" acl-type="child" class="form-check-input" type="checkbox" name="permissions[]" value="product.create">
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>

                                            {{-- <div class="my-1">
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input acl="product" class="form-check-input acl-child acl-child-product" type="checkbox" name="permissions[]" value="product.datatable">
                                                    <span class="form-check-label">Datatable</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div> --}}

                                           {{--  <div class="my-1">
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" value="" name="user_management_read">
                                                    <span class="form-check-label">Save</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>

                                            <div class="my-1">
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" value="" name="user_management_read">
                                                    <span class="form-check-label">Delete</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>

                                            <div class="my-1">
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" value="" name="user_management_read">
                                                    <span class="form-check-label">Export</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>

                                            <div class="my-1">
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" value="" name="user_management_read">
                                                    <span class="form-check-label">Import</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>

                                            <div class="my-1">
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" value="" name="user_management_read">
                                                    <span class="form-check-label">Queue</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>

                                            <div class="my-1">
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" value="" name="user_management_read">
                                                    <span class="form-check-label">Datatable</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div> --}}

                                        </td>
                                        <!--end::Input group-->
                                    </tr>
                                    <!--end::Table row-->

                                    <!--begin::Table row-->
                                    <tr class="permission-row">
                                        <!--begin::Label-->
                                        <td class="text-gray-800" style="width: 30% !important; vertical-align: text-top !important;">
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20 my-1">
                                                <input class="form-check-input" type="checkbox" value="" name="user_management_read">
                                                <span class="form-check-label text-gray-700 ms-3"><i>Non Group</i></span>
                                            </label>
                                        </td>
                                        <!--end::Label-->
                                        <!--begin::Input group-->
                                        <td class="grid-container my-1">
                                            <div class="my-1">
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" value="" name="user_management_read">
                                                    <span class="form-check-label">Read</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>

                                            <div class="my-1">
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" value="" name="user_management_read">
                                                    <span class="form-check-label">Read</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>

                                            <div class="my-1">
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" value="" name="user_management_read">
                                                    <span class="form-check-label">Read</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>

                                            <div class="my-1">
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" value="" name="user_management_read">
                                                    <span class="form-check-label">Read</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>

                                            <div class="my-1">
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" value="" name="user_management_read">
                                                    <span class="form-check-label">Read</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>

                                        </td>
                                        <!--end::Input group-->
                                    </tr>
                                    <!--end::Table row-->


                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>

                    </div>

                </form>
            </div>

            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-sm btn-success" onclick="clearForm();">Clear</button> --}}
                {{-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> --}}
                <button type="button" class="btn btn-active-light me-3" data-bs-dismiss="modal">Close</button>
                <button type="button" id="modal-form-submit" class="btn btn-primary">
                    <span class="indicator-label">Submit</span>
                    <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </div>
</div>

@push('additional-js')

<script type="text/javascript">

    $(document).ready(function(){
         var blockLoading = new KTBlockUI(document.querySelector("#modal-form-loading"), {
            overlayClass: "bg-white bg-opacity-0",
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading permissions, please wait...</div>',
        });

        blockLoading.block();
    })

    function loadPermission(id, filter = '') {

        var data = {};

        if(id) data.id = id;
        $('#modal-form-title').html(id ? 'Update' : 'Add New');
        $('#filter-search').val('')

        $.ajax({
            type: "POST",
            url:  '{{ route('role.permission') }}',
            data: data,
            beforeSend: function(){
                switchContent();
            },
            success: function (res) {
                log(res.data)

                if(res.data.role){
                    renderRole(res.data.role);
                }

                if(res.data.access.length){
                    renderPermission(res.data.access);
                    switchContent('data')
                }else{
                    switchContent('no-data')
                }
            },
            error: function(xhr, textStatus, errorThrown){
                log(errorThrown);
                // toastr.error("Error while getting data", "System Error");
                switchContent('no-data')
            }
        });

    }

    function renderRole(role) {
        $('#id').val(role.id)
        $('#role').val(role.name)
    }

    function renderPermission(parents) {

        $('.permission-row').remove();

        $.each(parents, function(parentIndex, parent){

            var elRow

            elRow += '<tr class="permission-row" acl-label="'+parent.label.toLowerCase()+'">'+
                        '<td class="text-gray-800" style="width: 30% !important; vertical-align: text-top !important;">'+
                            '<label class="form-check form-check-sm form-check-custom form-check-solid my-1">'+
                                '<input acl="'+parent.key+'" acl-type="parent" class="form-check-input" type="checkbox" value="">'+
                                '<span class="form-check-label text-gray-700 ms-3">'+parent.label+'</span>'+
                            '</label>'+
                        '</td>'+
                        '<td class="grid-container my-2" style="border: none !important;">';

            $.each(parent.permissions, function(childIndex, child){

                elRow += '<div class="my-2">'+
                                '<label class="form-check form-check-sm form-check-custom form-check-solid">'+
                                    '<input acl="'+parent.key+'" acl-type="child" acl-access="'+child.access+'" class="form-check-input" type="checkbox" name="permissions[]" value="'+child.permission_key+'">'+
                                    '<span class="form-check-label">'+child.action_label+'</span>'+
                                '</label>'+
                            '</div>';

            })

            elRow +=     '</td>'+
                    '</tr>';


            $('#permission-container').append(elRow);

        });

        // $('#permission-container').html(html);
        syncPermissions()
        syncSelectAll()

    }

    function syncPermissions() {
        $('input[acl-type="child"][acl-access="1"]').prop('checked', true).trigger('change')
    }

    function switchContent(mode = 'loading') {
        
        $('#modal-form-no-data').hide();
        $('#modal-form-data').hide();
        $('#modal-form-loading').hide();

        if(mode == 'loading') $('#modal-form-loading').show();
        if(mode == 'data') $('#modal-form-data').show();
        if(mode == 'no-data') $('#modal-form-no-data').show();

    }

    $('#modal-form-submit').click(function(){

        var data = {}

        if($('#id').val()) data.id = $('#id').val();
        data.role = $('#role').val();
        data.permissions = [...document.querySelectorAll('input[acl-type="child"]:checked')].map(e => e.value)

        // Swal.fire({
        //     title: "Are you sure?",
        //     text: "Data will be saved!",
        //     icon: "warning",
        //     showCancelButton: true,
        //     confirmButtonText: "Yes, save it!",
        //     stopKeydownPropagation: false
        // }).then(function(result) {

        //     if (result.value) {

                $.ajax({
                    type: "POST",
                    url:  '{{ route('role.save') }}',
                    data: data,
                    beforeSend: function(){   
                        // getBlockUI().block();
                        submitProcess('modal-form-submit');
                    },
                    success: function (result) {

                        if(result.success == true){
                            getData();
                            $('#id').val('')
                            $('#role').val('')
                            $('#acl-all').prop('checked', false)
                            $('#modal-form').modal('hide');
                            // Swal.fire("Success!", result.msg, "success");
                        }else{
                            // Swal.fire("Error!", result.msg, "error");

                            // $('.error-container').html('');
                            // displayErrorInput(result.errors);

                            swaling({'text': result.message, 'icon': 'error'})
                            displayErrorInput($('#form-data'), result.errors);
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        console.log(errorThrown);
                        toasting()
                    }
                }).always(function(){
                    // getBlockUI().release();
                    submitProcess('modal-form-submit', 1);
                });
        //     }
        // });

    })

    $(document).on('change', 'input[acl-type="child"]', function(){
        let key = $(this).attr('acl')
        let countOthers = $('input[acl-type="child"][acl="'+key+'"]').length
        let countOthersChecked = $('input[acl-type="child"][acl="'+key+'"]:checked').length

        $('input[acl-type="parent"][acl="'+key+'"]').prop('checked', countOthersChecked == countOthers)

        syncSelectAll();
    })

    $(document).on('change', 'input[acl-type="parent"]', function(){
        let key = $(this).attr('acl')

        $('input[acl-type="child"][acl="'+key+'"]').prop('checked', $(this).is(':checked'))

        syncSelectAll();
    });

    $('#acl-all').change(function(){
        $('input[acl-type="parent"]').prop('checked', $(this).is(':checked'))
        $('input[acl-type="child"]').prop('checked', $(this).is(':checked'))
    })

    function syncSelectAll() {
        let countOthers = $('input[acl-type="parent"]').length
        let countOthersChecked = $('input[acl-type="parent"]:checked').length

        // if(countOthers > 0 && countOthersChecked > 0)
            $('#acl-all').prop('checked', countOthersChecked == countOthers)
    }

    $('#filter-search').keyup(function (e) {
        $('.permission-row').hide();

        if($(this).val() == ''){
            $('.permission-row').show();
        }else{
            $('tr[acl-label*='+$(this).val().toLowerCase()+']').show();
        }


        // log($(this).val().toLowerCase())
        // log('tr[acl-label*='+$(this).val().toLowerCase()+']')
        // log($('tr[acl-label*='+$(this).val().toLowerCase()+']'))
    });


</script>

@endpush