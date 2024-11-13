<!--begin::Card-->
<div class="card" id="{{$name}}">
	<!--begin::Card header-->
	@if(@$headers ?? true)
	<div class="card-header border-0 {{ @$headerPadding ?? 'pt-6' }}" style="flex-wrap: {{ @$wrap ? 'wrap' : 'nowrap' }};min-height: {{@$minHeight ?? '70px'}} !important">
		@if(@$headers['title'] ?? true)
			<!--begin::Card title-->
			<div class="card-title"></div>
			<!--begin::Card title-->
		@endif
		@if(@$headers['toolbar'] ?? true)
			<!--begin::Card toolbar-->
			<div class="card-toolbar"></div>
			<!--end::Card toolbar-->
		@endif
	</div>
	@endif
	<!--end::Card header-->
	<!--begin::Card body-->
	<div class="card-body {{ @$bodyPadding ?? 'pt-4 pb-8' }}">
		{!! $slot !!}
	</div>
	<!--end::Card body-->
</div>
<!--end::Card-->