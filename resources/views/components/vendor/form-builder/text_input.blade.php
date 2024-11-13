@php
if (!is_array($attributes)) $attributes = [];
$config = FormBuilderHelper::setupDefaultConfig($name, $attributes, $errors);
if(@$config['required']) $config['elOptions']['required'] = 'required';
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
			<div class="input-group input-group-solid m-input-group">
				@if ($config['addons']['position'] === 'left')
				<span class="{{ $config['addons']['class'] }} addon-left-side">{!! $config['addons']['text'] !!}</span>
				@endif
			@endif

				{{ Form::text($name, $value, $config['elOptions']) }}

			@if (!empty($config['addons']))
				@if ($config['addons']['position'] === 'right')
				<span class="{{ $config['addons']['class'] }} addon-right-side">{!! $config['addons']['text'] !!}</span>
				@endif
			</div>
			@endif

			<div class="error-container">
				@if($errors->has($name))
	            <div class="form-control-feedback">{{ $errors->first($name) }}</div>
				@endif
				{{-- <div class="form-control-feedback">Field is required</div> --}}
			</div>

            {!! @$config['info'] !!}

	@if ($config['useLabel'])
		</div>
	</div>
	@endif
</div>

@push('additional-js')
<script type="text/javascript">
	$('input[name="{{ $name }}"]').keyup(function() {
		$(this).parents('.form-group').removeClass('has-danger')
		$(this).parents('.form-group').find('.error-container').html('');
	})
</script>
@endpush