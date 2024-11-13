<div id="{{$name}}_toggle_button_container" style="display: none;">

    <!--begin::Mobile-->
    <button type="button" class="btn btn-icon btn-light-primary me-3 btn-utils d-lg-none d-flex" id="{{$name}}_toggle_button">
    <i class="ki-duotone ki-filter fs-2">
        <span class="path1"></span>
        <span class="path2"></span>
    </i></button>
    <!--end::Mobile-->

    <!--begin::Desktop-->
    <button type="button" class="btn btn-light-primary me-3 d-none d-lg-flex" id="{{$name}}_toggle_button">
    <i class="ki-duotone ki-filter fs-2">
        <span class="path1"></span>
        <span class="path2"></span>
    </i>Filter</button>
    <!--end::Desktop-->

</div>

@php
    $title = $title ?? ucwords(str_replace('_', ' ', $name));
@endphp

<!--begin::View component-->
<div id="{{$name}}_dismiss" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#{{$name}}_toggle_button" data-kt-drawer-close="#{{$name}}_dismiss_close" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'md': '500px'}">
    <div class="card rounded-0 w-100">
        <!--begin::Card header-->
        <div class="card-header pe-5" style="background-color: #1E1E2D; border-radius: 0px !important;">
            <!--begin::Title-->
            <div class="card-title">
                <!--begin::User-->
                <div class="d-flex justify-content-center flex-column me-3">
                    <span class="fs-4 fw-bold text-white me-1 lh-1">{{$title}}</span>
                </div>
                <!--end::User-->
            </div>
            <!--end::Title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-light-primary" id="{{$name}}_dismiss_close">
                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body hover-scroll-overlay-y">
            <form id="{{$name}}_filter_form">
                {!! $slot !!}
            </form>
        </div>
        <!--end::Card body-->

        <!--begin::Card footer-->
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                <button type="button" onclick="resetFilterForm_{{$name}}()" class="btn btn-active-light">Reset</button>
                <button type="button" id="{{$name}}_filter_submit" onclick="setFilter_{{$name}}()" class="btn btn-primary ms-3">Filter</button>
            </div>
        </div>
        <!--end::Card footer-->
    </div>

</div>
<!--end::View component-->

@push('additional-js')
<script type="text/javascript">
    // $(document).ready(function(){
        // setTimeout(function(){
            $('{{$buttonLocation}}').prepend($('#{{$name}}_toggle_button_container').html());
        // },50)
    // })

    var filter_{{$name}} = {}

    function setFilter_{{$name}}() {
        filter_{{$name}} = {}

        var filterData = new FormData($('#{{$name}}_filter_form')[0]);

        for (var filterPair of filterData.entries()) {
            filter_{{$name}}[filterPair[0]] = filterPair[1]
        }

    }

    function serializeFilterForm_{{$name}}() {
        var form = $('#{{$name}}_filter_form');
        var filterForm = form.serializeArray();
        var filters = {};

        $.each(filterForm, function(key, val){
            var name = val.name;
            if (name != "_token" && val.value != "") {
                // if(!(name in filters['filter'])){
                //  filters['filter'][name] = val.value
                // }

                if(filters.hasOwnProperty(name)){
                    if(Array.isArray(filters[name])){
                        filters[name].push(val.value);
                    }else{
                        filters[name] = [filters[name],val.value];
                    }
                }else{
                    filters[name] = val.value;
                }
            }
        });

        return filters;
    }

    function resetFilterForm_{{$name}}() {
        $.each($('#{{$name}}_filter_form input'),function(){
            if($(this).attr('type') != null){
                $(this).val('');
            }
        });

        $.each($('#{{$name}}_filter_form select'),function(){
            $(this).val(null).trigger('change');
        });

        $('#{{$name}}_filter_submit').click();
    }
</script>
@endpush