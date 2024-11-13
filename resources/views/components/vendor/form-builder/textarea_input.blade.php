@php
if (!is_array($attributes)) $attributes = [];
$config = FormBuilderHelper::setupDefaultConfig($name, $attributes);
if($config['elOptions']['class']) $config['elOptions']['class'] .= ' form-control-solid';
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

			{{ Form::textarea($name, $value, $config['elOptions']) }}

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
	$('textarea[name="{{ $name }}"]').keyup(function() {
		$(this).parents('.form-group').removeClass('has-danger')
		$(this).parents('.form-group').find('.error-container').html('');
	})
</script>
@endpush