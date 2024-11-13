@php
if (!is_array($attributes)) $attributes = [];

$useDatatable = $attributes['useDatatable'] ?? false;

// SET DEFAULT CLASS
$attributes['elOptions']['class'] = 'select2 form-control';

// SET DEFAULT ID
$attributes['elOptions']['id'] = $attributes['elOptions']['id'] ?? 'select2-' . $name;

// SET DEFAULT FOR FORMATTED SELECT2 DATA FORMAT
$attributes['text'] = $attributes['text'] ?? 'obj.name';
$attributes['key'] = isset($attributes['key']) ? $attributes['key'] : 'id';

// CALLING SETUP DEFAULT CONFIG
$config = FormBuilderHelper::setupDefaultConfig($name, $attributes, true);
$config['additionalFields'] = $attributes['additionalFields'] ?? [];
$config['pluginOptions'] = $attributes['pluginOptions'] ?? [];
@endphp

<div class="form-group {{ !$errors->has($name) ?: 'has-error' }}">
	@if ($config['useLabel'])
	<div class="row">
		<div class="{{ $config['labelContainerClass'] }}">
			<label class="col-form-label">
				{!! $config['labelText'] !!}
			</label>
		</div>
		<div class="{{ $config['inputContainerClass'] }}">
	@endif

			<div class="row">
				<div class="col-md-12">
					<div class="input-group" style="margin-bottom: 10px">
						<div style="width:90%;">
							{{ Form::select2Input($name, null, $options, array_merge($config, ['useLabel' => false])) }}
						</div>
						<div style="width:10%">
							<span class="input-group-append">
								<button class="btn btn-primary btn-block" type="button" onclick="addSelectedVal_{{$name}}()" style="border-radius: 0 4px 4px 0 !important;">
									Add
								</button>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<table class="table {{'table-select2-' . $name}}">
						<thead>
							<tr>
								<th>#</th>
								<th>{{ $config['customLabel'] }}</th>
								@foreach ($config['additionalFields'] as $id => $label)
									<th>{{ ucwords(str_replace('_', ' ', $label['attribute'] ?? $label)) }}</th>
								@endforeach
								<th>Action</th>
								<th style="display: none"></th>
							</tr>
						</thead>
						<tbody>
							@if ($useDatatable)
								@foreach ($value as $i => $v)
									<tr>
										<td>{{ $i+1 }}</td>
										<td>{{ $v['name'] }}</td>
										<td> 
					            		 	<button class="btn btn-danger btn-sm removeSelectedDataBtn_{{$name}}" type="button" data-id="{{ $v[$config['key']] }}" title="Remove this {{$name}}" data-toggle="tooltip"><i class="fa fa-times"></i></button>  
					            		 </td>
					            		 <td style="display: none">
					            			<input type="hidden" value="{{ $v[$config['key']] }}" name="{{$name}}[]">
					            		 </td>
									</tr>
								@endforeach
							@else
							<tr>
								<td colspan="3">{{$config['customLabel']}} is Empty.</td>
							</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>

			@if($errors->has($name))
			<span id="helpBlock2" class="help-block">{{ $errors->first($name) }}</span>	
			@endif

	@if ($config['useLabel'])
		</div>
	</div>
	@endif
</div>

@push('additional-css')
	@if ($useDatatable)
		{!! $attributes['datatableCSSAssets'] ?? '<link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">' !!}
	@endif

<style type="text/css">
	.select2-container--default .select2-selection--multiple{
		border-top-right-radius: 0 !important; 
	}
</style>
@endpush

@push('additional-js')
	@if ($useDatatable)
		{!! 
			$attributes['datatableJSAssets'] ?? '
			<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
			<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
			' 
		!!}
		
	@endif

