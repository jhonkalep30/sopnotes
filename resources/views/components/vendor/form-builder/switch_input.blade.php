@php
if (!is_array($attributes)) $attributes = [];
$config = FormBuilderHelper::setupDefaultConfig($name, $attributes, $errors);

$useLabel = true;
if (isset($attributes['useLabel'])) {
	$useLabel = $attributes['useLabel'];
	unset($attributes['useLabel']);
}

$labelText = $labelText = isset($attributes['labelText']) ? $attributes['labelText'] : ucwords(implode(' ', explode('_', $name))) . (isset($attributes['required']) ? ' <span class="status-decline">*</span>' : '');

$formAlignment = 'horizontal';
if (isset($attributes['formAlignment'])) {
	$formAlignment = $attributes['formAlignment'];
	unset($attributes['formAlignment']);
}


$labelContainerClass = $formAlignment === 'vertical' ? 'col-md-12' : 'col-md-3';
$inputContainerClass = $formAlignment === 'vertical' ? 'col-md-12' : 'col-md-9';
if ($formAlignment === 'horizontal') {
	if (isset($attributes['labelContainerClass'])) {
		$labelContainerClass = $attributes['labelContainerClass'];
		unset($attributes['labelContainerClass']);
	}
	if (isset($attributes['inputContainerClass'])) {
		$inputContainerClass = $attributes['inputContainerClass'];
		unset($attributes['inputContainerClass']);
	}
}


$configAttributes = array_merge([
	'class' => "form-check-input",
], @$attributes['elOptions'] ?? []);

$formattedAttributes = '';
foreach ($configAttributes as $attribute => $attributeValue) {
	$formattedAttributes .= $attribute . '="' . $attributeValue . '" ';
}

@endphp

<div class="{{ $config['divContainerClass'] }} {{ !$errors->has($name) ?: 'has-error' }}">
	@if ($useLabel)
	<div class="row">
		<div class="{{ $labelContainerClass }}">
			<label class="{{ @$config['required'] ? 'required' : '' }} col-form-label">
				{!! $config['labelText'] !!}
			</label>
		</div>
		<div class="{{ $inputContainerClass }}" style="vertical-align: middle !important;">
	@endif

			<div class="form-check form-switch form-check-custom form-check-solid {{ $formAlignment === 'horizontal' ? 'mt-2' : '' }}">
			    <input class="form-check-input" type="checkbox" id="{{@$config['elOptions']['id'] ?? $name}}" <?= $formattedAttributes ?>>
				<input type="hidden" name="{{$name}}" id="hidden_{{$config['elOptions']['id']}}" value="{{@$value ?? 0}}">
			    <label class="form-check-label" for="flexSwitchDefault">
			        {!! @$switchText ?? @$config['switchText'] !!}
			    </label>
			</div>

			@if($errors->has($name))
			<span id="helpBlock2" class="help-block">{{ $errors->first($name) }}</span>	
			@endif

	@if ($useLabel)
		</div>
	</div>
	@endif
</div>

@push('vendor-css')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/mswitch/css/jquery.mswitch.css') }}">
@endpush

@push('vendor-js')
<script type="text/javascript" src="{{ asset('vendor/mswitch/js/jquery.mswitch.js') }}"></script>
<script type="text/javascript">
	@if (isset($configAttributes['id']))
		$("#{{ $configAttributes['id'] }}").mSwitch();
	@else
		$(".m_switch_check:checkbox").mSwitch();
	@endif
</script>
@endpush

@push('additional-js')
<script type="text/javascript">
	$('#{{$config['elOptions']['id']}}').prop('checked', {{ @$value == 1 ? 'true' : 'false' }})

	$('#{{$config['elOptions']['id']}}').change(function(){
		$('#hidden_{{$config['elOptions']['id']}}').val($(this).prop('checked') ? 1 : 0)
	})
</script>
@endpush
