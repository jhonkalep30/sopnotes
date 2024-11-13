<!DOCTYPE html>
<html lang="en">
	
	@include('components.metronic.head-meta')
	@include('components.metronic.theme-script')
	
	<!--begin::Body-->
	<body id="kt_body" class="aside-enabled">
		
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Aside-->
				<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
					<!--begin::Aside Toolbarl-->
					<div class="aside-toolbar flex-column-auto" id="kt_aside_toolbar">
						<!--begin::Aside user-->
						@include('components.metronic.aside-settings')
						
						{{-- @include('components.metronic.aside-quick-search') --}}

						<!--end::Aside user-->
					</div>
					<!--end::Aside Toolbarl-->
					
					@include('components.metronic.menu')

				</div>
				<!--end::Aside-->
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" style="" class="header align-items-stretch">
						<!--begin::Brand-->
						<div class="header-brand">
							<!--begin::Logo-->
							<a href="../../demo8/dist/index.html">
								<img alt="Logo" src="{{asset(config('theme.assets.back-office').'media/logos/default-dark.svg')}}" class="h-25px h-lg-25px" />
							</a>
							<!--end::Logo-->
							<!--begin::Aside minimize-->
							<div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-minimize" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
								<i class="ki-duotone ki-entrance-right fs-1 me-n1 minimize-default">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
								<i class="ki-duotone ki-entrance-left fs-1 minimize-active">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</div>
							<!--end::Aside minimize-->
							<!--begin::Aside toggle-->
							<div class="d-flex align-items-center d-lg-none me-n2" title="Show aside menu">
								<div class="btn btn-icon btn-active-color-primary w-30px h-30px" id="kt_aside_mobile_toggle">
									<i class="ki-duotone ki-abstract-14 fs-1">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
								</div>
							</div>
							<!--end::Aside toggle-->
						</div>
						<!--end::Brand-->
						<!--begin::Toolbar-->
						<div class="toolbar d-flex align-items-stretch">
							<!--begin::Toolbar container-->
							<div class="container-xxl py-6 py-lg-0 d-flex flex-column flex-lg-row align-items-lg-stretch justify-content-lg-between">
								<!--begin::Page title-->
								<div class="page-title d-flex justify-content-center flex-column me-5">
									<!--begin::Title-->
									<h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">{{$title}}</h1>
									<!--end::Title-->
									
									@include('components.metronic.breadcrumb',@$breadcrumb ?? [])

								</div>
								<!--end::Page title-->
								
								@include('components.metronic.action-group')

							</div>
							<!--end::Toolbar container-->
						</div>
						<!--end::Toolbar-->
					</div>
					<!--end::Header-->
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Post-->
						<div class="post d-flex flex-column-fluid" id="kt_post">
							<!--begin::Container-->
							<div id="kt_content_container" class="container-xxl">
								@yield('content')
							</div>
							<!--end::Container-->
						</div>
						<!--end::Post-->
					</div>
					<!--end::Content-->
					<!--begin::Footer-->
					<div class="footer py-5 d-flex flex-lg-column" id="kt_footer" style="background: transparent;">
						<!--begin::Container-->
						<div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-end">
							<!--begin::Copyright-->
							<div class="text-dark order-2 order-md-1">
								<span class="text-muted fw-semibold me-1">2023&copy;</span>
								<a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Lumina Project</a>
							</div>
							<!--end::Copyright-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->
		<!--end::Main-->

		@include('components.metronic.scroll-top')
		@include('components.metronic.toastr')
		@include('components.metronic.javascripts')

	</body>
	<!--end::Body-->
</html>