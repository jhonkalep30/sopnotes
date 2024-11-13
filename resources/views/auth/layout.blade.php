<!DOCTYPE html>
<html lang="en">
	
	@include('components.metronic.head-meta')
	@include('components.metronic.theme-script')

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
		
		<!--begin::Main-->
		<div class="row">

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

			<div class="text-center justify-content-center d-flex align-items-center py-10 px-15" style="height: 100vh !important; flex-wrap: wrap;">

				<div class="w-100 text-center align-items-center d-flex justify-content-center">

					<div style="width: 450px;">

						<div class="pt-2 pb-3 mb-6 text-center">
							<img class="w-200px theme-light-show" src="{{ @setting('website_logo') ?? asset(config('theme.assets.back-office').'media/logos/default.svg') }}">
							<img class="w-200px theme-dark-show" src="{{ @setting('website_logo_dark') ?? asset(config('theme.assets.back-office').'media/logos/default-dark.svg') }}">
						</div>

						<div class="bg-body rounded-4 p-lg-13 p-10 shadow-sm">

							<form id="form_submit" method="POST" action="{{ $formUrl }}">
	        					@csrf

								@yield('content')

								<div class="d-grid mb-2">
									<button type="submit" id="btn_submit" class="btn btn-primary">
										<span class="indicator-label">{{@$submitText ?? 'Submit'}}</span>
										<span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									</button>
								</div>
							</form>

						</div>

						<div class="d-flex flex-stack py-6 mb-lg-0 mb-4 justify-content-center">

							@if($footer = setting('website_footer'))
								{!! $footer !!}
							@else
								<div class="d-flex fw-semibold text-gray-600 fs-base gap-5">
									2023 &copy; Lumina Project
								</div>
							@endif
						</div>

					</div>

				</div>

				

			</div>
		</div>

		@include('components.metronic.javascripts')

		<script type="text/javascript">
			$(document).on('click', '#btn_submit', function(){
				$('#btn_submit').attr('disabled', 'disabled').attr('data-kt-indicator', 'on');
				$('#form_submit').submit();
			})

			$(document).on('keypress', 'input', function(){
				$(this).parent().find('.invalid-feedback').hide()
			})
		</script>

	</body>
	<!--end::Body-->
</html>