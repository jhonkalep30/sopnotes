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
			@if(@$config['withEyeIcon'])
				<div class="input-group input-group-solid m-input-group">
					{{ Form::password($name, $config['elOptions']) }}
					<span class="input-group-text">
					    <i class="fa fa-eye" id="togglePassword_{{ @$config['elOptions']['id'] ?? $name }}" style="cursor: pointer"></i>
					</span>
				</div>
			@else

				@if (!empty($config['addons']))
				<div class="input-group input-group-solid m-input-group">
					@if ($config['addons']['position'] === 'left')
					<span class="{{ $config['addons']['class'] }} addon-left-side">{{ $config['addons']['text'] }}</span>
					@endif
				@endif

					{{ Form::password($name, $config['elOptions']) }}

				@if (!empty($config['addons']))
					@if ($config['addons']['position'] === 'right')
					<span class="{{ $config['addons']['class'] }} addon-right-side">{{ $config['addons']['text'] }}</span>
					@endif
				</div>
				@endif

			@endif
			

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

@push('additional-js')
<script type="text/javascript">
	$('input[name="{{ $name }}"]').keyup(function() {
		$(this).parents('.form-group').removeClass('has-danger')
		$(this).parents('.form-group').find('.error-container').html('');
	})
</script>
@endpush

@if(@$config['withEyeIcon'])

	@push('additional-css')

	<style type="text/css">
		input[name="{{ @$config['elOptions']['id'] ?? $name }}"][type="password"]::-ms-reveal,
		input[name="{{ @$config['elOptions']['id'] ?? $name }}"][type="password"]::-ms-clear {
		  display: none;
		}

		input[name="{{ @$config['elOptions']['id'] ?? $name }}"]::-ms-reveal,
		input[name="{{ @$config['elOptions']['id'] ?? $name }}"]::-ms-clear {
		  display: none;
		}
	</style>

	@endpush

	@push('additional-js')
		<script type="text/javascript">
			const togglePassword_{{ @$config['elOptions']['id'] ?? $name }} = document.querySelector("#togglePassword_{{ @$config['elOptions']['id'] ?? $name }}");
			const password_{{ @$config['elOptions']['id'] ?? $name }} = document.querySelector("#{{ @$config['elOptions']['id'] ?? $name }}");

			togglePassword_{{ @$config['elOptions']['id'] ?? $name }}.addEventListener("click", function () {
			   
			  // toggle the type attribute
			  const type = password_{{ @$config['elOptions']['id'] ?? $name }}.getAttribute("type") === "password" ? "text" : "password";
			  password_{{ @$config['elOptions']['id'] ?? $name }}.setAttribute("type", type);
			  // toggle the eye icon
			  this.classList.toggle('fa-eye');
			  this.classList.toggle('fa-eye-slash');
			});
		</script>
	@endpush

@endif