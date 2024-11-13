<!--begin::Javascript-->
<script>var hostUrl = "{{asset(config('theme.assets.back-office'))}}";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset(config('theme.assets.back-office').'plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset(config('theme.assets.back-office').'js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::AmCharts JS-->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<!--end::AmCharts JS-->

<script type="text/javascript">
	$.ajaxSetup({
        headers: {
            'Accept': 'application/json',
            'Authorization': "Bearer {{ session('secret.token') }}",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });
</script>

<script src="{{asset('js/variables.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
<script src="{{asset('js/helper.js')}}"></script>

@yield('select2-js')
@yield('datatable-resource')
<!--begin::Custom Javascript(used for this page only)-->
@yield('additional-js')
@stack('additional-js')
@stack('datatable-resource')
<!--end::Custom Javascript-->
<!--end::Javascript-->