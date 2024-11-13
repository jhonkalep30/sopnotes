<!--begin::Drawers-->
<!--begin::Activities drawer-->
<div id="{{$name}}" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="activities" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'lg': '900px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#{{$name}}_toggle" data-kt-drawer-close="#{{$name}}_close">
	<div class="card shadow-none border-0 rounded-0">
		<!--begin::Header-->
		<div class="card-header" id="{{$name}}_header">
			<h3 class="card-title fw-bold text-dark">{{$title}}</h3>
			<div class="card-toolbar">
				<button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="{{$name}}_close">
					<i class="ki-duotone ki-cross fs-1">
						<span class="path1"></span>
						<span class="path2"></span>
					</i>
				</button>
			</div>
		</div>
		<!--end::Header-->
		<!--begin::Body-->
		<div class="card-body position-relative" id="{{$name}}_body">
			<!--begin::Content-->
			{!! $slot !!}
			<!--end::Content-->
		</div>
		<!--end::Body-->
		<!--begin::Footer-->
		<div class="card-footer py-5 text-center" id="{{$name}}_footer">
			<a href="../../demo8/dist/pages/user-profile/activity.html" class="btn btn-bg-body text-primary">View All Activities
			<i class="ki-duotone ki-arrow-right fs-3 text-primary">
				<span class="path1"></span>
				<span class="path2"></span>
			</i></a>
		</div>
		<!--end::Footer-->
	</div>
</div>
<!--end::Activities drawer-->
<!--end::Drawers-->