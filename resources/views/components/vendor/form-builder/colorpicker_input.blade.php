@php
if (!is_array($attributes)) $attributes = [];
$config = FormBuilderHelper::setupDefaultConfig($name, $attributes, $errors);
$config['elOptions']['autocomplete'] = 'off';
@endphp

<div class="{{ $config['divContainerClass'] }} {{ !$errors->has($name) ?: 'has-danger' }}">
	@if ($config['useLabel'])
	<div class="row">
		<div class="{{ $config['labelContainerClass'] }}">
			<label class="col-form-label">
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

				{{ Form::text($name, $value, $config['elOptions']) }}

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

@section('additional-css')
<link href="{{asset('vendor/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css')}}" rel="stylesheet">
@endsection

@section('additional-js')
<script src="{{asset('vendor/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js')}}"></script>
@endsection

@push('additional-js')
<script type="text/javascript">
	$(document).ready(function(){
		$('#{{$config['elOptions']['id']}}').colorpicker();
	})

	$('input[name="{{ $name }}"]').keyup(function() {
		$(this).parents('.form-group').removeClass('has-danger')
		$(this).parents('.form-group').find('.error-container').html('');
	})
</script>
@endpush