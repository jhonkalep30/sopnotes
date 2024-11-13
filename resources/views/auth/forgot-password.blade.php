@extends('auth.layout',[
    'formUrl' => route('password.request'),
])

@section('content')

    <div class="text-center mb-12">
        <h1 class="text-dark fw-bolder mb-3">Forgot Password</h1>
        <div class="text-gray-500 fw-semibold fs-6">Enter your email to reset your password</div>
    </div>



    <div class="fv-row mb-6">
        <input type="text" value="{{ old('email') }}" placeholder="Email" name="email" autocomplete="off" class="form-control form-control-solid" />

        @if($errors->has('email'))
        <div class="fv-plugins-message-container invalid-feedback" style="text-align: left;"><div data-field="email" data-validator="notEmpty">{{ $errors->first('email') }}</div></div>
        @endif

        @if(session('status'))
        <div class="fv-plugins-message-container text-success" style="text-align: left;">{{ session('status') }}</div>
        @endif

        {{-- <div class="fv-plugins-message-container text-success" style="text-align: left;">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</div> --}}

    </div>

    {{-- <div class="d-grid mb-4">
        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
            <span class="indicator-label">Submit</span>
        </button>
    </div> --}}

    {{-- <div class="d-flex flex-wrap justify-content-center pb-lg-0">
        <button type="submit"  class="btn btn-primary me-4">Submit</button>
        <a href="{{ route('login') }}" class="btn btn-active-light">Cancel</a>
    </div> --}}

    <div class="d-flex gap-3 fs-base justify-content-center mb-8">
        <div class="text-muted fw-semibold">Remember your password ? <a href="{{ route('login') }}" class="link-primary fw-bold">Sign in</a></div>
    </div>

@endsection