@extends('auth.layout',[
    'formUrl' => route('login'),
    'submitText' => 'Sign In'
])

@section('content')

	<div class="text-center mb-10">
		<h1 class="text-dark fw-bolder mb-3">Sign In</h1>
		<div class="text-gray-500 fw-semibold fs-6">Please enter your email and password</div>
	</div>

	<div class="fv-row mb-6">

		<input type="text" value="{{ old('email') ?? session('email') }}" placeholder="NIP / Email" name="email" autocomplete="off" class="form-control form-control-solid" />

		@if($errors->has('email'))
		<div class="fv-plugins-message-container invalid-feedback" style="text-align: left;"><div data-field="email" data-validator="notEmpty">{{ $errors->first('email') }}</div></div>
		@endif

		@if(session('status_top'))
        <div class="fv-plugins-message-container text-success" style="text-align: left;">{{ session('status_top') }}</div>
        @endif
	</div>


	<div class="fv-row mb-6">
		{{-- <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control form-control-solid" /> --}}

		<div class="input-group input-group-solid">
		  <input class="form-control form-control-solid" type="password" id="password" name="password" placeholder="Password" autocomplete="off">
		  <span class="input-group-text">
		    <i class="fa fa-eye" id="togglePassword" 
		   style="cursor: pointer"></i>
		   </span>
		</div>

		@if($errors->has('password'))
		<div class="fv-plugins-message-container invalid-feedback" style="text-align: left;"><div data-field="password" data-validator="notEmpty">{{ $errors->first('password') }}</div></div>
		@endif

		@if(session('status'))
        <div class="fv-plugins-message-container text-success" style="text-align: left;">{{ session('status') }}</div>
        @endif

	</div>

	<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-6">
		<div></div>
		<a href="{{ route('password.request') }}" class="link-primary fw-bold">Forgot Password</a>
	</div>

	@if(!@env('RECAPTCHA_DISABLED'))

		{!! NoCaptcha::renderJs() !!}
		<div class="form-group mb-5 ">
			
			<div class="d-flex justify-content-center">
				<div id="g-captcha-container">{!! NoCaptcha::display() !!}</div>
			</div>

			@if ($errors->has('g-recaptcha-response'))
			<span class="fv-plugins-message-container invalid-feedback"><div data-field="password" data-validator="notEmpty">{{ $errors->first('g-recaptcha-response') }}</div></span>
			@endif
		</div>

	@endif

@endsection

@push('additional-css')

<style type="text/css">
	input[type="password"]::-ms-reveal,
	input[type="password"]::-ms-clear {
	  display: none;
	}

	input::-ms-reveal,
	input::-ms-clear {
	  display: none;
	}
</style>

@endpush

@push('additional-js')


<script type="text/javascript">

	const togglePassword = document.querySelector("#togglePassword");
	const password = document.querySelector("#password");

	togglePassword.addEventListener("click", function () {
	   
	  // toggle the type attribute
	  const type = password.getAttribute("type") === "password" ? "text" : "password";
	  password.setAttribute("type", type);
	  // toggle the eye icon
	  this.classList.toggle('fa-eye');
	  this.classList.toggle('fa-eye-slash');
	});

</script>

@endpush