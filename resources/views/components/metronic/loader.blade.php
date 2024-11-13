<!--begin::Loader > Loading-->
<div id="loader-loading_{{ @$id }}" class="{{ @$loading['class'] }}">
	<div class="d-flex flex-column flex-center" style="min-height: {{ @$min_height ?? '225px' }};">
		{{-- <div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div> --}}
    </div>
</div>
<!--end::Loader > Loading-->

<!--begin::Loader > Error-->
<div id="loader-error_{{ @$id }}" class="{{ @$error['class'] }}" style="display: none;">
    <div class="d-flex flex-column flex-center" style="min-height: {{ @$min_height ?? '225px' }};">
        <img src="{{ asset(config('theme.assets.back-office').'media/illustrations/sigma-1/20.png') }}" style="max-width: 175px;">
        @if(@$error['witTitle'] ?? true)
        <div class="fs-1 fw-bolder text-dark mb-4">{{ @$error['title'] ?? 'Error Occured' }}</div>
        @endif
        <div class="fs-6">{!! @$error['text'] ?? 'Oops, something went wrong ...' !!}</div>
    </div>
</div>
<!--end::Loader > Error-->

<!--begin::Loader > Empty-->
<div id="loader-empty_{{ @$id }}" class="{{ @$empty['class'] }}" style="display: none;">
    <div class="d-flex flex-column flex-center" style="min-height: {{ @$min_height ?? '225px' }};">
        <img src="{{ asset(config('theme.assets.back-office').'media/illustrations/sigma-1/21.png') }}" style="max-width: 175px;">
        @if(@$empty['witTitle'] ?? true)
        <div class="fs-1 fw-bolder text-dark mb-4">{{ @$empty['title'] ?? 'No data found' }}</div>
        @endif
        <div class="fs-6">{!! @$empty['text'] ?? 'Sorry we couldn\'t find any data' !!}</div>
    </div>
</div>
<!--end::Loader > Empty-->

<!--begin::Loader > Data-->
<div id="loader-data_{{ @$id }}" class="{{ @$data['class'] }}" style="display: none;">
    <div class="flex-column flex-center px-3" style="min-height: {{ @$min_height ?? '225px' }};">
        {!! @$slot !!}
    </div>
</div>
<!--end::Loader > Data-->

@push('additional-js')

<script type="text/javascript">

    // $(document).ready(function(){
        
        var blockLoading = new KTBlockUI(document.querySelector("#loader-loading_{{ @$id }}"), {
            overlayClass: "bg-white bg-opacity-0",
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
        });

        blockLoading.block();

    // })

    function switch_loader_{{ @$id }}(mode = 'loading') {
        
        $('#loader-empty_{{ @$id }}').hide();
        $('#loader-data_{{ @$id }}').hide();
        $('#loader-loading_{{ @$id }}').hide();
        $('#loader-error_{{ @$id }}').hide();

        if(mode == 'loading') $('#loader-loading_{{ @$id }}').show();
        if(mode == 'data') $('#loader-data_{{ @$id }}').show();
        if(mode == 'empty') $('#loader-empty_{{ @$id }}').show();
        if(mode == 'error') $('#loader-error_{{ @$id }}').show();

    }


</script>

@endpush