<script type="text/javascript">
	var select2table_{{ $name }}, select2val_{{$name}} = {!! json_encode($value ?? []) !!};

	function addSelectedVal_{{$name}}(){
		$.each($('#{{$config['elOptions']["id"]}}').select2('data'), function(k, v){
			if (isSelectedDataExist_{{$name}}(v.id)) {
				toastr.options = {
				  "closeButton": true,
				  "debug": false,
				  "newestOnTop": false,
				  "progressBar": true,
				  "positionClass": "toast-bottom-right",
				  "preventDuplicates": false,
				  "onclick": null,
				  "showDuration": "300",
				  "hideDuration": "1000",
				  "timeOut": "5000",
				  "extendedTimeOut": "1000",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "slideDown",
				  "hideMethod": "slideUp"
				};

				toastr.warning('{{$config['customLabel']}} '+ v.text +' has been selected.', "Warning!");
			} else {
				select2val_{{$name}}.push({
					{{ $config['key'] }}: v.id,
					name: v.text
					@foreach ($config['additionalFields'] as $id => $field) 
						,{{ $field['attribute'] ?? $field }}: $('{{ $id }}').val() === "" ? "{{ $field['defaultValue'] ?? '' }}" : $('{{ $id }}').val()
					@endforeach
				})

				@if ($useDatatable)
					select2table_{{ $name }}.row.add([
						-1,
						v.text,
						'<button class="btn btn-danger btn-sm removeSelectedDataBtn_{{$name}}" type="button" data-id="'+ v.id +'" title="Remove this {{$name}}" data-toggle="tooltip"><i class="fa fa-times"></i></button>',
						'<input type="hidden" value="'+ v.id +'" name="{{$name}}[]">',
					]).draw()
				@else
					generateTable_{{$name}}()
				@endif

			    $('#{{$config['elOptions']["id"]}}').val({}).trigger('change');
			    @foreach ($config['additionalFields'] as $id => $field) 
			    	$('{{ $id }}').val('')
				@endforeach
			}
		})
	}

	function generateTable_{{$name}}() {
		@if ($useDatatable)
			select2table_{{ $name }} = $('.{{'table-select2-' . $name}}').DataTable({
				pagingType: 'numbers'
			});
		@else
		resetTable_{{$name}}()
		if (select2val_{{$name}}.length > 0) {
			$.each(select2val_{{$name}}, function(k, v) {
				var number = k+1;

		            $(".{{'table-select2-' . $name}} tbody").append(
		            	'<tr>' +
		            		'<td>' + number + '</td>' +
		            		'<td>' + v.name + '</td>' +
		            		@foreach ($config['additionalFields'] as $id => $field) 
			            		'<td>' + v.{{ $field['attribute'] ?? $field }} + '</td>' +
							@endforeach
		            		'<td>' + 
		            		 	'<button class="btn btn-danger btn-sm removeSelectedDataBtn_{{$name}}" type="button" data-id="'+ v.{{ $config['key'] }} +'" title="Remove this {{$name}}" data-toggle="tooltip"><i class="fa fa-times"></i></button>' +  
		            		 '</td>' +
		            		 '<td style="display:none">' +
		            			'<input type="hidden" value="'+ v.{{ $config['key'] }} +'" name="{{$name}}[]">' +
			            		 @foreach ($config['additionalFields'] as $id => $field) 
			            			'<input type="hidden" value="'+ v.{{ $field['attribute'] ?? $field }} +'" name="{{ $field['attribute'] ?? $field }}[]">' +
								 @endforeach
		            		 '</td>' +
		            	'</tr>' 
		            )
	        });
		} else {
			$(".{{'table-select2-' . $name}} tbody").append(
	        	'<tr>' +
	        		'<td colspan="3">{{$config['customLabel']}} is Empty.</td>' +
	        	'</tr>' 
	        )
		}
		@endif
	}

	// Remove Selected Data
	$(".{{'table-select2-' . $name}} tbody").on('click', '.removeSelectedDataBtn_{{$name}}', function(){
		if (confirm('Are you sure want to delete this?')) {
			getSelectedVal_{{$name}}($(this).attr('data-id'), true)

			@if ($useDatatable)
				select2table_{{ $name }}.row( $(this).parents('tr') ).remove().draw(false);
			@else
				$(this).closest('tr').remove()
				generateTable_{{$name}}()
			@endif
		}
	})

	function getSelectedVal_{{$name}}(id, update = false) {
		var foundVal = $.grep(select2val_{{$name}}, function(v) {
			if(update){
				console.log(v.{{ $config['key'] }} + ' : ' + id)
				return v.{{ $config['key'] }} != id
			}
		    return v.{{ $config['key'] }} == id;
		});

		if(update) {
			select2val_{{$name}} = foundVal
			return;
		}

		return foundVal;
	}

	function isSelectedDataExist_{{$name}}(id) {
		return getSelectedVal_{{$name}}(id).length > 0;
	}

	function resetTable_{{$name}}() {
		$(".{{'table-select2-' . $name}} tbody").html('')
	}

	function regenerateTable_{{$name}}() {
		select2val_{{$name}} = [];
		generateTable_{{$name}}()
	}

	$(document).ready(function(){
		generateTable_{{$name}}()
	})
</script>
@endpush