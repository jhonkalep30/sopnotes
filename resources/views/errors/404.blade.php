@extends('layouts.templates.metronic.base')

@section('main')

	<!--begin::Body-->
	<body id="kt_body" class="auth-bg bgi-size-cover bgi-position-center bgi-no-repeat">

		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page bg image-->
			<style>body { background-image: url('{{ asset(config('theme.assets.back-office').'/media/auth/bg9.jpg') }}'); background-repeat: repeat-y !important; } [data-bs-theme="dark"] body { background-image: url('{{ asset(config('theme.assets.back-office').'/media/auth/bg9-dark.jpg')  }}'); }</style>
			<!--end::Page bg image-->
			<!--begin::Authentication - Signup Welcome Message -->
			<div class="d-flex flex-column flex-center flex-column-fluid">
				<!--begin::Content-->
				<div class="d-flex flex-column flex-center text-center p-10">
					<!--begin::Wrapper-->
					<div class="card card-flush w-lg-600px py-5">
						<div class="card-body py-15 py-lg-20">
							<!--begin::Title-->
							<h1 class="fw-bolder fs-2qx text-gray-900 mb-4">Page Not Found</h1>
							<!--end::Title-->
							<!--begin::Text-->
							<div class="fw-semibold fs-6 text-gray-500 mb-7">We couldn't find the page you are looking for ...</div>
							<!--end::Text-->
							<!--begin::Illustration-->
							<div class="my-20">
								<img src="{{ asset(config('theme.assets.back-office').'/media/illustrations/sigma-1/18-dark.png') }}" class="mw-120 mh-100px theme-light-show" alt="" />
								<img src="{{ asset(config('theme.assets.back-office').'/media/illustrations/sigma-1/18.png') }}" class="mw-120 mh-100px theme-dark-show" alt="" />
							</div>
							<!--end::Illustration-->
							<!--begin::Link-->
							<div class="mb-0">
								<a href="{{ url(homeRedirect()) }}" class="btn btn-md btn-light-dark px-10 py-4 fs-5 fw-bold">Return</a>
							</div>
							<!--end::Link-->
						</div>
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Content-->
			</div>
			<!--end::Authentication - Signup Welcome Message-->
		</div>
		<!--end::Root-->

	</body>
	<!--end::Body-->

@endsection