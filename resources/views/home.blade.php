<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href=""/>
		<title>{{ env('APP_NAME', 'Lumina') }} - {{ env('APP_DESCRIPTION', 'Laravel Automation Project') }}</title>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		
		{{-- CSRF Token --}}
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="{{ env('APP_NAME', 'Lumina') }} - {{ env('APP_DESCRIPTION', 'Laravel Automation Project') }}" />
		<meta property="og:url" content="" />
		<meta property="og:site_name" content="{{ env('APP_NAME', 'Lumina') }} | {{ env('APP_DESCRIPTION', 'Laravel Automation Project') }}" />
		<link rel="canonical" href="" />
		<link rel="shortcut icon" href="{{asset(config('theme.assets.back-office').'media/logos/favicon.ico')}}" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Vendor Stylesheets(used for this page only)-->
		<link href="{{asset(config('theme.assets.front-page').'plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset(config('theme.assets.front-page').'plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{asset(config('theme.assets.front-page').'plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset(config('theme.assets.front-page').'css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_app_body" data-kt-app-header-fixed-mobile="true" data-kt-app-toolbar-enabled="true" class="app-default">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->

		<!--begin::App-->
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
			
				<!--begin::Wrapper-->
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
					
					<!--begin::Wrapper container-->
					<div class="app-container container-xxl d-flex">

						<!--begin::Main-->
						<div class="app-main flex-column flex-row-fluid" id="kt_app_main">

							

							<div  class="d-flex flex-column flex-md-row flex-center flex-md-stack py-9 px-3" style="justify-content: space-between;">
								<div class="col-4"></div>
								<div class="col-4 text-center">
									<img alt="Logo" src="{{asset(config('theme.assets.front-page').'media/logos/demo43.svg')}}" class="h-30px h-lg-40px theme-light-show" />
									<img alt="Logo" src="{{asset(config('theme.assets.front-page').'media/logos/demo43-dark.svg')}}" class="h-20px h-lg-30px theme-dark-show" />
								</div>
								<div class="col-4" style="text-align: right;">
									<a class="btn btn-primary" href="{{ route('login') }}">Login</a>
								</div>
							</div>

							<!--begin::Content wrapper-->
							<div class="d-flex flex-column flex-column-fluid">
								<!--begin::Content-->
								<div id="kt_app_content" class="app-content" style="padding-top: 0px;">
									<!--begin::Row-->
									<div class="row g-5 g-xxl-10">
										<!--begin::Col-->
										<div class="col-12">
											
											<!--begin::Card Widget 23-->
											<div class="card border-0">
												<!--begin::Body-->
												<div class="card-body py-12" style="min-height: 70vh">
													<!--begin::Action-->
													<!--end::Action-->

													<!--begin::Block-->
													<div class="d-flex border border-primary border-dashed rounded p-5 bg-light-primary mb-6">
														<!--begin::Icon-->
														<span class="me-5">
															<i class="ki-outline ki-information fs-3x text-primary"></i>
														</span>
														<!--end::Icon-->
														<!--begin::Section-->
														<div class="me-2">
															<a href="#" class="text-gray-800 text-hover-primary fs-4 fw-bolder">Important Note!</a>
															<span class="text-gray-700 fw-semibold d-block fs-5">This website is under construction, come again later to see our features</span>
														</div>
														<!--end::Section-->
													</div>
													<!--end::Block-->

													<div class="text-center pb-5 px-5">
														<img src="{{asset(config('theme.assets.front-page').'media/illustrations/sigma-1/2.png')}}" alt="" class="mw-100 h-200px h-sm-325px">
													</div>

													{{-- <div class="d-flex justify-content-center pb-15 fw-bold fs-1">
														We preparing something that exciting
													</div> --}}


													{{-- <div class="card-px text-left pt-15 pb-15">
														<h2 class="fs-2x fw-bold mb-0">Project Title</h2>
														<p class="text-gray-400 fs-4 fw-semibold py-7">
															Lorem ipsum dolor sit amet,
													
															<br>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
														</p>
													</div> --}}
													


													

													<!--begin::Action-->
													<!--end::Action-->
												</div>
												<!--end::Body-->
											</div>
											<!--end::Card Widget 23-->
										</div>
										<!--end::Col-->
										<!--begin::Col-->
										
										<!--end::Col-->
									</div>
									<!--end::Row-->
						
								</div>
								<!--end::Content-->
							</div>
							<!--end::Content wrapper-->
							<!--begin::Footer-->
							<div id="kt_app_footer" class="app-footer d-flex flex-column flex-md-row flex-center flex-md-stack pb-6 justify-content-center">
								<!--begin::Copyright-->
								<div class="text-dark order-2 order-md-1">
									<span class="text-muted fw-semibold me-1">2023&copy;</span>
									<a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Lumina Project. All rights reserved.</a>
								</div>
								<!--end::Copyright-->
								<!--begin::Menu-->
								{{-- <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
									<li class="menu-item">
										<a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
									</li>
									<li class="menu-item">
										<a href="https://devs.keenthemes.com" target="_blank" class="menu-link px-2">Support</a>
									</li>
									<li class="menu-item">
										<a href="https://1.envato.market/EA4JP" target="_blank" class="menu-link px-2">Purchase</a>
									</li>
								</ul> --}}
								<!--end::Menu-->
							</div>
							<!--end::Footer-->
						</div>
						<!--end:::Main-->
					</div>
					<!--end::Wrapper container-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::App-->
		
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{asset(config('theme.assets.front-page').'plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset(config('theme.assets.front-page').'js/scripts.bundle.js')}}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Vendors Javascript(used for this page only)-->
		<script src="{{asset(config('theme.assets.front-page').'plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
		<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
		<script src="{{asset(config('theme.assets.front-page').'plugins/custom/datatables/datatables.bundle.js')}}"></script>
		<!--end::Vendors Javascript-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script src="{{asset(config('theme.assets.front-page').'js/widgets.bundle.js')}}"></script>
		<script src="{{asset(config('theme.assets.front-page').'js/custom/widgets.js')}}"></script>
		<script src="{{asset(config('theme.assets.front-page').'js/custom/apps/chat/chat.js')}}"></script>
		<script src="{{asset(config('theme.assets.front-page').'js/custom/utilities/modals/create-app.js')}}"></script>
		<script src="{{asset(config('theme.assets.front-page').'js/custom/utilities/modals/new-card.js')}}"></script>
		<script src="{{asset(config('theme.assets.front-page').'js/custom/utilities/modals/upgrade-plan.js')}}"></script>
		<script src="{{asset(config('theme.assets.front-page').'js/custom/utilities/modals/users-search.js')}}"></script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>