@php
	$slug = @$slug ?? str_replace('_table', '', $elOptions['id']);

	if(!access($slug.'.save') && !access($slug.'.delete') && !@$customActions)
		$pluginOptions['columnDefs'][] = ['targets' => 0, 'visible' => false];
@endphp

@component(config('theme.components').'.loader', [
	'id' => $elOptions['id'], 
	'error' => [
		'class' => 'mb-6',
		'witTitle' => false,
		'text' => 'Oops, something went wrong ... <div class="mt-4 text-center align-item-center"><a class="btn btn-sm btn-primary" href="javascript:void(0);" onclick="dataTableFullReload_'.$elOptions['id'].'()">Reload</a></div>'
	]
])

	<table {!! $htmlOptions !!}>
		<thead>
			<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
				@foreach ($headerColumns as $column)
					@if($column == 'action')
						<th></th>
					@else
						<th>{{ ucwords(str_replace('_', ' ', $column)) }}</th>
					@endif
				@endforeach
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>

	@if(@$export)
		@include(config('theme.components').'.modal-export',['table' => $elOptions['id'],'url' => $export['url'],'title' => $export['title'], 'filter' => @$filter_form])
	@endif

	@if(@$import)
		@include(config('theme.components').'.modal-import',['table' => $elOptions['id'],'url' => $import['url'],'template' => $import['template'],'title' => $import['title']])
	@endif

	@if(@$job_trace)
		@include(config('theme.components').'.modal-job-trace',['table' => $elOptions['id'],'model' => $job_trace['filters'],'title' => $job_trace['title']])
	@endif

	<div id="dt_toolbar_{{$elOptions['id']}}" >
		<!--begin::Toolbar-->
		<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">

			<!--begin::Mobile-->
			<div class="d-lg-none d-flex">
				
				@if(@$create || @$import || @$export)
					<a href="javascript:void(0);" class="btn btn-sm btn-icon btn-primary btn-utils" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
		            	<i class="ki-duotone ki-setting-4 fs-4">
							{{-- <span class="path1"></span>
							<span class="path2"></span>
							<span class="path3"></span>
							<span class="path4"></span> --}}
						</i>
		           	</a>

		           	<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold fs-6 w-200px py-4" data-kt-menu="true" style="">

		           		@if(@$create && access($slug.'.save'))
		           			@if(!@$create['updateOnly'])
							    <div class="menu-item px-3">
							        <a href="{{ @$create['modal'] ? 'javascript:void(0);' : $create['url']}}" class="menu-link px-3 create_btn_{{@$create['modal']}}" @if(@$create['modal']) data-bs-toggle="modal" data-bs-target="#{{$create['modal']}}" onclick="clearError('{{ @$create['modal'] }}')" @endif>
							            Create
							        </a>
							    </div>
						    @endif
					    @endif

					    @if(@$import || @$export)
						    <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
						        <a href="javascript:void(0);" class="menu-link px-3">
						            <span class="menu-title">Bulk Options</span>
						            <span class="menu-arrow-custom">
						            	<i class="ki-duotone ki-burger-menu fs-2 text-primary">
										 <i class="path1"></i>
										 <i class="path2"></i>
										 <i class="path3"></i>
										 <i class="path4"></i>
										</i>
						            </span>
						        </a>

						        <div class="menu-sub menu-sub-dropdown w-175px py-4">
						    	
						    		@if(@$import && access($slug.'.import'))
						                <div class="menu-item px-3">
						                    <a href="javascript:void(0);" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#{{$elOptions['id']}}_modal_export">
						                        Import
						                    </a>
						                </div>
					                @endif

					                @if(@$export && access($slug.'.export'))
						                <div class="menu-item px-3">
						                    <a href="javascript:void(0);" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#{{$elOptions['id']}}_modal_import">
						                        Export
						                    </a>
						                </div>
					                @endif

					                @if(@$export || @$import || access($slug.'.import') || access($slug.'.export'))
						                <div class="menu-item px-3">
						                    <a href="javascript:void(0);" class="menu-link px-3" onclick="showQueueStatus_{{$elOptions['id']}}()">
						                        Queue
						                    </a>
						                </div>
					                @endif

					            </div>
						    </div>
					    @endif


					</div>
				@endif

			</div>
			<!--end::Mobile-->

			<!--begin::Desktop-->
			<div class="d-none d-lg-flex">

				@if(@$import || @$export)

					<a href="javascript:void(0);" class="btn btn-md btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
		            	<i class="ki-duotone ki-abstract-26 fs-4">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>Bulk
		           	</a>

		           	<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold fs-6 w-150px py-4" data-kt-menu="true" style="">

					    <div class="menu-item px-3">
							<div class="menu-content fw-bold text-muted pb-2 px-3 fs-7 text-uppercase">Options</div>
						</div>
					    
					    @if(@$import && access($slug.'.import'))
						    <div class="menu-item px-3">
						        <a href="javascript:void(0)" class="menu-link px-3" class="btn btn-light-primary btn-utils-text me-3" data-bs-toggle="modal" data-bs-target="#{{$elOptions['id']}}_modal_import">
						            Import
						        </a>
						    </div>
						@endif

					    @if(@$export && access($slug.'.export'))
						    <div class="menu-item px-3">
						        <a href="javascript:void(0)" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#{{$elOptions['id']}}_modal_export">
						            Export
						        </a>
						    </div>
						@endif

					    @if(@$export || @$import || access($slug.'.import') || access($slug.'.export'))
						    <div class="menu-item px-3">
						        <a href="javascript:void(0)" class="menu-link px-3" onclick="showQueueStatus_{{$elOptions['id']}}()">
						            Queue
						        </a>
						    </div>
						@endif

					</div>

				@endif

				@if(@$create && access($slug.'.save'))
					@if(@$create['modal'])
		           		@if(!@$create['updateOnly'])
							<button type="button" class="btn btn-primary btn-utils-text me-3" id="create_btn_{{$create['modal']}}" data-bs-toggle="modal" onclick="clearError('{{ @$create['modal'] }}')" data-bs-target="#{{$create['modal']}}">
							<i class="ki-duotone ki-abstract-10 fs-2">
				                <span class="path1"></span>
				                <span class="path2"></span>
				            </i>{!! @$create['text'] ?? 'Create' !!}</button>
				        @endif
					@else
		           		@if(!@$create['updateOnly'])
							<a href="{{$create['url']}}" class="btn btn-primary me-3"><i class="ki-duotone ki-plus fs-2"></i>Create</a>
						@endif
					@endif
				@endif

			</div>
			<!--begin::Desktop-->

		</div>
		<!--end::Toolbar-->
	</div>

	<div id="dt_title_{{$elOptions['id']}}">
		
		@if(@$pluginOptions['searching'] || !isset($pluginOptions['searching']))

			<!--begin::Desktop-->
			<div class="d-none d-md-flex">
				<div class="d-flex align-items-center position-relative my-1">
					<i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
						<span class="path1"></span>
						<span class="path2"></span>
					</i>
					<input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid ps-12 search-dt dt_search_{{$elOptions['id']}}" placeholder="Search" >
				</div>
			</div>
			<!--end::Desktop-->

			<!--begin::Mobile-->
			<div class="d-md-none d-flex">
				<div class="d-flex align-items-center position-relative my-1">
					<i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
						<span class="path1"></span>
						<span class="path2"></span>
					</i>
					<input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid ps-12 search-dt dt_search_{{$elOptions['id']}}" style="width: 170px !important;" placeholder="Search" >
				</div>
			</div>
			<!--end::Mobile-->

		@endif

	</div>

