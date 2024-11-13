@php
	$title = $title ?? ucwords(str_replace('_', ' ', $table));
@endphp

<!-- Modal Ajax Form -->
<div class="modal fade" tabindex="-1" id="{{$table}}_modal_export">
    <div class="modal-dialog modal-md 'modal-dialog-centered'">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="fw-bold">Export {{$title}}</h3>

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
                <form id="{{$table}}_form_export" enctype="multipart/form-data">
                    {{ 
                        Form::select2Input('type','xlsx',[
                            'xlsx' => 'Excel',
                        ],[
                            'elOptions' => [
                                'id' => 'select2-export-type-'.$table,
                            ]
                        ])
                    }}

                    {{ 
                        Form::select2Input('method','queue',[
                            'queue' => 'Running in Background',
                            'direct' => 'Direct Download',
                        ],[
                            'elOptions' => [
                                'id' => 'select2-export-method-'.$table,
                            ]
                        ])
                    }}
                </form>
            </div>

            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-active-light" data-bs-dismiss="modal">Close</button>
                <button type="button" id="{{$table}}_export_submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

@push('additional-js')
<script type="text/javascript">
    $('#{{$table}}_export_submit').on('click',function(){

        if($('#select2-method').val() == 'queue'){
            Swal.fire({
                title: 'Export this data?',
                text: "While using 'Running in Background', you can see status on queue menu.",
                icon: 'question',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Submit",
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then((choice) => {
                if (choice.isConfirmed) {
                    exportProcess_{{$table}}()
                }
            })
        }else{
            exportProcess_{{$table}}()
        }

        
    })

    function exportProcess_{{$table}}(argument) {

        var formEl = $('#{{$table}}_form_export')
        var form = formEl[0];
        var formData = new FormData(form);

        formData.append('response_type','json');

        @if(@$filter)
            $.each(filter_{{$filter}}, function(index, value){
                formData.append(index, value);
            })
        @endif

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

                    if(result.data.url && result.data.filename){
                        // console.log(result.data.url)

                        var link = document.createElement('a');
                        link.href = result.data.url;
                        link.target = '_blank';
                        link.download = result.data.filename;
                        
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                    }else{
                        swaling({'text': result.message, 'icon': 'success'})
                    }

                    $('#{{$table}}_modal_export').modal('hide');
                }else{
                    swaling({'text': result.message, 'icon': 'error'})
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
</script>
@endpush