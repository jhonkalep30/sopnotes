<div class="modal fade" tabindex="-1" id="modal-form">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><span id="modal-form-title">Create</span> Permission</h3>
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
                <form id="form-permission" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="id" value="">

                    <div class="row">
                        <div class="col-6">
                            {{ 
                                Form::textInput('group_key', null, [
                                    'formAlignment' => 'vertical',
                                    'labelText' => 'Group Key <i style="cursor: pointer; margin-left: 4px !important;" class="fas fa-exclamation-circle ms-2 fs-7" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-trigger="hover" data-bs-original-title="Leave blank if permission was single (not in a group)" data-bs-custom-class="tooltip-white"></i>',
                                    'elOptions' => [
                                        'placeholder' => 'Please enter Group Key here'
                                    ]
                                ]) 
                            }}
                        </div>
                        <div class="col-6">
                            

                            {{ Form::textInput('group_label', null, ['formAlignment' => 'vertical']) }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            {{ 
                                Form::textInput('action_key', null, [
                                    'formAlignment' => 'vertical',
                                    'required' => 'required',
                                    'addons' => ['text' => '<span class="fw-bolder" id="group-key-addon">-</span>']
                                ]) 
                            }}
                        </div>
                        <div class="col-6">
                            {{ 
                                Form::textInput('action_label', null, [
                                    'formAlignment' => 'vertical',
                                ]) 
                            }}
                        </div>
                    </div>

                    {{-- <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label class=" col-form-label">
                                    <strong>Permission Key</strong>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <div id="permission-key" class="badge badge-dark fs-7 py-3 px-4 mt-1"> acl.index </div>
                            </div>
                        </div>
                    </div> --}}

                    <div class="row">
                        <div class="col-6">
                            {{ 
                                Form::select2Input('url_method', null, [
                                    'POST' => 'POST',
                                    'GET' => 'GET',
                                    'PATCH' => 'PATCH',
                                    'PUT' => 'PUT',
                                    'DELETE' => 'DELETE',
                                ], [
                                    'formAlignment' => 'vertical',
                                    'labelText' => 'URL Method',
                                    'elOptions' => [
                                        'placeholder' => 'Please enter URL Method here'
                                    ]
                                ]) 
                            }}
                        </div>
                        <div class="col-6">
                            {{ 
                                Form::textInput('url', null, [
                                    'formAlignment' => 'vertical',
                                    'labelText' => 'URL <i style="cursor: pointer; margin-left: 4px !important;" class="fas fa-exclamation-circle ms-2 fs-7" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-trigger="hover" data-bs-original-title="URL permission will not be implemented if URL Method and URL were empty" data-bs-custom-class="tooltip-white"></i>',
                                    'elOptions' => [
                                        'placeholder' => 'Please enter URL here'
                                    ]
                                ]) 
                            }}
                            
                        </div>

                    </div>

                    <button id="modal-form-delete" onclick="deleteAction()" type="button" class="btn btn-danger my-2 fw-bold">
                        <i class="ki-duotone ki-trash-square fs-4">
                         <i class="path1"></i>
                         <i class="path2"></i>
                         <i class="path3"></i>
                         <i class="path4"></i>
                        </i>

                        <span class="indicator-label">Delete Permission</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>

                </form>
            </div>

            <div class="modal-footer" style="justify-content: flex-end;">

                <div>
                    {{-- <button type="button" class="btn btn-sm btn-success" onclick="clearForm();">Clear</button> --}}
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
</div>

@push('additional-js')

<script type="text/javascript">

    $('#modal-form-submit').click(function(){

        var data = {}

        if($('#id').val()) data.id = $('#id').val();
        data.group_key = $('#group_key').val();
        data.group_label = $('#group_label').val();
        data.action_key = $('#action_key').val();
        data.action_label = $('#action_label').val();
        data.url = $('#url').val();
        data.url_method = $('#select2-url_method').val();

        // Swal.fire({
        //     text: "Data will be saved!",
        //     icon: 'question',
        //     showCancelButton: true,
        //     buttonsStyling: false,
        //     confirmButtonText: "Yes, save it!",
        //     cancelButtonText: "Cancel",
        //     stopKeydownPropagation: false,
        //     customClass: {
        //         confirmButton: "btn btn-primary",
        //         cancelButton: "btn btn-active-light"
        //     }
        // }).then(function(choice) {

        //     if (choice.value) {

                $.ajax({
                    type: "POST",
                    url:  '{{ route('permission.save') }}',
                    data: data,
                    beforeSend: function(){   
                        // getBlockUI().block();
                        submitProcess('modal-form-submit');
                    },
                    success: function (result) {

                        if(result.success == true){
                            clearForm();
                            getData();
                            $('#modal-form').modal('hide');
                            // Swal.fire("Success!", result.msg, "success");
                        }else{
                            // Swal.fire("Error!", result.msg, "error");

                            // $('.error-container').html('');
                            // displayErrorInput(result.errors);

                            swaling({'text': result.message, 'icon': 'error'})
                            displayErrorInput($('#form-permission'), result.errors);
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        console.log(errorThrown);
                        // toastr.error("Request Failed.", "System Error");
                        toasting()
                    }
                }).always(function(){
                    // getBlockUI().release();
                    submitProcess('modal-form-submit', 1);
                });
        //     }
        // });

    })

    function clearForm(){
        $('#form-permission :input').each(function(){
            var inputType = $(this).attr('type')
            if($(this).is("select")){
                if($(this).data('multiple') == 1){
                    var name = $(this).attr('name').replace('multiple','').replace(/_/g,'');
                    var el = $(this).closest('.row').find('.'+name+'_row');

                    $.each(el,function(key,item){
                        var id = $(item).attr('id').replace('row','').replace(/_/g,'');
                        window['deleteRow_' + name](id);
                    })
                }else{
                    $(this).val('').trigger('change');
                }
            }else{
                if(inputType == 'checkbox'){
                    if($(this).is(':checked')){
                        $(this).click();
                    }
                }else if(inputType == 'radio'){
                    // DO NOTHING, SEE BELOW
                }else if(inputType == 'file'){
                    // $(this).fileinput('clear');
                    window['previewFile_' + $(this).attr('id')]();
                }else{
                    if($(this).hasClass('flatpickr-input')){
                        $(this)[0]._flatpickr.clear();
                    }else{
                        $(this).val('').trigger('change');
                    }
                }
            }

            $('.error-container').html('');
        });

        $('#form-permission .m-radio-inline').each(function(){
            $(this).find("input[type=radio]:first").click();
        });

        $('.form-only-edit').hide();

        $('#group-key-addon').html(' - ');
    }

    $('#group_key').on('change', function(){
        $('#group-key-addon').html($(this).val()+'.')
        permissionKeyGenerate()
    })

    $('#action_key').on('change', function(){
        permissionKeyGenerate()
    })

    $('#action').on('change', function(){
        if(!$('#select2-method').val()) $('#select2-method').val('POST').trigger('change')
    })

    function permissionKeyGenerate() {
        $('#permission-key').html($('#group_key').val()+'.'+$('#action_key').val())
    }

    function deleteAction() {

        Swal.fire({
            text: "Permission and ACL related will be deleted!",
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
        }).then(function(result) {

            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url:  '{{ url('permission/delete') }}' + '/' + $('#id').val(),
                    beforeSend: function(){   
                        // getBlockUI().block();
                        submitProcess('modal-form-delete');
                    },
                    success: function (res) {

                        if(res.success == true){
                            getData();
                            $('#modal-form').modal('hide');
                            // Swal.fire("Success!", res.msg, "success");
                        }else{
                            // Swal.fire("Error!", res.msg, "error");
                            swaling({'text': result.message, 'icon': 'error'})
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        console.log(errorThrown);
                        toasting();
                    }
                }).always(function(){
                    // getBlockUI().release();
                    submitProcess('modal-form-delete', 1);
                });
            }
        });

    }

</script>

@endpush