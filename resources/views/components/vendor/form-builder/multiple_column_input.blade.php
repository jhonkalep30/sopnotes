@php
if (!is_array($attributes)) $attributes = [];

$config = FormBuilderHelper::setupDefaultConfig($name, $attributes);

if (empty($values)) $values = [''];

$isFirst = true;
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
			<div class="multipleInput_container">

				<div class="table-responsive">
					<table class="table" id="table-multiple_column-{{ $name }}">
						<thead>
							<tr>
								@foreach ($columns as $column)
									<?php $column['type'] = $column['type'] ?? 'text'; ?>
									@if ($column['type'] != 'hidden')
										<th>{!! $column['label'] ?? ucwords(implode(' ', explode('_', $column['name']))) !!}</th>
									@endif
								@endforeach
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $index = 1 ?>
							@foreach ($values as $v)
							<?php $v = is_array($v) ? $v : collect($v)->toArray() ?>
							<tr class="multipleColumnRow">
								@foreach ($columns as $key => $column)

									<?php
										$column['htmlOptions'] = FormBuilderHelper::arrayToHtmlAttribute(array_merge([
											'class' => 'form-control'
										], $column['elOptions'] ?? []));

										$column['type'] = $column['type'] ?? 'text';
									?>

									<td {!! $column['type'] == 'hidden' ? "style='display: none'" : ($column['options'] ?? '') !!}>
                                        @php
                                            $options = $column['fieldOptions'] ?? [];
                                            $options['useLabel'] = false;
                                            $options['elOptions'] = array_merge($column['fieldOptions']['elOptions'] ?? [], [
                                                'name' => $name .'['. $index .']['. $column['name'] .']',
                                            ]);
                                        @endphp
                                        @if ($column['type'] == 'select2')
                                            @php
                                                $options['elOptions']['id'] = "multipleColumnRow_select2-" . $column['name'] . "_" . $index;
                                            @endphp
											{{
												Form::select2Input($column['name'], [Illuminate\Support\Arr::get($v, $column['value'][0] ?? ''), Illuminate\Support\Arr::get($v, $column['value'][1] ?? '')], $column['data'], $options)
                                            }}
                                        @elseif($column['type'] == 'textarea')
                                            {{
                                                Form::textareaInput($column['name'], $v[$column['name']] ?? '', $options)
                                            }}
                                        @elseif($column['type'] == 'colorpicker')
	                                        @php
                                                $options['elOptions']['id'] = "multipleColumnRow_colorpicker-" . $column['name'] . "_" . $index;
                                            @endphp
                                            {{
                                                Form::colorpickerInput($column['name'], $v[$column['name']] ?? '', $options)
                                            }}
										@else
											<div class="form-group"><input type="{{ $column['type'] }}" value="{{ $v[$column['name']] ?? '' }}" name="{{ $name .'['. $index .']['. $column['name'] .']' }}" placeholder="Please enter {{ucwords($column['name'])}} here" {!! $column['htmlOptions'] !!}></div>
										@endif
									</td>
								@endforeach
								<td>
									@if ($index == 1)
										<button type="button" class="btn btn-primary multipleColumnInput_addRowBtn-{{  $name  }}"><span class="fas fa-plus"></span></button>
									@else
										<button type="button" class="btn btn-danger multipleInput_removeRowBtn-{{  $name  }}"><span class="fa fa-times"></span></button>
									@endif
								</td>
							</tr>
							<?php $index++ ?>
							@endforeach
						</tbody>
					</table>
				</div>

				@if($errors->has($name))
				<span id="helpBlock2" class="help-block">{{ $errors->first($name) }}</span>
				@endif

			</div>
	@if ($config['useLabel'])
		</div>
	</div>
	@endif
</div>

@push('additional-js')
<script type="text/javascript">
	$('body').on('click', '.multipleInput_removeRowBtn-{{  $name  }}', function(){
		console.log('remove-clicked');
		$(this).closest('tr').remove()
	})

	var lastRow_{{ $name }} = 0;

	function getColumn_{{ $name }}(key){
		var multipleColumn_columns_{{ $name }} = ''
		lastRow_{{ $name }} = lastRow_{{$name}} == 0 ? key : ++lastRow_{{$name}};

		@foreach ($columns as $column)

			<?php
				$column['htmlOptions'] = FormBuilderHelper::arrayToHtmlAttribute(array_merge([
					'class' => 'form-control'
				], $column['elOptions'] ?? []));

                $column['type'] = $column['type'] ?? 'text';

                $options = $column['fieldOptions'] ?? [];
                $options['useLabel'] = false;
                $options['elOptions'] = array_merge($column['fieldOptions']['elOptions'] ?? [], [
                    'name' => $name .'['. $index .']['. $column['name'] .']',
                ]);
			?>

			multipleColumn_columns_{{ $name }} += '<td {!! $column['type'] == 'hidden' ? "style=\"display: none\"" : ($column['options'] ?? '') !!}>' +

				@if ($column['type'] == 'select2')
                    '<div class="form-group"><select name="{{ $name }}[' + lastRow_{{ $name }} + '][{{ $column['name'] }}]" id="multipleColumnRow_select2-{{ $column['name'] }}_' + lastRow_{{ $name }} + '" style="width:100%"> </select></div>'
                @elseif($column['type'] == 'textarea')
                    '{!! Form::textareaInput($column['name'], $v[$column['name']] ?? '', $options) !!}'
				@elseif($column['type'] == 'colorpicker')
					'<div class="form-group"><input type="text" value="" name="{{ $name }}[' + lastRow_{{ $name }} + '][{{ $column['name'] }}]" id="multipleColumnRow_colorpicker-{{ $column['name'] }}_' + lastRow_{{ $name }} + '" placeholder="Please enter {{str_replace('_',' ',strtolower($column['name']))}} here" {!! $column['htmlOptions'] !!}></div>' +
				@else
					'<div class="form-group"><input type="{{ $column['type'] }}" value="" name="{{ $name }}[' + lastRow_{{ $name }} + '][{{ $column['name'] }}]" placeholder="Please enter {{str_replace('_',' ',strtolower($column['name']))}} here" {!! $column['htmlOptions'] !!}></div>' +
				@endif

			'</td>'
		@endforeach
		return multipleColumn_columns_{{ $name }}
	}

	function generateRow_{{ $name }}() {
		$('#table-multiple_column-{{ $name }}').append(
			'<tr class="multipleColumnRow">' +
				getColumn_{{ $name }}(++$('.multipleColumnRow').length) +
				'<td>' +
					'<button type="button" class="btn btn-danger multipleInput_removeRowBtn-{{  $name  }}"><span class="fa fa-times"></span></button>' +
				'</td>' +
			'</tr>'
		)

		@foreach ($columns as $column)
			<?php $column['type'] = $column['type'] ?? 'text'?>
			@if ($column['type'] == 'select2')
				$('#multipleColumnRow_select2-{{ $column['name'] }}_' + lastRow_{{ $name }}).select2(select2Options_{{ $column['name'] }})
			@endif

			@if ($column['type'] == 'colorpicker')
				$('#multipleColumnRow_colorpicker-{{ $column['name'] }}_' + lastRow_{{ $name }}).colorpicker()
			@endif
		@endforeach
	}

	$('body').on('click', '.multipleColumnInput_addRowBtn-{{  $name  }}', function(){
		generateRow_{{ $name }}();
	})
</script>
@endpush
