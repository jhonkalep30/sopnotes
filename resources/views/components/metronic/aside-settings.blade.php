<!--begin::User-->
<div class="aside-user d-flex align-items-sm-center justify-content-center pt-8 pb-2">
	<!--begin::Symbol-->
	<div class="symbol symbol-50px">
		<img src="{{ @\Auth::user()->photo_url ?? asset(config('theme.assets.back-office').'media/svg/avatars/blank.svg') }}" alt="" />
	</div>
	<!--end::Symbol-->
	<!--begin::Wrapper-->
	<div class="aside-user-info flex-row-fluid flex-wrap ms-5">
		<!--begin::Section-->
		<div class="d-flex">
			<!--begin::Info-->
			<div class="flex-grow-1 me-2">
				<!--begin::Username-->
				<a href="#" class="text-white text-hover-primary fs-6 fw-bold">{{Auth::user()->name}}</a>
				<!--end::Username-->
				<!--begin::Description-->
				<span class="text-gray-600 fw-semibold d-block fs-8 mb-1">{{@Auth::user()->role->name ?? '-'}}</span>
				<!--end::Description-->
				<!--begin::Label-->
				{{-- <div class="d-flex align-items-center text-success fs-9">
				<span class="bullet bullet-dot bg-success me-1"></span>online</div> --}}
				<!--end::Label-->
			</div>
			<!--end::Info-->
			<!--begin::User menu-->
			<div class="me-n2">
				<!--begin::Action-->
				<a href="#" class="btn btn-icon btn-sm btn-active-color-primary mt-n2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-overflow="true">
					<i class="ki-duotone ki-setting-2 text-muted fs-1">
						<span class="path1"></span>
						<span class="path2"></span>
					</i>
				</a>
				<!--begin::User account menu-->
				<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
					<!--begin::Menu item-->
					<div class="menu-item px-3">
						<div class="menu-content d-flex align-items-center px-3">
							<!--begin::Avatar-->
							<div class="symbol symbol-50px me-5">
								<img alt="Logo" src="{{ @\Auth::user()->photo_url ?? asset(config('theme.assets.back-office').'media/svg/avatars/blank.svg') }}" />
							</div>
							<!--end::Avatar-->
							<!--begin::Username-->
							<div class="d-flex flex-column">
								<div class="fw-bold d-flex align-items-center fs-5">{{Auth::user()->name}}
								</div>
								<a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{Auth::user()->email}}</a>
							</div>
							<!--end::Username-->
						</div>
					</div>
					<!--end::Menu item-->
					
					<!--begin::Menu separator-->
					<div class="separator my-2"></div>
					<!--end::Menu separator-->
					<!--begin::Menu item-->
					{{-- <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" data-kt-menu-offset="-15px, 0">
						<a href="#" class="menu-link px-5">
							<span class="menu-title position-relative">Language
							<span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">English
							<img class="w-15px h-15px rounded-1 ms-2" src="{{asset(config('theme.assets.back-office').'/media/flags/united-states.svg')}}" alt="" /></span></span>
						</a>
						<!--begin::Menu sub-->
						<div class="menu-sub menu-sub-dropdown w-175px py-4">
							<!--begin::Menu item-->
							<div class="menu-item px-3">
								<a href="../../demo8/dist/account/settings.html" class="menu-link d-flex px-5 active">
								<span class="symbol symbol-20px me-4">
									<img class="rounded-1" src="{{asset(config('theme.assets.back-office').'/media/flags/united-states.svg')}}" alt="" />
								</span>English</a>
							</div>
							<!--end::Menu item-->
							<!--begin::Menu item-->
							<div class="menu-item px-3">
								<a href="../../demo8/dist/account/settings.html" class="menu-link d-flex px-5">
								<span class="symbol symbol-20px me-4">
									<img class="rounded-1" src="{{asset(config('theme.assets.back-office').'/media/flags/spain.svg')}}" alt="" />
								</span>Spanish</a>
							</div>
							<!--end::Menu item-->
							<!--begin::Menu item-->
							<div class="menu-item px-3">
								<a href="../../demo8/dist/account/settings.html" class="menu-link d-flex px-5">
								<span class="symbol symbol-20px me-4">
									<img class="rounded-1" src="{{asset(config('theme.assets.back-office').'/media/flags/germany.svg')}}" alt="" />
								</span>German</a>
							</div>
							<!--end::Menu item-->
							<!--begin::Menu item-->
							<div class="menu-item px-3">
								<a href="../../demo8/dist/account/settings.html" class="menu-link d-flex px-5">
								<span class="symbol symbol-20px me-4">
									<img class="rounded-1" src="{{asset(config('theme.assets.back-office').'/media/flags/japan.svg')}}" alt="" />
								</span>Japanese</a>
							</div>
							<!--end::Menu item-->
							<!--begin::Menu item-->
							<div class="menu-item px-3">
								<a href="../../demo8/dist/account/settings.html" class="menu-link d-flex px-5">
								<span class="symbol symbol-20px me-4">
									<img class="rounded-1" src="{{asset(config('theme.assets.back-office').'/media/flags/france.svg')}}" alt="" />
								</span>French</a>
							</div>
							<!--end::Menu item-->
						</div>
						<!--end::Menu sub-->
					</div> --}}
					<!--end::Menu item-->
					<!--begin::Menu item-->
					<div class="menu-item px-5 my-1">
						<a href="{{ route('profile.view') }}" class="menu-link px-5">Profile</a>
					</div>
					<!--end::Menu item-->
					<!--begin::Menu item-->
					<div class="menu-item px-5">
						<form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a class="menu-link px-5" href="javascript:void(0);"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Sign Out') }}
                            </a>
                        </form>

						{{-- <a href="../../demo8/dist/authentication/layouts/corporate/sign-in.html" class="menu-link px-5">Sign Out</a> --}}
					</div>
					<!--end::Menu item-->
				</div>
				<!--end::User account menu-->
				<!--end::Action-->
			</div>
			<!--end::User menu-->
		</div>
		<!--end::Section-->
	</div>
	<!--end::Wrapper-->
</div>
<!--end::User-->