@endcomponent

{{-- <link href="{{ asset('assets/theme/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
{{-- <script src="{{ asset('assets/theme/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script> --}}

@section('datatable-resource')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatable-builder/plugins/datatable/dataTables.bootstrap4.min.css') }}"> --}}
{{-- <script type="text/javascript" src="{{ asset('vendor/datatable-builder/plugins/datatable/jquery.dataTables.min.js') }}"></script> --}}
{{-- <script type="text/javascript" src="{{ asset('vendor/datatable-builder/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script> --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

{{-- <link href="{{ asset(config('theme.assets.back-office').'/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset(config('theme.assets.back-office').'/plugins/custom/datatables/datatables.bundle.js') }}"></script> --}}

@endsection

@push('datatable-resource')
<script type="text/javascript">
	function deleteData(url,id) {
		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
		  	showCancelButton: true,
		  	buttonsStyling: false,
            confirmButtonText: "Delete",
            cancelButtonText: "Cancel",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-active-light"
            }
		}).then((result) => {
		  	if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url:  url + '/' + id,
                    success: function (res) {
                    	if(res.success){
					    	// Swal.fire('Success!', res.message, 'success')
					    	dataTableReload_{{ $elOptions['id'] }}()
                    	}else{
						    Swal.fire('Error!', res.message, 'error')
                    	}
                    },
                    error: function(xhr, textStatus, errorThrown){
                        console.log(errorThrown);
					    Swal.fire('Error!', 'System Error', 'error')
                    }
                });
		  	}
		})
	}

	@if(@$create['modal'])
		function viewData(url) {
			clearForm_{{$create['modal']}}()
			$.ajax({
	            type: "GET",
	            url:  url,
	            success: function (res) {

	            	// log('Res', res)

	            	$('#{{$create['modal']}}_modal_title').html($('#{{$create['modal']}}_modal_title').html().replaceAll('Create', 'Update'))

	            	// PURGE ID HIDDEN
	            	$('#{{$create['modal']}}_form input[type="hidden"][name="id"]').remove()
	            	$('#{{$create['modal']}}_form').prepend('<input type="hidden" name="id" value="'+res.data.id+'">');

	            	$.each($('#{{$create['modal']}}_form :input'), function(){

	            		let value = res.data[$(this).attr('name')];

	            		if($(this).attr('name') != null){
	            			if($(this)[0]._flatpickr){
	            				$(this)[0]._flatpickr.setDate(value)
	            			}

	            			// FILE
	            			else if($(this).attr('type') == 'file'){
	            				var name = $(this).attr('name').replace('[]','');
	            				window['previewFile_'+name](true,{injectFile:value})
	            			}

	            			else{
			            		$(this).val(value).trigger('change');
	            			}
	            		}

	            		// SWITCH
	            		else if($(this).attr('type') == 'checkbox' && $(this).parent().hasClass('form-switch')){
            				value = res.data[$(this).parent().find(':input[type="hidden"]').first().attr('name')];

            				$(this).prop('checked', value).trigger('change')
            			}


	            	});

	            	$.each($('#{{$create['modal']}}_form select'),function(){
	            		var relation = $(this).attr('name').replace('_id','').replace('[]','');

	            		// log('WO', res.data[relation])

	            		if(res.data[relation]){
	            			if($(this).attr('ajax') == "1" || $(this).attr('ajax') == 1){
	            				if($(this).attr('multiple') == 'multiple'){
	            					var select2 = $(this);
						            select2.html(''); // Clear option first

	            					$.each(res.data[relation],function(key,item){
	            						var newOption = new Option(item['name'], item['id'], true, true);
	            						// console.log($(this))
				            			select2.append(newOption);
	            					});

				            		select2.trigger('change');
	            				}else{
			            			var newOption = new Option(res.data[relation]['name'], res.data[relation]['id'], true, true);

			            			$(this).append(newOption);
				            		$(this).trigger('change');
	            				}
		            		}else{
		            			$(this).val(res.data[relation]).trigger('change');
		            		}

	            		}
	            	});

	            	if(typeof customViewData_{{ $elOptions['id'] }} === "function"){
		            	customViewData_{{ $elOptions['id'] }}(res.data)
			    	}

        			$('.error-container').html('');

	            	$('#{{$create['modal']}}').modal('show');

	            	dataTableReload_{{ $elOptions['id'] }}();
	            }
	        });
		}
	@endif
