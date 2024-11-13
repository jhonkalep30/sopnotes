<!--begin::Breadcrumb-->
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
	@foreach($breadcrumb as $key => $item)
		@if($key+1 < count($breadcrumb))
			@if(@$item['url'])
				<!--begin::Item-->
				<li class="breadcrumb-item text-muted">
					<a href="{{$item['url']}}" class="text-muted text-hover-primary">{{$item['label']}}</a>
				</li>
				<!--end::Item-->
			@else
				<!--begin::Item-->
				<li class="breadcrumb-item text-muted">{{$item['label']}}</li>
				<!--end::Item-->
			@endif
			<!--begin::Item-->
			<li class="breadcrumb-item">
				<span class="bullet bg-gray-300 w-5px h-2px"></span>
			</li>
			<!--end::Item-->
		@else
			<!--begin::Item-->
			<li class="breadcrumb-item text-dark">{{$item['label']}}</li>
			<!--end::Item-->
		@endif
	@endforeach
</ul>
<!--end::Breadcrumb-->