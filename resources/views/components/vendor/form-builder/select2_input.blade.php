@php
if (!is_array($attributes)) $attributes = [];
$isDataRequestByAjax = is_array($options) ? false : true;
$url = $options;

// SET DEFAULT CLASS
$attributes['elOptions']['class'] = ($attributes['elOptions']['class'] ?? 'form-control form-control-solid') . ' ' . @$attributes['elOptions']['additionalClass'];

// SET DEFAULT ID
$attributes['elOptions']['id'] = $attributes['elOptions']['id'] ?? 'select2-' . $name;

// SET DEFAULT FOR FORMATTED SELECT2 DATA FORMAT
$attributes['text'] = $attributes['text'] ?? 'obj.name';
$attributes['key'] = isset($attributes['key']) ? "obj.".$attributes['key'] : 'obj.id';

// CALLING SETUP DEFAULT CONFIG
$config = FormBuilderHelper::setupDefaultConfig($name, $attributes, true);
$config['pluginOptions'] = $attributes['pluginOptions'] ?? [];
$config['ajaxParams'] = $attributes['ajaxParams'] ?? [];

$fieldName = isset($config['pluginOptions']['multiple']) && $config['pluginOptions']['multiple'] ? $name . '[]' : $name;
$fieldName = $config['elOptions']['name'] ?? $fieldName;

// FORMATTING TEXT BY TEMPLATE 
// if (is_array($config['text'])) {
// 	$text = null;
// 	foreach ($config['text']['field'] as $field) {
// 		$text = str_replace("<<$field>>", "'+ obj.$field +'", $text ?? $config['text']['template']);
// 	}
// str_replace_array('<<field>>', $config['text']['field'], $config['text']['template']); // Laravel str helper method 
// 	$config['text'] = "'" . $text . "'";
// }
@endphp

<div class="{{ $config['divContainerClass'] }} {{ !$errors->has($name) ?: 'has-danger' }}" <?= @$config['containerHtmlOptions'] ?>>
	@if ($config['useLabel'])
	<div class="row">
		<div class="{{ $config['labelContainerClass'] }}">
			<label class="{{ @$config['required'] ? 'required' : '' }} col-form-label">
				{!! $config['labelText'] !!}
			</label>
		</div>
		<div class="{{ $config['inputContainerClass'] }}">
	@endif

			<select {{ @$config['required'] ? 'required' : '' }} name="{{ $fieldName }}" <?= $config['htmlOptions'] ?> ajax="{{ $isDataRequestByAjax ? 1 : 0 }}">

				@if (!$isDataRequestByAjax)
					<option></option>
					@foreach ($options as $key => $option)
		                <option value="{{ $key }}">{{ $option }}</option>
					@endforeach
				@endif

            </select>

            <div class="error-container">
	            @if($errors->has($name))
	            <div class="form-control-feedback">{{ $errors->first($name) }}</div>
				@endif
            </div>

            {!! @$config['info'] !!}

	@if ($config['useLabel'])
		</div>
	</div>
	@endif
</div>

@push('additional-css')
<style type="text/css">
	.select2-selection__rendered{
		color: #5e6278 !important;
	}
	.select2-selection__clear{
		right: 15px !important;
	}
	.select2-selection.with-icon>.select2-selection__clear{
		right: 3rem !important;
	}
</style>
@endpush

