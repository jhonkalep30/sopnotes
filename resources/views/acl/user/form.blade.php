@extends(config('theme.layouts.admin'),[
    'title' => 'User',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        ['label' => 'User Management'],
        [
            'label' => 'User',
            'url' => route('user.view')
        ],
        [
            'label' => 'Detail'
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
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " data-bs-toggle="tab" href="#tabAdditional">Additional</a>
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

    <form id="form-data" enctype="multipart/form-data">

	    <div class="tab-content" id="tabForm">

		    <div class="tab-pane fade show active " id="tabInfo" role="tabpanel">

		    	<div class="card mb-5 mb-xl-10">
					<!--begin::Card header-->
					<div class="card-header border-0">
						<!--begin::Card title-->
						<div class="card-title m-0">
							<h3 class="fw-bold m-0">Personal Information</h3>
						</div>
						<!--end::Card title-->
					</div>
					<!--begin::Card header-->
					<!--begin::Content-->
					<div>
						
						<!--begin::Card body-->
						<div class="card-body border-top p-9" data-select2-id="select2-data-130-146i">
							
							<input type="hidden" id="id" name="id" value="{{ @$data->id }}">

					        {{ Form::textInput('name', @$data->name, ['required' => 'required']) }}
					        {{ Form::textInput('npp', @$data->npp, ['labelText' => 'NPP', 'required' => 'required']) }}

	                        {{ 
	                            Form::select2Input('jenis_kelamin', @$data->jenis_kelamin, [
	                                'LAKI-LAKI' => 'LAKI-LAKI',
	                                'PEREMPUAN' => 'PEREMPUAN',
	                            ], [
	                                'pluginOptions' => ['allowClear' => false],
	                                'required' => 'required'
	                            ]) 
	                        }}

	                        {{ 
					            Form::select2Input('jabatan_id', [@$data->jabatan->id, @$data->jabatan->name],route('jabatan.list'),[
					                'labelText' => 'Jabatan',
					                'required' => 'required'
					            ]) 
					        }}

					        {{ 
					            Form::select2Input('outlet_id', [@$data->outlet->id, @$data->outlet->name],route('outlet.list'),[
					                'labelText' => 'Outlet',
					            ]) 
					        }}

					        {{ 
					            Form::select2Input('unit_bisnis_id', [@$data->unitBisnis->id, @$data->unitBisnis->name],route('unit.bisnis.list'),[
					                'labelText' => 'Unit Bisnis',
					            ]) 
					        }}

					        <!-- AVATAR -->
							<div class="row mb-8 mt-8" >
	                            <!--begin::Label-->
	                            <div class="col-md-3">
	                                <label class="col-form-label">
	                                    <span class="fw-semibold fs-6">Avatar</span>
	                                </label>
	                            </div>
	                            <!--end::Label-->
	                            <!--begin::Col-->
	                            <div class="col-lg-8">
	                                <!--begin::Image input-->
	                                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('{{ asset(config('theme.assets.back-office').'media/svg/avatars/blank.svg') }}')">
	                                    <!--begin::Preview existing avatar-->
	                                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{ @$data->photo_url ?? asset(config('theme.assets.back-office').'media/svg/avatars/blank.svg')  }}')"></div>
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
		                    <!-- AVATAR -->

		                    {{ 
		                        Form::switchInput('active', @$data->active)
		                    }}

						</div>
						<!--end::Card body-->
						<!--begin::Actions-->
						<div class="card-footer d-flex justify-content-end py-6 px-9">
							<button type="button" class="btn btn-primary btn-submit">
			                    <span class="indicator-label">Save Changes</span>
			                    <span class="indicator-progress">Please wait...
			                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
			                </button>
						</div>
						<!--end::Actions-->

					</div>
					<!--end::Content-->
				</div>

	        
		    </div>

		    <div class="tab-pane fade" id="tabAccount" role="tabpanel">

		    	<!--begin::Card-->
	            <div class="card mb-5 mb-xl-10">

	                <div class="card-header border-0">
	                    <!--begin::Card title-->
	                    <div class="card-title m-0">
	                        <h3 class="fw-bold m-0">Account Detail</h3>
	                    </div>
	                    <!--end::Card title-->
	                </div>

	                <!--begin::Card body-->
	                <div class="card-body border-top pt-8 pb-4">

	                    <div class="d-flex flex-wrap align-items-center">
	                        <!--begin::Label-->
	                        <div id="container-email-label">
	                            <div class="fs-6 fw-bold mb-1">Email Address</div>
	                            <div id="textInfoEmail2" class="fw-semibold text-gray-600">{{ @$data->email }}</div>
	                        </div>
	                        <!--end::Label-->

	                        <!--begin::Edit-->
	                        <div id="container-change-email" class="flex-row-fluid" style="display: none;">
	                            <!--begin::Form-->
	                            <form id="form-email" enctype="multipart/form-data">
	                                <div class="row mb-1">
	                                    <div class="col-lg-4">
	                                        {{ 
	                                            Form::emailInput('email', null, [
	                                                'formAlignment' => 'vertical',
	                                                'elOptions' => [
	                                                    'placeholder' => ''
	                                                ]
	                                            ]) 
	                                        }}
	                                    </div>

	                                </div>
	                                <div class="d-flex">
	                                    <button type="button" id="btn-email-submit" class="btn btn-primary">
	                                        <span class="indicator-label">Update Email</span>
	                                        <span class="indicator-progress">Please wait...
	                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
	                                    </button>

	                                    <button id="btn-email-cancel" type="button" class="btn btn-active-light px-6 ms-3">Cancel</button>
	                                </div>
	                            </form>
	                            <!--end::Form-->
	                        </div>
	                        <!--end::Edit-->

	                        <!--begin::Action-->
	                        <div id="container-btn-change-email" class="ms-auto">
	                            <button id="btn-change-email" type="button" class="btn btn-light btn-active-light-primary">Change Email</button>
	                        </div>
	                        <!--end::Action-->
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
	                                <div class="row mb-1">
	                                    <div class="col-lg-4">
	                                        {{ 
	                                            Form::passwordInput('password', null, [
	                                                'labelText' => 'Reset Password',
	                                                'formAlignment' => 'vertical',
	                                                'elOptions' => [
	                                                    'placeholder' => ''
	                                                ]
	                                            ]) 
	                                        }}
	                                    </div>

	                                </div>
	                                {{-- <div class="form-text mb-5">Password must be at least 8 character and contain symbols</div> --}}
	                                <div class="d-flex">
	                                    <button type="button" id="btn-password-submit" class="btn btn-primary">
	                                        <span class="indicator-label">Update Password</span>
	                                        <span class="indicator-progress">Please wait...
	                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
	                                    </button>

	                                    <button id="btn-password-cancel" type="button" class="btn btn-active-light px-6 ms-3">Cancel</button>
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

		    <div class="tab-pane fade " id="tabAdditional" role="tabpanel">

		    	<div class="card mb-5 mb-xl-10">
					<!--begin::Card header-->
					<div class="card-header border-0">
						<!--begin::Card title-->
						<div class="card-title m-0">
							<h3 class="fw-bold m-0">Additional Information</h3>
						</div>
						<!--end::Card title-->
					</div>
					<!--begin::Card header-->
					<!--begin::Content-->
					<div>
						
						<!--begin::Card body-->
						<div class="card-body border-top p-9" data-select2-id="select2-data-130-146i">
							
	                        {{ 
					            Form::select2Input('kota_id', [@$data->kota_link->id, @$data->kota_link->name],route('kota.list'),[
					                'labelText' => 'Kota',
					            ]) 
					        }}

					        {{ 
					            Form::select2Input('direktorat_id', [@$data->direktorat->id, @$data->direktorat->name],route('direktorat.list'),[
					                'labelText' => 'Direktorat',
					            ]) 
					        }}

					        {{ 
	                            Form::select2Input('status', @$data->status, [
	                                'PT' => 'PT',
	                                'PTT' => 'PTT',
	                                'PTT (PRO HIRE)' => 'PTT (PRO HIRE)',
	                                'MAGANG BERSERTIFIKAT' => 'MAGANG BERSERTIFIKAT',
	                            ], [
	                                'pluginOptions' => ['allowClear' => false],
	                            ]) 
	                        }}

	                   		{{ Form::textInput('id_his', @$data->id_his) }}
							{{ Form::textInput('plt_penugasan', @$data->plt_penugasan) }}

							{{ Form::dateInput('tmb_plt', @$data->tmb_plt) }}

							{{ Form::textInput('masa_kerja_plt', @$data->masa_kerja_plt) }}
							{{ Form::textInput('cost_center', @$data->cost_center) }}
							{{ Form::textInput('outlet_inhouse', @$data->outlet_inhouse) }}
							
							{{ 
	                            Form::select2Input('strata_unit_bisnis', @$data->strata_unit_bisnis, [
	                                'A' => 'A',
	                                'B' => 'B',
	                                'C' => 'C',
	                                'TIDAK ADA' => 'TIDAK ADA',
	                            ], [
	                                'pluginOptions' => ['allowClear' => false],
	                            ]) 
	                        }}

							
	                        {{ 
	                            Form::select2Input('kelas_outlet', @$data->kelas_outlet, [
	                                'KELAS 1' => 'KELAS 1',
	                                'KELAS 2' => 'KELAS 2',
	                                'KELAS 3' => 'KELAS 3',
	                                'KELAS 4' => 'KELAS 4',
	                                'TIDAK ADA' => 'TIDAK ADA',
	                            ], [
	                                'pluginOptions' => ['allowClear' => false],
	                            ]) 
	                        }}

							{{ 
	                            Form::select2Input('pendidikan', @$data->pendidikan, [
	                                'SETINGKAT SMP' => 'SETINGKAT SMP',
	                                'SETINGKAT SMA' => 'SETINGKAT SMA',
	                                'DIPLOMA III (D-3)' => 'DIPLOMA III (D-3)',
	                                'DIPLOMA IV (D-4)' => 'DIPLOMA IV (D-4)',
	                                'STRATA I (S-1)' => 'STRATA I (S-1)',
	                                'STRATA II (S-2)' => 'STRATA II (S-2)',
	                                'STRATA III (S-3)' => 'STRATA III (S-3)',
	                                'PROFESI' => 'PROFESI',
	                            ], [
	                                'pluginOptions' => ['allowClear' => false],
	                            ]) 
	                        }}

							{{ Form::textInput('jurusan', @$data->jurusan) }}
							{{ Form::textInput('alumni_pendidikan', @$data->alumni_pendidikan) }}
							{{ Form::textInput('tanggal_lulus', @$data->tanggal_lulus) }}
							
							{{ 
	                            Form::select2Input('gelar_profesi', @$data->gelar_profesi, [
	                                'AKUNTAN' => 'AKUNTAN',
	                                'KEBIDANAN' => 'KEBIDANAN',
	                                'APOTEKER' => 'APOTEKER',
	                                'NERS' => 'NERS',
	                            ], [
	                                'pluginOptions' => ['allowClear' => false],
	                            ]) 
	                        }}

							{{ Form::textInput('alumni_pendidikan_profesi', @$data->alumni_pendidikan_profesi) }}
							{{ Form::textInput('tahun_lulus_profesi', @$data->tahun_lulus_profesi) }}
							{{ Form::textInput('tempat_lahir', @$data->tempat_lahir) }}

							{{ Form::dateInput('tanggal_lahir', @$data->tanggal_lahir) }}

							{{ Form::textInput('tmb', @$data->tmb) }}
							{{ Form::textInput('masa_kerja', @$data->masa_kerja) }}
							{{ Form::textInput('tmb_jabatan_saat_ini', @$data->tmb_jabatan_saat_ini) }}
							{{ Form::textInput('masa_kerja_jabatan_saat_ini', @$data->masa_kerja_jabatan_saat_ini) }}
							{{ Form::textInput('tmb_kenaikan_level', @$data->tmb_kenaikan_level) }}
							{{ Form::textInput('tanggal_pj_penuh', @$data->tanggal_pj_penuh) }}
							{{ Form::textInput('tmb_pt', @$data->tmb_pt) }}
							{{ Form::textInput('masa_kerja_pt', @$data->masa_kerja_pt) }}
							{{ Form::textInput('grading', @$data->grading) }}
							{{ Form::textInput('eselon', @$data->eselon) }}
							{{ Form::textInput('spk_i', @$data->spk_i) }}
							{{ Form::textInput('spk_ii', @$data->spk_ii) }}
							{{ Form::textInput('spk_iii', @$data->spk_iii) }}
							{{ Form::textInput('spk_iv', @$data->spk_iv) }}
							{{ Form::textInput('spk_v', @$data->spk_v) }}
							{{ Form::textInput('habis_kontrak', @$data->habis_kontrak) }}
							{{ Form::textInput('domisili_asal', @$data->domisili_asal) }}
							{{ Form::textInput('alamat_ktp', @$data->alamat_ktp) }}
							{{ Form::textInput('kelurahan', @$data->kelurahan) }}
							{{ Form::textInput('kecamatan', @$data->kecamatan) }}
							{{ Form::textInput('kota', @$data->kota) }}
							{{ Form::textInput('provinsi', @$data->provinsi) }}
							{{ Form::textInput('kode_pos', @$data->kode_pos) }}
							{{ Form::textInput('agama', @$data->agama) }}
							{{ Form::textInput('ktp', @$data->ktp) }}
							{{ Form::textInput('no_tlp', @$data->no_tlp) }}
							{{ Form::textInput('alamat_email', @$data->alamat_email) }}
							{{ Form::textInput('no_tlp_keluarga', @$data->no_tlp_keluarga) }}
							{{ Form::textInput('alamat_sesuai_npwp', @$data->alamat_sesuai_npwp) }}
							{{ Form::textInput('npwp', @$data->npwp) }}
							{{ Form::textInput('nama_ibu', @$data->nama_ibu) }}
							{{ Form::textInput('nama_ayah', @$data->nama_ayah) }}
							{{ Form::textInput('bpjs_kes', @$data->bpjs_kes) }}
							{{ Form::textInput('no_rek', @$data->no_rek) }}
							{{ Form::textInput('status_kawin_npwp', @$data->status_kawin_npwp) }}
							{{ Form::textInput('golongan_darah', @$data->golongan_darah) }}
							{{ Form::textInput('status_kawin', @$data->status_kawin) }}
							{{ Form::textInput('jml_anak', @$data->jml_anak) }}
							{{ Form::textInput('jml_anggota_keluarga', @$data->jml_anggota_keluarga) }}
							{{ Form::textInput('nama_pasangan', @$data->nama_pasangan) }}
							{{ Form::textInput('anak_1', @$data->anak_1) }}
							{{ Form::textInput('anak_2', @$data->anak_2) }}
							{{ Form::textInput('anak_3', @$data->anak_3) }}
							{{ Form::textInput('anak_4', @$data->anak_4) }}
							{{ Form::textInput('anak_5', @$data->anak_5) }}



						</div>
						<!--end::Card body-->
						<!--begin::Actions-->
						<div class="card-footer d-flex justify-content-end py-6 px-9">
							<button type="button" class="btn btn-primary btn-submit">
			                    <span class="indicator-label">Save Changes</span>
			                    <span class="indicator-progress">Please wait...
			                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
			                </button>
						</div>
						<!--end::Actions-->

					</div>
					<!--end::Content-->
				</div>

		    </div>
		    
		</div>

	</form>

@endsection

@push('additional-js')

<script type="text/javascript">
	
	$('.btn-submit').click(function(){

		var form = $('#form-data')[0];
        var formData = new FormData(form);

		$.ajax({
	        type: "POST",
	        url:  '{{ route('user.save') }}',
	        data: formData,
	        cache: false,
            contentType: false,
            processData: false,
	        beforeSend: function(){   
	            submitProcess('form-submit');
	        },
	        success: function (result) {

	            if(result.success == true){
	                swaling({'text': result.message, 'icon': 'success'})
	            }else{
	                // Swal.fire("Error!", result.msg, "error");

	                // $('.error-container').html('');
	                // displayErrorInput(result.errors);

	                swaling({'text': result.message, 'icon': 'error'})
	                displayErrorInput($('#form-data'), result.errors);
	            }
	        },
	        error: function(xhr, textStatus, errorThrown){
	            console.log(errorThrown);
	            toasting()
	        }
	    }).always(function(){
	        submitProcess('form-submit', 1);
	    });

	})

	$('#btn-password-submit').click(function(){

		var data = {};
		data.id = '{{ @$data->id }}';
		data.password = $('#password').val();

		$.ajax({
	        type: "POST",
	        url:  '{{ route('user.save') }}',
	        data: data,
	        beforeSend: function(){   
	            submitProcess('btn-password-submit');
	        },
	        success: function (result) {

	            if(result.success == true){
	                swaling({'text': result.message, 'icon': 'success'})
	                $('#btn-password-cancel').click()
	            }else{
	                swaling({'text': result.message, 'icon': 'error'})
	                displayErrorInput($('#form-password'), result.errors);
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

	$('#btn-email-submit').click(function(){

		var data = {};
		data.id = '{{ @$data->id }}';
		data.email = $('#email').val();

		$.ajax({
	        type: "POST",
	        url:  '{{ route('user.save') }}',
	        data: data,
	        beforeSend: function(){   
	            submitProcess('btn-email-submit');
	        },
	        success: function (result) {

	            if(result.success == true){
	                swaling({'text': result.message, 'icon': 'success'})
	                $('#btn-email-cancel').click()
	            }else{
	                swaling({'text': result.message, 'icon': 'error'})
	                displayErrorInput($('#form-email'), result.errors);
	            }
	        },
	        error: function(xhr, textStatus, errorThrown){
	            console.log(errorThrown);
	            toasting()
	        }
	    }).always(function(){
	        submitProcess('btn-email-submit', 1);
	    });

	})


	$('#btn-change-password').click(function(){
        $('#container-btn-change-password').hide();
        $('#container-password-label').hide();
        $('#container-change-password').show();

        $('#password').val('')
    })

    $('#btn-password-cancel').click(function(){
        $('#container-password-label').show();
        $('#container-btn-change-password').show();
        $('#container-change-password').hide();
    })

    $('#btn-change-email').click(function(){
        $('#container-btn-change-email').hide();
        $('#container-email-label').hide();
        $('#container-change-email').show();
    })

    $('#btn-email-cancel').click(function(){
        $('#container-email-label').show();
        $('#container-btn-change-email').show();
        $('#container-change-email').hide();
    })

</script>

@endpush