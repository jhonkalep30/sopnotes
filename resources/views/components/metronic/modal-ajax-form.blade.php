@php
	$title = $title ?? ucwords(str_replace('_', ' ', $name));
@endphp

<!-- Modal Ajax Form -->
<div class="modal fade" tabindex="-1" id="{{$name}}">
    <div class="modal-dialog modal-{{$size ?? 'lg'}} {{@$onTop ? '' : 'modal-dialog-centered'}} {{ @$additionalClass }}">
        <div class="modal-content" id="modalContent_{{$name}}">

            <div class="modal-header">
                <!--begin::Modal title-->
                <h3 class="fw-bold modal-title" id="{{$name}}_modal_title">{{ $title }}</h3>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body mx-5" style="max-height: 60vh; overflow-y: scroll;">
                <form id="{{$name}}_form" enctype="multipart/form-data">
                    {!! $slot !!}
                </form>
            </div>

            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-active-light me-3" data-bs-dismiss="modal">Close</button>

                @if(@$withDefaultSubmit ?? true)
                <button type="button" id="{{$name}}_ajax_submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                    <span class="indicator-label">Submit</span>
                    <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                @endif

            </div>
        </div>
    </div>
</div>

@if(@$withDefaultJS ?? true)
    @push('additional-js')
    <script type="text/javascript">
    	function clearForm_{{$name}}() {
    		$.each($('#{{$name}}_form input'),function(){
        		if($(this).attr('type') != null){
            		$(this).val('');
        		}
        	});

        	$.each($('#{{$name}}_form select'),function(){
    			$(this).val(null).trigger('change');
        	});

    	}

    	$('#{{$name}}_ajax_submit').on('click',function(){

    		// Swal.fire({
    		// 	text: 'Do you want to save the changes?',
    		// 	icon: 'question',
    		//   	showCancelButton: true,
    		//   	buttonsStyling: false,
      //           confirmButtonText: "Submit",
      //           cancelButtonText: "Cancel",
      //           customClass: {
      //               confirmButton: "btn btn-primary",
      //               cancelButton: "btn btn-active-light"
      //           }
    		// }).then((choice) => {
    		//   	if (choice.isConfirmed) {
    		    	var formEl = $('#{{$name}}_form')
                    var form = formEl[0];
                    var formData = new FormData(form);

                    // formData.append('response_type','json');

                    $.ajax({
                        type: "POST",
                        url:  '{{$url}}',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function()
                        {   
                            $('#{{$name}}_ajax_submit').attr('data-kt-indicator', 'on').attr('disabled','disabled');
                        },
                        success: function (result) {
                        	if(result.success){
                                // swaling({'text': result.message, 'icon': 'success'})
                                clearForm_{{$name}}()
    					    	dataTableReload_{{ $table }}()
    					    	$('#{{$name}}').modal('hide');
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
                        $('#{{$name}}_ajax_submit').removeAttr('data-kt-indicator').removeAttr('disabled');
                    })

    		//   	}
    		// })
    	})
    </script>
    @endpush
@endif