</script>
@endpush

@push('additional-css')
<style type="text/css">
	.dataTables_scroll
	{
	    overflow:auto;
	}

	.dataTables_scrollX
	{
	    overflow-x:scroll !important;
	}

	.dataTable > tbody {
		font-weight: 500;
		color: #7E8299;
	}

	.dataTable > tbody > tr > td {
		padding-right: 25px;
	}

	.dataTables_length > label > select {
		background-color: var(--bs-gray-100);
	    border-color: var(--bs-gray-100);
	    color: var(--bs-gray-700);
	    transition: color 0.2s ease;
	    cursor: pointer;
	}

	.dataTables_length > label > select:focus, .dataTables_length > label > select:focus-within {
		border: none !important;
	}

	.dataTables_wrapper > .bottom {
		display: flex;
		justify-content: space-between;
	}

	@if(@$noWrap)

		.dataTable > tbody, .dataTable > thead {
			white-space: nowrap;
		}

	@endif

	.dataTable tr td:first-child, .dataTable tr td.text-center {
		padding-right: 25px !important;
	}

	.dataTable tr td:not(first-child) {
		padding-right: 3rem !important;
	}

	.dataTable thead th:last-child {
		padding-right: 26px !important;
	}

</style>
@endpush

@push('additional-js')
<script type="text/javascript">

	$.fn.dataTable.ext.errMode = 'none';

	// if($.fn.dataTable !== undefined){
	// 	$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
	// 	    console.log(message);

	// 	};
	// }

	var dtColumns_{{ $elOptions['id'] }} = [], dtOptions_{{ $elOptions['id'] }} = {!! json_encode($pluginOptions) !!}, dt_{{ $elOptions['id'] }};


	@foreach ($attributeColumns as $c)
		@if (is_array($c))
			dtColumns_{{ $elOptions['id'] }}.push({!! json_encode($c) !!})
		@else
			var row = {
				data: "{{ $c }}"
			}

			@if ($c == 'action')
			row.searchable = false
			row.sortable = false
			@endif

			dtColumns_{{ $elOptions['id'] }}.push(row)
		@endif

	@endforeach
	dtOptions_{{ $elOptions['id'] }}.columns = dtColumns_{{ $elOptions['id'] }};



	@if ($sourceByAjax)

		dtOptions_{{ $elOptions['id'] }}.processing = true;
		dtOptions_{{ $elOptions['id'] }}.serverSide = true;
		dtOptions_{{ $elOptions['id'] }}.ajax.url =  "{{ $source }}";


		// FILTERS PARAMETER
		dtOptions_{{ $elOptions['id'] }}.ajax.data = {}
		dtOptions_{{ $elOptions['id'] }}.ajax.data.filters = {}
		@foreach ($filters ?? [] as $field => $val)
			@if(is_array($val))
				dtOptions_{{ $elOptions['id'] }}.ajax.data.filters.{{$field}} = {!! json_encode($val) !!}
				dtOptions_{{ $elOptions['id'] }}.ajax.data.{{$field}} = {!! json_encode($val) !!}
			@else
				dtOptions_{{ $elOptions['id'] }}.ajax.data.filters.{{$field}} = {!! $val !!}
				dtOptions_{{ $elOptions['id'] }}.ajax.data.{{$field}} = {!! $val !!}
				@if (Str::endsWith($val, '.val()' ))
					<?php $el = str_replace('.val()', '', $val) ?>
					{!! $el !!}.on('change', function(event) {
						dtOptions_{{ $elOptions['id'] }}.ajax.data.filters.{{$field}} = $(this).val()
						dtOptions_{{ $elOptions['id'] }}.ajax.data.{{$field}} = $(this).val()
					});
				@endif
			@endif

		@endforeach

		@foreach (@$ajaxParams ?? [] as $field => $val)
			dtOptions_{{ $elOptions['id'] }}.ajax.data.filters.{{$field}} = {!! json_encode($val) !!}
			dtOptions_{{ $elOptions['id'] }}.ajax.data.{{$field}} = {!! json_encode($val) !!}
		@endforeach

		function reInitFilters_{{ $elOptions['id'] }}() {
			// FILTERS PARAMETER
			dtOptions_{{ $elOptions['id'] }}.ajax.data = {}
			dtOptions_{{ $elOptions['id'] }}.ajax.data.filters = {}
			@foreach ($filters ?? [] as $field => $val)
				@if(is_array($val))
					dtOptions_{{ $elOptions['id'] }}.ajax.data.filters.{{$field}} = {!! json_encode($val) !!}
					dtOptions_{{ $elOptions['id'] }}.ajax.data.{{$field}} = {!! json_encode($val) !!}
				@else
					dtOptions_{{ $elOptions['id'] }}.ajax.data.filters.{{$field}} = {!! $val !!}
					dtOptions_{{ $elOptions['id'] }}.ajax.data.{{$field}} = {!! $val !!}
					@if (Str::endsWith($val, '.val()' ))
						<?php $el = str_replace('.val()', '', $val) ?>
						{!! $el !!}.on('change', function(event) {
							dtOptions_{{ $elOptions['id'] }}.ajax.data.filters.{{$field}} = $(this).val()
							dtOptions_{{ $elOptions['id'] }}.ajax.data.{{$field}} = $(this).val()
						});
					@endif
				@endif

			@endforeach
		}


	@else

		delete dtOptions_{{ $elOptions['id'] }}.ajax;

	@endif

	dtOptions_{{ $elOptions['id'] }}.initComplete = function(settings, json) {
		$('.btn_edit_{{ $elOptions['id'] }}').on('click',function(){
			viewData_{{ $elOptions['id'] }}($(this).data('url'))
		});

		@if(@$create['modal'])

			
			$('#create_btn_{{$create['modal']}}').on('click',function(){
				if($('#{{$create['modal']}}_form input[name="id"]').val()){
					$('#{{$create['modal']}}_form input[name="id"]').remove();
					clearForm_{{$create['modal']}}()
				}
			});

			$('.create_btn_{{$create['modal']}}').on('click',function(){
				if($('#{{$create['modal']}}_form input[name="id"]').val()){
					$('#{{$create['modal']}}_form input[name="id"]').remove();
					clearForm_{{$create['modal']}}()
				}
			});
			
		@endif

		$('[data-bs-toggle="tooltip"]').tooltip()

		$('.dataTable').wrap('<div class="{{ @$noWrap ? 'dataTables_scrollX' : 'dataTables_scroll' }}" />');

	   	switch_loader_{{ $elOptions['id'] }}('data')

		$('#{{ $elOptions['id'] }}').DataTable().columns.adjust();
	}

	// console.log(dtOptions_{{ $elOptions['id'] }})

	var dataTableInit_{{ $elOptions['id'] }} = function() {
		dataTable_{{ $elOptions['id'] }} = $('#{{ $elOptions['id'] }}').DataTable(dtOptions_{{ $elOptions['id'] }});
	}

	var dataTableFilter_{{ $elOptions['id'] }} = function(fullReload = false){

		if(fullReload) switch_loader_{{ $elOptions['id'] }}('loading')

		reInitFilters_{{ $elOptions['id'] }}()

		@if(@$filter_form)
			var filterForm = serializeFilterForm_{{$filter_form}}()

			$.each(filterForm,function(key,value){
				dtOptions_{{ $elOptions['id'] }}.ajax.data.filters[key] = value;
				dtOptions_{{ $elOptions['id'] }}.ajax.data[key] = value;
			})
		@endif

		$('#{{ $elOptions['id'] }}').DataTable().clear();
        $('#{{ $elOptions['id'] }}').DataTable().destroy();
        
		dataTableInit_{{ $elOptions['id'] }}()
	}

	var dataTableReload_{{ $elOptions['id'] }} = function(fullReload = false){
		if(fullReload) switch_loader_{{ $elOptions['id'] }}('loading')

		var scrollingContainer = $("#{{ $elOptions['id'] }}").parent('div.dataTables_scrollBody');
		var scrollTop = scrollingContainer.scrollTop();

		dataTable_{{ $elOptions['id'] }}.ajax.reload(function() {
			scrollingContainer.scrollTop(scrollTop);
		}, false);
	}

	var dataTableFullReload_{{ $elOptions['id'] }} = function(){
		switch_loader_{{ $elOptions['id'] }}('loading')

		$('#{{ $elOptions['id'] }}').DataTable().clear();
        $('#{{ $elOptions['id'] }}').DataTable().destroy();
        
		dataTableInit_{{ $elOptions['id'] }}()
	}

	function showQueueStatus_{{$elOptions['id']}}() {
		dataTableReload_{{ $elOptions['id'] }}_job_trace()
		$('#{{$elOptions['id']}}_modal_job_trace').modal('show');
	}

    // DRAW CALL BACK
    dtOptions_{{ $elOptions['id'] }}.drawCallback = function(settings) {
		KTMenu.createInstances();
	}

	// ON ERROR
	$('#{{ $elOptions['id'] }}').on('error.dt', function(e, settings, techNote, message) {
	   	// console.log( 'An error has been reported by DataTables: ', message);
	   	if(message.includes('Ajax error')){
			switch_loader_{{ $elOptions['id'] }}('error')
	   	}
	})

	@if(@$filter_form)
		$('#{{$filter_form}}_filter_submit').on('click',function(){
			dataTableFilter_{{ $elOptions['id'] }}()
			$('#{{$filter_form}}_dismiss_close').click();
		})
	@endif

	$(document).ready(function() {

		dataTableInit_{{ $elOptions['id'] }}()

		// $('#dt_toolbar_{{$elOptions['id']}}').remove();
		// $('#dt_title_{{$elOptions['id']}}').remove();

		$('.dt_search_{{$elOptions['id']}}').keyup(function(){
	    	$('#{{$elOptions['id']}}').DataTable().search($(this).val()).draw();
	    })
	});

	function detachDatatableMenu_{{$elOptions['id']}}() {
		@if(@$toolbarLocation)
			var dt_toolbar = $('#dt_toolbar_{{$elOptions['id']}}').detach();
			$('{{$toolbarLocation}}').append(dt_toolbar);
		@endif
		
		@if(@$titleLocation)
			var dt_title = $('#dt_title_{{$elOptions['id']}}').detach();
			$('{{$titleLocation}}').append(dt_title);
		@endif
	}

	detachDatatableMenu_{{$elOptions['id']}}()

	function clearError(modal) {
		$('#'+modal+'_form .error-container').html('')
	}

</script>
@endpush