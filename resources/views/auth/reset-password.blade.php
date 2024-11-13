@extends('auth.layout',[
    'formUrl' => route('password.store'),
])

@section('content')

    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <input type="hidden" name="email" value="{{ @$request->email }}">

    <div class="text-center mb-12">
        <h1 class="text-dark fw-bolder mb-3">Setup New Password</h1>
        <div class="text-gray-500 fw-semibold fs-6">Have you already reset the password ? <a class="link-primary fw-bold" href="{{ route('login') }}">Sign in</a></div>
    </div>

    {{-- <div class="fv-row mb-10">
        <input type="text" value="{{ old('email', $request->email) }}" placeholder="Email" name="email" autocomplete="off" class="form-control form-control-solid" />

        @if($errors->has('email'))
        <div class="fv-plugins-message-container invalid-feedback" style="text-align: left;"><div data-field="email" data-validator="notEmpty">{{ $errors->first('email') }}</div></div>
        @endif

    </div> --}}

    <!--begin::Input group-->
    <div class="fv-row mb-6" data-kt-password-meter="true">
        <!--begin::Wrapper-->
        <div class="mb-1">
            <!--begin::Input wrapper-->
            <div class="position-relative mb-3">
                <input class="form-control form-control-solid" type="password" placeholder="Password" name="password" autocomplete="off" />
                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                    <i class="ki-duotone ki-eye-slash fs-2"></i>
                    <i class="ki-duotone ki-eye fs-2 d-none"></i>
                </span>
            </div>
            <!--end::Input wrapper-->
            <!--begin::Meter-->
            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
            </div>
            <!--end::Meter-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Hint-->
        <div class="text-muted" style="text-align:left">Use 8 or more characters with a mix of letters, numbers & symbols.</div>
        <!--end::Hint-->

        @if($errors->has('password'))
        <div class="fv-plugins-message-container invalid-feedback" style="text-align: left;"><div data-field="password" data-validator="notEmpty">{{ $errors->first('password') }}</div></div>
        @endif
    </div>
    <!--end::Input group=-->
    <!--end::Input group=-->
    <div class="fv-row mb-8">
        <!--begin::Confirm Password-->
        <input type="password" placeholder="Confirm Password" name="password_confirmation" autocomplete="off" class="form-control form-control-solid" />
        <!--end::Confirm Password-->

        {{-- @if($errors->has('password_confirmation')) --}}
        <div class="fv-plugins-message-container invalid-feedback" style="text-align: left;"><div data-field="password_confirmation" data-validator="notEmpty">{{ $errors->first('password_confirmation') }}</div></div>
        {{-- @endif --}}

        @if($errors->has('email'))
        <div class="fv-plugins-message-container invalid-feedback" style="text-align: left;"><div data-field="email" data-validator="notEmpty">{{ $errors->first('email') }}</div></div>
        @endif

    </div>
    <!--end::Input group=-->

@endsection