@push('additional-js')
<script type="text/javascript">
		var select2Options_{{$name}} = Object.assign({
				placeholder: "{{ $config['elOptions']['placeholder'] }}",
		    	allowClear: "{{ $config['pluginOptions']['allowClear'] ?? true }}",
			}, {!! json_encode($config['pluginOptions']) !!})

		function select2FormatResult_{{$name}} (data){
			let render = true;
			try{
				let textObject = $('<div>'+data.text+'</div>');
				render = textObject.length > 0 ? true : false;
			}catch(err){
				render = false;
			}

	     	return render ? $('<div>'+data.text+'</div>') : data.text;
	  	};

	  	function select2FormatSelection_{{$name}} (data){
	     	let render = true;
			try{
				let textObject = $('<div>'+data.text+'</div>');
				render = textObject.length > 0 ? true : false;
			}catch(err){
				render = false;
			}

	     	return render ? $('<div>'+data.text+'</div>') : data.text;
	  	};

	  	// TEMPLATE RESULT
		select2Options_{{$name}}.templateResult = select2FormatResult_{{$name}}
		select2Options_{{$name}}.templateSelection = select2FormatSelection_{{$name}}

		// IF THE SELECT2 IS REQUEST DATA BY AJAX
		@if ($isDataRequestByAjax)
		select2Options_{{$name}}.ajax = {
			delay: 250,
			url: "{!! $url !!}",
			type: "POST",
			data: function(params) {
				var data = {
					q: params.term,
					page: params.page,
					paginate: 10
				}
				@foreach ($config['ajaxParams'] as $key => $val)
					data.{{$key}} = {!! $val !!}
				@endforeach

				data.filter = {};
				@if(isset($config['injectFilter']))
					
					@foreach ($config['injectFilter'] as $searchKey => $searchFilter)
						data.filter.{{$searchKey}} = {};

						@foreach ($searchFilter as $groupKey => $groupValue)

							@if(!is_array($groupValue))
								data.filter.{{$searchKey}}[{{$groupKey}}] = '{{$groupValue}}'
								@php continue; @endphp
							@endif

							data.filter.{{$searchKey}}[{{$groupKey}}] = {};

							@foreach ($groupValue as $filterKey => $filterValue)
								data.filter.{{$searchKey}}[{{$groupKey}}].{{$filterKey}} = ('{{$filterValue}}' == '$value') ? params.term : '{{$filterValue}}'
							@endforeach
						@endforeach
					@endforeach
				@endif

				@foreach ($config['ajaxParams'] as $key => $val)
					data.filter.{{$key}} = {!! $val !!}
				@endforeach

				data.filter.q = params.term;

				return data
			},
			processResults: function (data) {
				var result = {},
					isPaginate = data.hasOwnProperty('data'),
					isSimplePaginate = !data.hasOwnProperty('last_page');

	                result.results = $.map(isPaginate ? data.data : data, function (obj) {

	                	if(obj.select2_text){
		                    return {id: {{ $config['key'] }}, text: obj.select2_text, attributes: obj}
	                	}else{
		                    return {id: {{ $config['key'] }}, text: {!! @$config['text'] !!}, attributes: obj}
	                	}

	                })

	                if (isPaginate) {
	                	result.pagination = {
		                	more: isSimplePaginate ? data.next_page_url !== null : data.current_page < data.last_page
		                }
	                }

				return result;
			},
			success: function(data) {
				if(data.success == false){
					var select2Container = $('#{{ $config['elOptions']['id'] }}');
					var errorContainer = select2Container.closest('div').find('.error-container');
					var selectionContainer = select2Container.closest('div').find('.select2-selection').css('border','1px solid #f1416c');
			        errorContainer.html('<small class="text-danger">Warning: '+data.msg+'</small>');
                    select2Container.select2('close');
				}
		    }
		}
		@endif

		// FOR SELECT2 DROPDOWNPARENT
		@if (isset($config['pluginOptions']['dropdownParent']))
		    select2Options_{{$name}}.dropdownParent = $('<?= $config['pluginOptions']["dropdownParent"] ?>')
		@else
			var modalId = $('#{{ $config['elOptions']['id'] }}').parents().closest('.modal').attr('id');
			if(modalId){
		    	select2Options_{{$name}}.dropdownParent = $('#'+modalId)
			}
		@endif

	    var initSelect2_{{ $name }} = $('#{{ $config['elOptions']['id'] }}').select2(select2Options_{{$name}});

	    @if(isset($config['addons']['resultsClass']) && $config['addons']['resultsClass'])
	    	$('#{{ $config['elOptions']['id'] }}').data('select2').$results.addClass('{{$config['addons']['resultsClass']}}')
	    @endif

	    @if(isset($config['addons']['clearWithIcon']) && $config['addons']['clearWithIcon'])
	    	$('#{{ $config['elOptions']['id'] }}').data('select2').$selection.addClass('with-icon')
	    @endif

	    @if(!$isDataRequestByAjax)
			select2val_{{$name}} = {!! !is_array($value) ? json_encode([$value]) : json_encode($value) !!}
		    initSelect2_{{ $name }}.val(select2val_{{$name}}).trigger('change')
		@else
			@if(!empty($value) && is_array($value))
				select2_setValue_{{$name}}({!! json_encode($value) !!})
			@endif
	    @endif


	    // IF VALUE CHANGED TRIGGER
	    $('#{{ $config['elOptions']['id'] }}').change(function() {
			$(this).parents('.form-group').removeClass('has-danger')
			$(this).parents('.form-group').find('.error-container').html('')
		})

	function select2_setValue_{{$name}}(data = []) {

		let isMultiple = '{{ @$config["pluginOptions"]["multiple"] }}'

		if(isMultiple){

			$.each(data, function(key,item){
				if(item[0] !== null){
					var newOption = new Option(item[1], item[0], true, true);
					initSelect2_{{ $name }}.append(newOption);
				}
			})

			initSelect2_{{ $name }}.trigger('change');
		}else{
			if(data[0] !== null){
				var newOption = new Option(data[1], data[0], true, true);
				initSelect2_{{ $name }}.append(newOption);
				initSelect2_{{ $name }}.trigger('change');
			} 
		}

    }

</script>
@endpush