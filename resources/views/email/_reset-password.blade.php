<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic
Product Version: 8.1.8
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
	<!--begin::Head-->
	<head>
		<title>Metronic - The World's #1 Selling Bootstrap Admin Template by Keenthemes</title>
		<meta charset="utf-8" />
		<meta name="description" content="The most advanced Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free." />
		<meta name="keywords" content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Metronic - Bootstrap Admin Template, HTML, VueJS, React, Angular. Laravel, Asp.Net Core, Ruby on Rails, Spring Boot, Blazor, Django, Express.js, Node.js, Flask Admin Dashboard Theme & Template" />
		<meta property="og:url" content="https://keenthemes.com/metronic" />
		<meta property="og:site_name" content="Keenthemes | Metronic" />
		<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{asset(config('theme.assets.back-office').'plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset(config('theme.assets.back-office').'css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="auth-bg">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Wrapper-->
			<div class="d-flex flex-column flex-column-fluid">
		


				<!--begin::Body-->
				<div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
					<!--begin::Email template-->
					<style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>

					<div class="text-center">
						<a href="https://keenthemes.com" rel="noopener" target="_blank">
							<img alt="Logo" src="{{asset(config('theme.assets.back-office').'media/email/logo-2.svg')}}" style="height: 40px" />
						</a>
					</div>

					<div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">

						<div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:30px auto; max-width: 600px;">

							<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
								<tbody>
									<tr>
										<td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
											<!--begin:Email content-->
											<div style="text-align:center; margin:10px 60px 10px 60px">
												<!--begin:Logo-->
												
												<!--end:Logo-->
												<!--begin:Media-->
												{{-- <div style="margin-bottom: 15px">
													<img class="w-200px" alt="Logo" src="{{asset(config('theme.assets.back-office').'media/illustrations/sigma-1/8.png')}}" />
												</div> --}}
												<!--end:Media-->
												<!--begin:Text-->
												<div class="fs-4 fw-semibold text-gray-600" style="text-align: left;">
													<h2 class="mb-4">Hello!</h2>
													<div>You are receiving this email because we received a password reset request for your account.</div>
												</div>
												<!--end:Text-->
												<!--begin:Action-->
												<a href="{{ @$url }}" target="_blank" class="btn btn-primary my-12 fs-4 fw-semibold">Reset Password</a>
												<!--end:Action-->

												<div class="fs-4 fw-semibold text-gray-600" style="text-align: left;">
													<div class="mb-5">This password reset link will expire in 60 minutes.</div>
													<div class="mb-5">If you did not request a password reset, no further action is required.</div>

													<div>Regards,</div>
													<div class="fw-bold text-dark">{{ @$regards ?? 'Team' }}</div>

												</div>

												<hr class="my-8">

												<div class="fs-6 fw-semibold text-gray-600" style="text-align: left; max-width: 480px !important; overflow-wrap: break-word !important;">If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser: <a class="text-hover-primary" href="{{ @$url }}">{{ @$url }}</a></div>
											</div>
											<!--end:Email content-->
										</td>
									</tr>
									
									
									
								</tbody>
							</table>
							
						</div>

					</div>

					<div class="text-center text-gray-600 fs-5">
						2023 &copy; Lumina Project
					</div>

					<!--end::Email template-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Root-->
		<!--end::Main-->
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{asset(config('theme.assets.back-office').'plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset(config('theme.assets.back-office').'js/scripts.bundle.js')}}"></script>
		<!--end::Global Javascript Bundle-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>