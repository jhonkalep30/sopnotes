@extends(config('theme.layouts.admin'),[
    'title' => 'Setting',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        [
            'label' => 'Setting',
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
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 active" data-bs-toggle="tab" href="#tabWebsite">Website</a>
                </li>
                <!--end::Nav item-->

                <!--begin::Nav item-->
                <li class="nav-item mt-2"> 
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " data-bs-toggle="tab" href="#tabSurvey">Survey</a>
                </li>
                <!--end::Nav item-->
                
            </ul>
            <!--begin::Navs-->
        </div>
        

    </div>

    <div class="tab-content">

        
        <div class="tab-pane fade show active" id="tabWebsite" role="tabpanel">
            
            <!--begin::Card-->
            <div class="card mb-5 mb-xl-10">

                <div class="card-header border-0">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Website Configuration</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!--begin::Card body-->
                <div class="card-body border-top pt-8 pb-4">

                    <form id="form-website" enctype="multipart/form-data">

                        {{ Form::textInput('website_name',  @$website_config['website_name'] ?? env('APP_NAME'), ['formAlignment' => 'vertical']) }}

                        {{ Form::textareaInput('website_description',  @$website_config['website_description'] ?? env('APP_DESCRIPTION'), ['formAlignment' => 'vertical', 'elOptions' => ['rows' => 3]]) }}

                        {{ 
                            Form::fileInput('website_logo', @$website_config['website_logo'] ?? asset(config('theme.assets.back-office').'media/logos/default.svg'),[
                                'pluginOptions' => [
                                    'showUpload' => false,
                                    'showPreview' => true,
                                    'dropZoneEnabled' => false,
                                    'allowedFileExtensions' => ['png','jpg', 'jpeg'],
                                ],
                                'formAlignment' => 'vertical',
                                'labelText' => 'Logo'
                            ])
                        }}

                        {{ 
                            Form::fileInput('website_logo_dark', @$website_config['website_logo_dark'] ?? asset(config('theme.assets.back-office').'media/logos/default-dark.svg'),[
                                'pluginOptions' => [
                                    'showUpload' => false,
                                    'showPreview' => true,
                                    'dropZoneEnabled' => false,
                                    'allowedFileExtensions' => ['png','jpg', 'jpeg'],
                                ],
                                'formAlignment' => 'vertical',
                                'labelText' => 'Logo (Dark Theme Mode)',
                                'inputContainerClass' => 'dark-theme',
                                'divContainerClass' => 'dark-theme',
                            ])
                        }}

                        {{ 
                            Form::fileInput('website_favicon', @$website_config['website_favicon'] ?? asset(config('theme.assets.back-office').'media/logos/favicon.ico'), [
                                'pluginOptions' => [
                                    'showUpload' => false,
                                    'showPreview' => true,
                                    'dropZoneEnabled' => false,
                                    'allowedFileExtensions' => ['ico'],
                                ],
                                'formAlignment' => 'vertical',
                                'labelText' => 'Favicon'
                            ])
                        }}

                        <div class="form-group mb-5 1">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class=" col-form-label">
                                        <span class="fw-bold fs-6">Footer</span>
                                    </label>
                                </div>
                                <div class="col-md-12">
                                        
                                    <div id="website_footer" name="website_footer">
                                        {!! @$website_config['website_footer'] ?? '2023 © Lumina Project' !!}
                                    </div>
                              
                                </div>
                            </div>
                        </div>

                    </form>

                </div>

                <div class="card-footer d-flex justify-content-end mt-15 py-6 px-9">
                    <button type="button" id="form-website-submit" class="btn btn-primary">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>

            </div>

        </div>

        <div class="tab-pane fade " id="tabSurvey" role="tabpanel">
            
            <!--begin::Card-->
            <div class="card mb-5 mb-xl-10">

                <div class="card-header border-0">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Survey Configuration</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!--begin::Card body-->
                <div class="card-body border-top pt-8 pb-4">

                    <form id="form-survey" enctype="multipart/form-data">

                        {{ 
                            Form::fileInput('nps_logo', @$website_config['nps_logo'] ?? asset('assets/images/logo.png'),[
                                'pluginOptions' => [
                                    'showUpload' => false,
                                    'showPreview' => true,
                                    'dropZoneEnabled' => false,
                                    'allowedFileExtensions' => ['png','jpg', 'jpeg'],
                                ],
                                'formAlignment' => 'vertical',
                                'labelText' => 'Survey Logo'
                            ])
                        }}

                        {{ 
                            Form::textInput('nps_nomor_bantuan',  @$website_config['nps_nomor_bantuan'] ?? '1500 255', ['formAlignment' => 'vertical', 'labelText' => 'Nomor Bantuan']) 
                        }}
                        
                        {{ 
                            Form::textInput('nps_hadiah_link',  @$website_config['nps_hadiah_link'], ['formAlignment' => 'vertical', 'labelText' => 'Hadiah Link URL']) 
                        }}

                        {{ 
                            Form::switchInput('nps_blast_whatsapp', @$website_config['nps_blast_whatsapp'] ?? 1, ['formAlignment' => 'vertical', 'labelText' => 'Blast Whatsapp'])
                        }}
                        
                        <div class="mb-8"></div>

                    </form>

                </div>
                <!--end::Card body-->

                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="button" id="form-survey-submit" class="btn btn-primary">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>

            </div>
            <!--end::Card-->

        </div>

    </div>


@endsection

@push('additional-js')

<script type="text/javascript">
	var param = null;

    var quill = new Quill('#website_footer', {
        modules: {
            toolbar: [
                [{ 'font': [] }],
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                //[{ 'align': [false, 'center', 'right'] }],
                [{ 'color': [] }, { 'background': [] }],
                ['link', 'image'],
                ['clean']
            ]
        },
        placeholder: 'Type your text here...',
        theme: 'snow' // or 'bubble'
    });

	$('#select2-tipe_pemilihan_id').on('change', function(){
         $.ajax({
            type: "GET",
            url:  '{{ url('data/pemilu/tipe_pemilihan/detail') }}' + '/' + $(this).val(),

            success: function (result) {
                if(result.data){
                	showDaerahPemilihan(result.data.wilayah);
                }else{
                	showDaerahPemilihan();
                }
            },
            error: function(xhr, textStatus, errorThrown){
                log(errorThrown);
                toasting()
                showDaerahPemilihan();
            }
        });
    })

    function showDaerahPemilihan(id = '') {
    	$('.dapil-container').hide();

    	$('#select2-provinsi_id').val('').trigger('change')
    	$('#select2-kota_id').val('').trigger('change')
    	$('#select2-kecamatan_id').val('').trigger('change')
    	$('#select2-keluarahan_id').val('').trigger('change')
    	
    	if(id == ''){
    		$('#Default').show(); 
    		return;
    	}

    	$('#'+id).show();
    }

    $('#form-survey-submit').click(function(){

        var form = $('#form-survey')[0];
        var formData = new FormData(form);

        $.ajax({
            type: "POST",
            url:  '{{ route('setting.website-config') }}',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){   
                submitProcess('form-survey-submit');
            },
            success: function (result) {
                if(result.success == true){
                    swaling({'text': 'Success to save setting', 'icon': 'success'})
                }else{
                    swaling({'text': result.message, 'icon': 'error'})
                    displayErrorInput($('#form-survey'), result.errors);
                }
            },
            error: function(xhr, textStatus, errorThrown){
                console.log(errorThrown);
                toasting()
            }
        }).always(function(){
            submitProcess('form-survey-submit', 1);
        });

    })

    $('#form-website-submit').click(function(){

        var form = $('#form-website')[0];
        var formData = new FormData(form);

        formData.append('website_footer', quill.root.innerHTML);

        $.ajax({
            type: "POST",
            url:  '{{ route('setting.website-config') }}',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){   
                submitProcess('form-website-submit');
            },
            success: function (result) {
                if(result.success == true){
                    swaling({'text': 'Success to save setting', 'icon': 'success'})
                }else{
                    swaling({'text': result.message, 'icon': 'error'})
                    displayErrorInput($('#form-website'), result.errors);
                }
            },
            error: function(xhr, textStatus, errorThrown){
                console.log(errorThrown);
                toasting()
            }
        }).always(function(){
            submitProcess('form-website-submit', 1);
        });

    })


</script>

@endpush

@push('additional-css')

<style type="text/css">
    
</style>

@endpush