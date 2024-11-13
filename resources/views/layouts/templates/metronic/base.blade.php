<!DOCTYPE html>
<html lang="en">
	
	@include('components.metronic.head-meta')
	@include('components.metronic.theme-script')
		
	<!--begin::Main-->
	@yield('main')
	<!--end::Main-->

	@include('components.metronic.scroll-top')
	@include('components.metronic.toastr')
	@include('components.metronic.javascripts')

</html>