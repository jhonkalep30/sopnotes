<div class="modal fade" tabindex="-1" id="modal-group">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Group Permission</h3>
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
                <form id="form-group" enctype="multipart/form-data">

                    <input type="hidden" id="edit_group_old_key" name="edit_group_old_key" value="">

                    {{ 
                        Form::textInput('edit_group_key', null, [
                            'required' => 'required',
                            'labelText' => 'Group Key',
                        ]) 
                    }}

                    {{ Form::textInput('edit_group_label') }}
                    
                    <button onclick="deleteGroup()" type="button" id="modal-group-delete" class="btn btn-danger my-2 fw-bold">
                        {{-- <i class="ki-duotone ki-trash-square fs-4">
                         <i class="path1"></i>
                         <i class="path2"></i>
                         <i class="path3"></i>
                         <i class="path4"></i>
                        </i> --}}

                        <span class="indicator-label">Delete Group</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>

                </form>
            </div>

            <div class="modal-footer" style="justify-content: flex-end;">
                {{-- <button type="button" class="btn btn-sm btn-success" onclick="clearForm();">Clear</button> --}}

                {{-- <button onclick="deleteGroup()" type="button" id="modal-group-delete" class="btn btn-danger my-2 fw-bold">
                    <i class="ki-duotone ki-archive fs-3">
                     <i class="path1"></i>
                     <i class="path2"></i>
                     <i class="path3"></i>
                    </i>

                    Delete Group
                </button> --}}

                <div>
                    <button type="button" class="btn btn-active-light me-3" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="modal-group-submit" class="btn btn-primary">
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

    $('#modal-group-submit').click(function(){

        var data = {}

        data.edit_group_key = $('#edit_group_key').val();
        data.edit_group_old_key = $('#edit_group_old_key').val();
        data.edit_group_label = $('#edit_group_label').val();


        Swal.fire({
            text: "Editing Group Key will affect all permission key!",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, update it!",
            cancelButtonText: "Cancel",
            stopKeydownPropagation: false,
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-active-light"
            }
        }).then(function(choice) {

            if (choice.value) {

                $.ajax({
                    type: "POST",
                    url:  '{{ route('permission.edit-group') }}',
                    data: data,
                    beforeSend: function(){   
                        // getBlockUI().block();
                        submitProcess('modal-group-submit');
                    },
                    success: function (result) {

                        if(result.success == true){
                            getData();
                            $('#modal-group').modal('hide');
                            // Swal.fire("Success!", result.msg, "success");
                        }else{
                            // Swal.fire("Error!", result.msg, "error");

                            // $('.error-container').html('');
                            // displayErrorInput(result.errors);

                            swaling({'text': result.message, 'icon': 'error'})
                            displayErrorInput($('#form-group'), result.errors);
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        console.log(errorThrown);
                        // toastr.error("Request Failed.", "System Error");
                        toasting()
                    }
                }).always(function(){
                    // getBlockUI().release();
                    submitProcess('modal-group-submit', 1);
                });
            }
        });

    })

    function deleteGroup() {
        
        var data = {}

        data.group_key = $('#edit_group_key').val();

        Swal.fire({
            text: "Group, Permission and ACL related will be deleted!",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            stopKeydownPropagation: false,
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-active-light"
            }
        }).then(function(choice) {

            if (choice.value) {
                $.ajax({
                    type: "POST",
                    url:  '{{ route('permission.delete-group') }}',
                    data: data,
                    beforeSend: function(){   
                        // getBlockUI().block();
                        submitProcess('modal-group-delete');
                    },
                    success: function (result) {

                        if(result.success == true){
                            getData();
                            $('#modal-group').modal('hide');
                            // Swal.fire("Success!", result.msg, "success");
                        }else{
                            // Swal.fire("Error!", result.msg, "error");
                            swaling({'text': result.message, 'icon': 'error'})
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        console.log(errorThrown);
                        // toastr.error("Request Failed.", "System Error");
                        toasting()
                    }
                }).always(function(){
                    // getBlockUI().release();
                    submitProcess('modal-group-delete', 1);

                });
            }
        });

    }


</script>

@endpush