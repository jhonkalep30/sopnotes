@extends(config('theme.layouts.admin'),[
    'title' => 'Profile',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        [
            'label' => 'Setting',
        ],
        [
            'label' => 'Profile'
        ],
    ]

])

@section('content')
    
    <div class="card mb-5 mb-xl-10">

        <div class="card-body pt-0 pb-0">
            
            <!--begin::Navs-->
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                <!--begin::Nav item-->
                <li class="nav-item mt-2"> 
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 active" data-bs-toggle="tab" href="#tabInfo">Information</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " data-bs-toggle="tab" href="#tabAccount">Account</a>
                </li>
                <!--end::Nav item-->
                
            </ul>
            <!--begin::Navs-->
        </div>
        

    </div>

    <div class="tab-content" id="tabForm">
        <div class="tab-pane fade show active" id="tabInfo" role="tabpanel">

            <!--begin::Card-->
            <div class="card mb-5 mb-xl-10">

                <div class="card-header border-0">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Personal Information</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!--begin::Card body-->
                <div class="card-body border-top pt-8 pb-4">

                    <form id="form-personal" enctype="multipart/form-data">

                        <div class="row mb-8" >
                            <!--begin::Label-->
                            <div class="col-md-3">
                                <label class="col-form-label">
                                    <span class="fw-bold fs-6">Avatar</span>
                                </label>
                            </div>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Image input-->
                                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('{{ asset(config('theme.assets.back-office').'media/svg/avatars/blank.svg') }}')">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{ @\Auth::user()->photo_url ?? asset(config('theme.assets.back-office').'media/svg/avatars/blank.svg')  }}')"></div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                        <i class="ki-duotone ki-pencil fs-7">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="photo_url" accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="photo_url_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span style="display: none;" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->
                                <!--begin::Hint-->
                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                <!--end::Hint-->
                            </div>
                            <!--end::Col-->
                        </div>

                        {{-- {{ Form::textInput('name', @\Auth::user()->name, ['elOptions' => ['disabled' => 'disabled']]) }} --}}
                        {{ Form::textInput('name', @\Auth::user()->name) }}

                        {{ Form::textInput('npp', @\Auth::user()->npp, ['labelText' => 'NPP', 'elOptions' => ['disabled' => 'disabled']]) }}

                        {{ 
                            Form::select2Input('jabatan_id', [@\Auth::user()->jabatan->id, @\Auth::user()->jabatan->name],route('jabatan.list'),[
                                'labelText' => 'Jabatan',
                                'required' => 'required',
                                'elOptions' => ['disabled' => 'disabled'],
                                'pluginOptions' => ['allowClear' => false]
                            ]) 
                        }}
                        

                    </form>

                </div>
                <!--end::Card body-->

                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="button" id="form-personal-submit" class="btn btn-primary">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>

            </div>
            <!--end::Card-->

        </div>

        <div class="tab-pane fade" id="tabAccount" role="tabpanel">

            <!--begin::Card-->
            <div class="card mb-5 mb-xl-10">

                <div class="card-header border-0">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Your Account</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!--begin::Card body-->
                <div class="card-body border-top pt-8 pb-4">

                    <div class="d-flex flex-wrap align-items-center">
                        <!--begin::Label-->
                        <div id="kt_signin_email">
                            <div class="fs-6 fw-bold mb-1">Email Address</div>
                            <div class="fw-semibold text-gray-600">{{ @\Auth::user()->email }}</div>
                        </div>
                        <!--end::Label-->
                        
                    </div>

                    <div class="separator separator-dashed my-6"></div>

                    <div class="d-flex flex-wrap align-items-center mt-8 mb-6">
                        <!--begin::Label-->
                        <div id="container-password-label" class="">
                            <div class="fs-6 fw-bold mb-1">Password</div>
                            <div class="fw-semibold text-gray-600">************</div>
                        </div>
                        <!--end::Label-->
                        <!--begin::Edit-->
                        <div id="container-change-password" class="flex-row-fluid" style="display: none;">
                            <!--begin::Form-->
                            <form id="form-password" enctype="multipart/form-data">
                                <div class="row mb-6">
                                    <div class="col-lg-4">
                                        {{ 
                                            Form::passwordInput('old_password', null, [
                                                'labelText' => 'Current Password',
                                                'formAlignment' => 'vertical',
                                                'divContainerClass' => 'form-group mb-2',
                                                'elOptions' => [
                                                    'placeholder' => ''
                                                ]
                                            ]) 
                                        }}
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="fv-row" data-kt-password-meter="true">
                                            {{ 
                                                Form::passwordInput('new_password', null, [
                                                    'formAlignment' => 'vertical',
                                                    'divContainerClass' => 'form-group mb-2',
                                                    'elOptions' => [
                                                        'placeholder' => ''
                                                    ]
                                                ]) 
                                            }}
                                            <!--begin::Highlight meter-->
                                            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                            </div>
                                            <!--end::Highlight meter-->

                                            <!--begin::Hint-->
                                            <div class="text-muted">
                                                Use 8 or more characters with a mix of letters, numbers & symbols.
                                            </div>
                                            <!--end::Hint-->
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        {{ 
                                            Form::passwordInput('confirm_password', null, [
                                                'formAlignment' => 'vertical',
                                                'divContainerClass' => 'form-group mb-2',
                                                'elOptions' => [
                                                    'placeholder' => ''
                                                ]
                                            ]) 
                                        }}

                                        <span class="text-success fw-bold password-match" style="display: none;">
                                            <i class="fas fa-check-circle text-success fw-bold"></i> Password match
                                        </span>

                                        <span class="text-danger fw-bold password-not-match" style="display: none;">
                                            <i class="fas fa-times-circle text-danger fw-bold"></i> Password doesn't match
                                        </span>
                                    </div>
                                </div>
                                {{-- <div class="form-text mb-5">Password must be at least 8 character and contain symbols</div> --}}
                                <div class="d-flex">
                                    <button type="button" id="btn-password-submit" class="btn btn-primary">
                                        <span class="indicator-label">Update Password</span>
                                        <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>

                                    <button id="btn-password-cancel" type="button" class="btn btn btn-active-light ms-3 px-6">Cancel</button>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Edit-->
                        <!--begin::Action-->
                        <div id="container-btn-change-password" class="ms-auto">
                            <button id="btn-change-password" type="button" class="btn btn-light btn-active-light-primary">Change Password</button>
                        </div>
                        <!--end::Action-->
                    </div>

                </div>
                <!--end::Card body-->


            </div>
            <!--end::Card-->

        </div>

    </div>

