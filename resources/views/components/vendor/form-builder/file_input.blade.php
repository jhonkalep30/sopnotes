@php
if (!is_array($attributes)) $attributes = [];
$config = FormBuilderHelper::setupDefaultConfig($name, $attributes, $errors);
$config['pluginOptions']['theme'] = "bs5";
$config['pluginOptions']['browseClass'] = $config['pluginOptions']['browseClass'] ?? "btn btn-primary";
$config['pluginOptions']['removeClass'] = $config['pluginOptions']['removeClass'] ?? "btn btn-light-danger";
$config['pluginOptions']['inputGroupClass'] = $config['pluginOptions']['inputGroupClass'] ?? "input-group-sm";

@endphp

<div class="{{ $config['divContainerClass'] }} {{ !$errors->has($name) ?: 'has-danger' }}">
	@if ($config['useLabel'])
	<div class="row">
		<div class="{{ $config['labelContainerClass'] }}">
			<label class="{{ @$config['required'] ? 'required' : '' }} col-form-label">
				{!! $config['labelText'] !!}
			</label>
		</div>
		<div class="{{ $config['inputContainerClass'] }}">
	@endif
			@if (!empty($config['addons']))
			<div class="input-group m-input-group">
				@if ($config['addons']['position'] === 'left')
				<span class="{{ $config['addons']['class'] }} addon-left-side">{{ $config['addons']['text'] }}</span>
				@endif
			@endif

			@php
				$allowedExt = [];
				foreach(@$config['pluginOptions']['allowedFileExtensions'] ?? [] as $ext){
					$allowedExt[] = '.'.$ext;
				}
			@endphp

			<input type="file" accept="{{ count(@$allowedExt ?? []) > 0 ? implode(', ', $allowedExt) : '*' }}" name="{{ $name }}{{@$config['elOptions']['multiple'] ? '[]' : ''}}" {!! $config['htmlOptions'] !!}>

			@if (!empty($config['addons']))
				@if ($config['addons']['position'] === 'right')
				<span class="{{ $config['addons']['class'] }} addon-right-side">{{ $config['addons']['text'] }}</span>
				@endif
			</div>
			@endif

			@if(@$config['info'])
				<div class="form-text">{!! @$config['info'] !!}</div>
			@endif

			<div class="error-container">
				@if($errors->has($name))
	            <div class="form-control-feedback">{{ $errors->first($name) }}</div>
				@endif
			</div>

	@if ($config['useLabel'])
		</div>
	</div>
	@endif
</div>

@push('additional-css')
<!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
<!-- link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" /-->
<!-- the font awesome icon library if using with `fas` theme (or Bootstrap 4.x). Note that default icons used in the plugin are glyphicons that are bundled only with Bootstrap 3.x. -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
@endpush

@push('additional-js')
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/plugins/piexif.min.js" type="text/javascript"></script>
<!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
    This must be loaded before fileinput.min.js -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/plugins/sortable.min.js" type="text/javascript"></script>
<!-- the main fileinput plugin file -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/fileinput.min.js"></script>
<!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`) -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/themes/fas/theme.min.js"></script>

<script type="text/javascript">
    var newPluginOptions_{{$config['elOptions']['id']}} = {!! json_encode($config['pluginOptions']) !!};
	$(document).ready(function() {

		// $.fn.fileinputBsVersion = "4.5.0";

		@if($value)
			previewFile_{{$config['elOptions']['id']}}()
		@endif

		$("#{{ $config['elOptions']['id'] }}").fileinput(newPluginOptions_{{$config['elOptions']['id']}});
	    
	    @if(@$attributes['deleteUrl'])
		    $('#{{$config['elOptions']['id']}}').closest('.input-group').find('.fileinput-remove-button').on('click',function(){
		    	var name = $('#{{$config['elOptions']['id']}}').attr('name');
		    	var value = $('#{{$config['elOptions']['id']}}').val();
		    	
		    	if(value == ''){
		    		Swal.fire({
		                title: "Delete this file?",
		                text: "You can't undo this action!",
		                icon: "warning",
		                showCancelButton: true,
		                confirmButtonText: "Yes, delete it!"
		            }).then(function(result) {
		                if (result.value) {
					    	$.ajax({
					            type: "POST",
					            url:  '{{$attributes['deleteUrl']}}',
					            data: {[name]:'{{$value}}'},
					            beforeSend: function()
					            {   

					            },
					            success: function (result) {
					            	console.log(result);
					            },
					            error: function(xhr, textStatus, errorThrown){
					            	console.log(errorThrown);
					            	toastr.error("Request Failed.", "System Error");
					            }
					        });
		                }
		            });
		    	}else{
		    		$('#{{$config['elOptions']['id']}}').fileinput('clear');
		    	}
		    });
	    @endif
	});

	function previewFile_{{$config['elOptions']['id']}}(uploadable = true, params = {}) {
        if(params.injectFile){
        	newPluginOptions_{{$config['elOptions']['id']}}.initialPreview = params.injectFile;
        	newPluginOptions_{{$config['elOptions']['id']}}.initialCaption = 'Select image to replace existed'
        }else{
        	newPluginOptions_{{$config['elOptions']['id']}}.initialPreview = '{{$value}}';
        }

        @if(@$attributes['withoutFilePreview'])
	        newPluginOptions_{{$config['elOptions']['id']}}.initialPreviewAsData = false;
	        newPluginOptions_{{$config['elOptions']['id']}}.showPreview = false;
        @else
	        newPluginOptions_{{$config['elOptions']['id']}}.initialPreviewAsData = true;
	        newPluginOptions_{{$config['elOptions']['id']}}.showPreview = params.showPreview ?? true;
        @endif

        newPluginOptions_{{$config['elOptions']['id']}}.initialPreviewShowDelete = false;
        newPluginOptions_{{$config['elOptions']['id']}}.showRemove = params.showRemove ?? true;
        newPluginOptions_{{$config['elOptions']['id']}}.showClose = params.showClose ?? true;

        if(!uploadable){
            newPluginOptions_{{$config['elOptions']['id']}}.showBrowse = false;
            newPluginOptions_{{$config['elOptions']['id']}}.showCaption = false;
        }

        $('#{{$config['elOptions']['id']}}').fileinput('clear');
        if ($('#{{$config['elOptions']['id']}}').data('fileinput')) {
            $('#{{$config['elOptions']['id']}}').fileinput('destroy');
        }

        $('#{{$config['elOptions']['id']}}').fileinput(newPluginOptions_{{$config['elOptions']['id']}});

        return newPluginOptions_{{$config['elOptions']['id']}};
    }

</script>
@endpush