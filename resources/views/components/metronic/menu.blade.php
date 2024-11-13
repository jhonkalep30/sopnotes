<!--begin::Aside menu-->
<div class="aside-menu flex-column-fluid">
	<!--begin::Aside Menu-->
	<div class="hover-scroll-overlay-y px-2 my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="{default: '#kt_aside_toolbar, #kt_aside_footer', lg: '#kt_header, #kt_aside_toolbar, #kt_aside_footer'}" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="5px">
		<!--begin::Menu-->
		<div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">

			@foreach(@\Auth::user()->getMenu() ?? [] as $section)

				<!--begin:Menu item-->
				<div class="menu-item pt-5">
					<!--begin:Menu content-->
					<div class="menu-content">
						<span class="menu-heading fw-bold text-uppercase fs-7">{{ @$section['label'] }}</span>
					</div>
					<!--end:Menu content-->
				</div>
				<!--end:Menu item-->

				@foreach(@$section['groups'] ?? [] as $group)

					@if($group['type'] == 'link')

						<!--begin:Menu item-->
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{ request()->is(@$group['url'].'*') ? 'active' : '' }}" href="{{ (@$group['url'] ? url(@$group['url']) : 'javascript:void(0);') }}">

								@if(@$group['icon'])
									<span class="menu-icon">
										{!! @$group['icon'] !!}
									</span>
								@else
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
								@endif
								
								<span class="menu-title">{{ @$group['label'] }}</span>
							</a>
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->

					@elseif($group['type'] == 'group')

						@php
							$groupShown = collect(@$group['links'])->filter(function ($item){
								return request()->is(@$item['url'].'*');
							})->first() ? true : false;
						@endphp

						<!--begin:Menu item-->
						<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $groupShown ? 'here show' : '' }}">
							<!--begin:Menu link-->
							<span class="menu-link">
								@if(@$group['icon'])
									<span class="menu-icon">
										{!! @$group['icon'] !!}
									</span>
								@else
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
								@endif

								<span class="menu-title">{{ @$group['label'] }}</span>
								<span class="menu-arrow"></span>
							</span>
							<!--end:Menu link-->
							<!--begin:Menu sub-->
							<div class="menu-sub menu-sub-accordion">

								@foreach(@$group['links'] ?? [] as $link)

									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link {{ request()->is(@$link['url'].'*') ? 'active' : '' }}" href="{{ (@$link['url'] ? url(@$link['url']) : 'javascript:void(0);') }}" href="{{ (@$link['url'] ? url(@$link['url']) : 'javascript:void(0);') }}">
											@if(@$link['icon'])
												<span class="menu-icon">
													{!! @$link['icon'] !!}
												</span>
											@else
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
											@endif

											<span class="menu-title">{{ @$link['label'] }}</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->

								@endforeach

								
							</div>
							<!--end:Menu sub-->
						</div>
						<!--end:Menu item-->

					@endif

				@endforeach

			@endforeach
		
		</div>
		<!--end::Menu-->
	</div>
	<!--end::Aside Menu-->
</div>
<!--end::Aside menu-->