@endsection

@push('additional-js')

<script type="text/javascript">
    var options = {
        minLength: 8,
        checkUppercase: true,
        checkLowercase: true,
        checkDigit: true,
        checkChar: true,
        scoreHighlightClass: "active"
    };
    var passwordMeterElement = document.querySelector("#kt_password_meter_control");
    var passwordMeter = new KTPasswordMeter(passwordMeterElement, options);

    $('#confirm_password').on('keyup',function(){
        if($(this).val() !== ''){
            if($(this).val() === $('#new_password').val()){
                $('.password-match').show();
                $('.password-not-match').hide();
            }else{
                $('.password-not-match').show();
                $('.password-match').hide();
            }
        }else{
            $('.password-not-match').hide();
            $('.password-match').hide();
        }
    });

    $('#btn-change-password').click(function(){
        $('#container-btn-change-password').hide();
        $('#container-password-label').hide();
        $('#container-change-password').show();

        $('#old_password').val('')
        $('#new_password').val('')
        $('#confirm_password').val('')
    })

    $('#btn-password-cancel').click(function(){
        $('#container-password-label').show();
        $('#container-btn-change-password').show();
        $('#container-change-password').hide();
    })

    $('#form-personal-submit').click(function(){

        var form = $('#form-personal')[0];
        var formData = new FormData(form);

        $.ajax({
            type: "POST",
            url:  '{{ route('profile.update') }}',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){   
                submitProcess('form-personal-submit');
            },
            success: function (result) {
                if(result.success == true){
                    swaling({'text': 'Success to save setting', 'icon': 'success'})
                }else{
                    swaling({'text': result.message, 'icon': 'error'})
                    displayErrorInput($('#form-personal'), result.errors);
                }
            },
            error: function(xhr, textStatus, errorThrown){
                console.log(errorThrown);
                toasting()
            }
        }).always(function(){
            submitProcess('form-personal-submit', 1);
        });

    })

    $('#btn-password-submit').click(function(){

        var form = $('#form-password')[0];
        var formData = new FormData(form);

        $.ajax({
            type: "POST",
            url:  '{{ route('profile.change-password') }}',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){   
                submitProcess('btn-password-submit');
            },
            success: function (result) {
                if(result.success == true){
                    swaling({'text': 'Success to change password', 'icon': 'success'})
                    $('#btn-password-cancel').click();

                }else{
                    swaling({'text': result.message, 'icon': 'error'})
                    // displayErrorInput($('#form-password'), result.errors);
                }
            },
            error: function(xhr, textStatus, errorThrown){
                console.log(errorThrown);
                toasting()
            }
        }).always(function(){
            submitProcess('btn-password-submit', 1);
        });

    })

</script>

@endpush