@php
if (!is_array($attributes)) $attributes = [];
$config = FormBuilderHelper::setupDefaultConfig($name, $attributes);
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
			@if (!empty($config['addonsConfig']))
			<div class="input-group">
				@if ($config['addonsConfig']['position'] === 'left')
				<span class="{{ $config['addons']['class'] }} addon-left-side">{{ $config['addonsConfig']['text'] }}</span>
				@endif
			@endif

				{{ Form::number($name, $value, $config['elOptions']) }}

			@if (!empty($config['addonsConfig']))
				@if ($config['addonsConfig']['position'] === 'right')
				<span class="{{ $config['addons']['class'] }} addon-right-side">{{ $config['addonsConfig']['text'] }}</span>
				@endif
			</div>
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

@push('additional-js')
<script type="text/javascript">
	$('input[name="{{ $name }}"]').on('keyup, change', function() {
		$(this).parents('.form-group').removeClass('has-danger')
		$(this).parents('.form-group').find('.error-container').html('');
	})
</script>
@endpush