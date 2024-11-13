<form id="{{$name}}_form" enctype="multipart/form-data">
    {!! $slot !!}

    <div class="d-flex flex-row-reverse pt-10 pb-5">
        <button type="button" id="{{$name}}_cancel" class="btn btn-light-danger btn-sm">Cancel</button>
        <button type="button" id="{{$name}}_submit" class="btn btn-light-primary btn-sm me-3">Submit</button>
    </div>
</form>

@push('additional-js')
<script type="text/javascript">
    $('#{{$name}}_cancel').on('click',function(){
        Swal.fire({
            title: 'Do you want to cancel?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.isConfirmed) {
                window.history.back();
            }
        });
    });

	$('#{{$name}}_submit').on('click',function(){
		Swal.fire({
			title: 'Do you want to save the changes?',
			icon: 'question',
		  	showCancelButton: true,
		  	confirmButtonText: 'Save',
		}).then((result) => {
		  	if (result.isConfirmed) {
		    	var formEl = $('#{{$name}}_form')
                var form = formEl[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    url:  '{{$url}}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function()
                    {   
                        $('#{{$name}}_submit').attr('disabled','disabled');
                        $('#{{$name}}_cancel').attr('disabled','disabled');
                    },
                    success: function (res) {
                    	if(res.success){
					    	Swal.fire('Success!', res.message, 'success')
                    	
                            window.location.href = "{{$redirect['url']}}"
                        }else{
						    Swal.fire('Error!', res.message, 'error')
                    	}
                        $('#{{$name}}_submit').removeAttr('disabled');
                        $('#{{$name}}_cancel').removeAttr('disabled');
                    },
                    error: function(xhr, textStatus, errorThrown){
                        $.each(xhr.responseJSON.errors,function(key, item){
                        	formEl.find('input[name="'+key+'"]').closest('.row').find('.error-container').html('<span class="text-danger">'+item[0]+'</span>');
                        	formEl.find('select[name="'+key+'"]').closest('.row').find('.error-container').html('<span class="text-danger">'+item[0]+'</span>');
                        });

					    Swal.fire('Error!', 'System Error', 'error')
                        $('#{{$name}}_submit').removeAttr('disabled');
                        $('#{{$name}}_cancel').removeAttr('disabled');
                    }
                });
		  	}
		})
	})
</script>
@endpush