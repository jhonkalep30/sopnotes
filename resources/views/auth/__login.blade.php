<!DOCTYPE html>

<html lang="en">
	<!--begin::Head-->
	<head>
		<title>Lumina - Laravel Automation Project</title>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		{{-- CSRF Token --}}
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Lumina - Bootstrap Admin Template, HTML, JQuery, Laravel, Node.js, Flask Admin Dashboard Theme & Template" />
		<meta property="og:url" content="" />
		<meta property="og:site_name" content="Lumina | Laravel Automation Project" />
		<link rel="canonical" href="" />
		<link rel="shortcut icon" href="{{asset(config('theme.assets.back-office').'media/logos/favicon.ico')}}" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{asset(config('theme.assets.back-office').'plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset(config('theme.assets.back-office').'css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->

	<style>
		body { 
			background-image: url('{{asset(config('theme.assets.back-office').'media/auth/bg10.jpeg')}}'); 
			overflow-x: hidden !important;
		} 

		[data-bs-theme="dark"] body { 
			background-image: url('{{asset(config('theme.assets.back-office').'media/auth/bg10-dark.jpeg')}}'); 
		}

		.invalid-feedback {
		 	color: var(--bs-text-danger) !important;
		}
	</style>

	<!--begin::Body-->
	<body id="kt_body" class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Main-->

		<div class="pt-4 me-3" style="position: absolute; top: 0; right: 0; width: 50px; text-align: center; align-items: center;">
			<!--begin::Menu toggle-->
			<a href="#" class="btn btn-sm btn-icon btn-icon-muted btn-active-icon-primary" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
				<i class="ki-duotone ki-night-day theme-light-show fs-1">
					<span class="path1"></span>
					<span class="path2"></span>
					<span class="path3"></span>
					<span class="path4"></span>
					<span class="path5"></span>
					<span class="path6"></span>
					<span class="path7"></span>
					<span class="path8"></span>
					<span class="path9"></span>
					<span class="path10"></span>
				</i>
				<i class="ki-duotone ki-moon theme-dark-show fs-1">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</a>
			<!--begin::Menu toggle-->
			<!--begin::Menu-->
			<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
				<!--begin::Menu item-->
				<div class="menu-item px-3 my-0">
					<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
						<span class="menu-icon" data-kt-element="icon">
							<i class="ki-duotone ki-night-day fs-2">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
								<span class="path4"></span>
								<span class="path5"></span>
								<span class="path6"></span>
								<span class="path7"></span>
								<span class="path8"></span>
								<span class="path9"></span>
								<span class="path10"></span>
							</i>
						</span>
						<span class="menu-title">Light</span>
					</a>
				</div>
				<!--end::Menu item-->
				<!--begin::Menu item-->
				<div class="menu-item px-3 my-0">
					<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
						<span class="menu-icon" data-kt-element="icon">
							<i class="ki-duotone ki-moon fs-2">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
						</span>
						<span class="menu-title">Dark</span>
					</a>
				</div>
				<!--end::Menu item-->
				<!--begin::Menu item-->
				<div class="menu-item px-3 my-0">
					<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
						<span class="menu-icon" data-kt-element="icon">
							<i class="ki-duotone ki-screen fs-2">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
								<span class="path4"></span>
							</i>
						</span>
						<span class="menu-title">System</span>
					</a>
				</div>
				<!--end::Menu item-->
			</div>
			<!--end::Menu-->
		</div>

		<div class="pt-10 pb-1">
			<div class="text-center">
				<img class="w-200px theme-light-show" src="{{asset(config('theme.assets.back-office').'media/logos/default.svg')}}">
				<img class="w-200px theme-dark-show" src="{{asset(config('theme.assets.back-office').'media/logos/default-dark.svg')}}">
			</div>
		</div>
		
		<div class="row">


			<div class="col-2 col-md-3 col-lg-4">

			</div>

			<div class="col-8 col-md-6 col-lg-4 text-center justify-content-center d-flex align-items-center py-10" style="height: auto; flex-wrap: wrap;">

				<div class="w-100">

					

					<div class="bg-body rounded-4 p-lg-10 p-10 shadow-sm">

						<form method="POST" action="{{ route('login') }}">
        					@csrf

							<div class="text-center mb-10">
								<h1 class="text-dark fw-bolder mb-3">Sign In</h1>
								<div class="text-gray-500 fw-semibold fs-6">Please enter your email and password</div>
							</div>

							<div class="fv-row mb-6">
								<input type="text" value="{{ old('email') }}" placeholder="Email" name="email" autocomplete="off" class="form-control " />

								@if($errors->has('email'))
								<div class="fv-plugins-message-container invalid-feedback" style="text-align: left;"><div data-field="email" data-validator="notEmpty">{{ $errors->first('email') }}</div></div>
								@endif
							</div>

							<div class="fv-row mb-6">
								<input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control " />

								@if($errors->has('password'))
								<div class="fv-plugins-message-container invalid-feedback" style="text-align: left;"><div data-field="password" data-validator="notEmpty">{{ $errors->first('password') }}</div></div>
								@endif
							</div>

							<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
								<div></div>
								<a href="{{ route('password.request') }}" class="link-primary">Forgot Password</a>
							</div>

							<div class="d-grid mb-2">
								<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
									<span class="indicator-label">Sign In</span>
									<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
							</div>
						</form>

					</div>

					<div class="d-flex flex-stack py-6 mb-lg-0 mb-4 justify-content-center">

						<div class="d-flex fw-semibold text-gray-600 fs-base gap-5">
							2023 &copy; Lumina Project
						</div>
					</div>

				</div>

				

			</div>
			<div class="col-2 col-md-3 col-lg-4"></div>
		</div>

		<!--end::Main-->
		<!--begin::Javascript-->
		<script>var hostUrl = "{{asset(config('theme.assets.back-office'))}}";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{asset(config('theme.assets.back-office').'plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset(config('theme.assets.back-office').'js/scripts.bundle.js')}}"></script>
		<!--end::Global Javascript Bundle-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>