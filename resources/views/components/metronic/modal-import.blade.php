@php
	$title = $title ?? ucwords(str_replace('_', ' ', $table));
@endphp

<!-- Modal Ajax Form -->
<div class="modal fade" tabindex="-1" id="{{$table}}_modal_import">
    <div class="modal-dialog mw-650px 'modal-dialog-centered'">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Import {{$title}}</h3>

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
                <form class="py-4" id="{{$table}}_form_import" enctype="multipart/form-data">
                    {{ 
                        Form::fileInput('file',null,[
                            'useLabel' => false,
                            'pluginOptions' => [
                                'showUpload' => false,
                                'showPreview' => false,
                                'dropZoneEnabled' => false,
                                'allowedFileExtensions' => ['xlsx','xls', 'csv'],
                            ],
                            'info' => 'Please upload file with extension (.xls, .xlsx, or .csv)'
                        ])
                    }}
                </form>
            </div>

            <div class="modal-footer">
                <div class="d-flex" style="flex:auto">
                    <a href="{{$template}}" class="btn btn-light-success">Download Template</a>
                </div>

                <button type="button" class="btn btn-active-light" data-bs-dismiss="modal">Close</button>
                <button type="button" id="{{$table}}_import_submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

@push('additional-js')
<script type="text/javascript">
    $('#{{$table}}_import_submit').on('click',function(){

        Swal.fire({
            title: 'Import this data?',
            text: "You can see import status on queue menu.",
            icon: 'question',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Import",
            cancelButtonText: "Cancel",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-active-light"
            }
        }).then((choice) => {
            if (choice.isConfirmed) {
                var formEl = $('#{{$table}}_form_import')
                var form = formEl[0];
                var formData = new FormData(form);

                formData.append('response_type','json');

                $.ajax({
                    type: "POST",
                    url:  '{{$url}}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function()
                    {   
                        getBlockUI().block();
                    },
                    success: function (result) {
                        if(result.success){
                            $('#{{$table}}_form_import :input[type="file"]').val('').trigger('change');
                            swaling({'text': result.message, 'icon': 'success'})
                            $('#{{$table}}_modal_import').modal('hide');
                        }else{
                            swaling({'text': result.message, 'icon': 'error'})
                            displayErrorInput(formEl, result.errors)
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        console.log(errorThrown);
                        toasting()
                    }
                }).always(function(){
                    getBlockUI().release();
                });
            }
        })
    })
</script>
@endpush