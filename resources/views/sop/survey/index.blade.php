@extends(config('theme.layouts.admin'),[
    'title' => 'Template',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        [
            'label' => 'SOP'
        ],
        ['label' => 'Template'],
    ]

])

@section('content')

    @component(config('theme.components').'.filter',['name' => 'survey_filter','buttonLocation' => '#survey_card .card-toolbar'])
        {{
            Form::select2Input('frequency',null,App\Models\SOP\Survey::getFrequency(),[
                'formAlignment' => 'vertical',
                'labelText' => 'Frequency',
            ])
        }}

        {{
            Form::select2Input('privacy',null,['0' => 'Not Published','1' => 'Published'],[
                'formAlignment' => 'vertical',
                'labelText' => 'Status',
            ])
        }}

        {{ 
            Form::select2Input('classifiers', null, route('classifier.list'),[
                'labelText' => 'Classifier',
                'formAlignment' => 'vertical',
                'pluginOptions' => ['allowClear' => false, 'multiple' => true],
            ]) 
        }}
    @endcomponent

    @component(config('theme.components').'.card',['name' => 'survey_card'])
        {!!
            DatatableBuilderHelper::render(route('sop.datatable'), [
                'columns' => [
                    'action',
                    'name',
                    // 'frequency',
                    // 'classifiers',
                    'unread_users',
                    'description',
                    // 'status',
                    'form','url',
                    // 'file',
                    'files',
                    'published_at'
                ],
                'pluginOptions' => [
                    'columnDefs' => [
                        ['targets' => 0,'width' => '10px'],
                        // ['targets' => 3,'className' => 'text-center']
                    ],
                ],
                'elOptions' => [
                    'id' => 'survey_table',
                ],
                'toolbarLocation' => '#survey_card .card-toolbar',
                'titleLocation' => '#survey_card .card-title',
                'filter_form' => 'survey_filter',
                'create' => [
                    'modal' => 'modal_form_survey'
                ],
                // 'export' => [
                //     'url' => route('sop.export'),
                //     'title' => 'NPS'
                // ],
                // 'import' => [
                //     'url' => route('sop.import'),
                //     'template' => route('sop.download-template'),
                //     'title' => 'NPS'
                // ],
                // 'job_trace' => [
                //     'title' => 'NPS',
                //     'filters' => [
                //         App\Exports\NPS\NetPromoterScoreExport::class,
                //         App\Imports\NPS\NetPromoterScoreImport::class
                //     ],
                // ],
                'noWrap' => true,
            ])
        !!}
    @endcomponent

    @component(config('theme.components').'.modal-ajax-form',[
        'title' => 'Create Template',
        'name' => 'modal_form_survey',
        'table' => 'survey_table',
        'additionalClass' => 'mw-650px',
        'size' => '',
        'url' => route('sop.save'),
    ])

        {{ Form::textInput('name',null, ['formAlignment' => 'vertical', 'required' => 'required']) }}

        {{
            Form::select2Input('frequency',null,App\Models\SOP\Survey::getFrequency(),[
                'formAlignment' => 'vertical',
                'labelText' => 'Frequency',
                'required' => 'required',
                'elOptions' => [
                    'id' => 'form_frequencies'
                ],
            ])
        }}

        {{ 
            Form::select2Input('classifiers', null, route('classifier.list'),[
                'labelText' => 'Classifier',
                'formAlignment' => 'vertical',
                'elOptions' => [
                    'id' => 'form_classifiers'
                ],
                'pluginOptions' => ['allowClear' => false, 'multiple' => true],
            ]) 
        }}

        {{ Form::textareaInput('description',null, ['formAlignment' => 'vertical', 'required' => 'required']) }}

        {{ 
            Form::fileInput('file_path', null,[
                'elOptions' => [
                    'multiple' => true
                ],
                'pluginOptions' => [
                    'showUpload' => false,
                    'showPreview' => false,
                    'dropZoneEnabled' => false,
                    'allowedFileExtensions' => ['pdf','doc','docx','doc','xlsx','xls','jpeg','jpg','png'],
                ],
                'withoutFilePreview' => true,
                'formAlignment' => 'vertical',
                'labelText' => 'File'
            ])
        }}

        {{ Form::textInput('url',null, ['formAlignment' => 'vertical']) }}

    @endcomponent

    @component(config('theme.components').'.modal-ajax-form',[
        'title' => 'Unread Users',
        'name' => 'modal_unread_users',
        'withDefaultJS' => false,
        'withDefaultSubmit' => false,
        // 'additionalClass' => 'mw-768px',
        'size' => 'xl',
    ])

    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-md-6 d-flex justify-content-center justify-content-md-start">
                    <h5>Unread Users</h5>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-center justify-content-md-end">
                    <a href="#" class="btn btn-sm btn-primary" id="unread_users_export_button">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>Export</a>
                </div>
            </div>

            <table class="table table-bordered" id="unread_users_tbl">
                <thead>
                    <tr>
                        <th class="bg-danger text-white">Nama</th>
                        <th class="bg-danger text-white">Outlet</th>
                        <th class="bg-danger text-white">Jabatan</th>
                        <th class="bg-danger text-white">Kota</th>
                        <th class="bg-danger text-white">Unit Bisnis</th>
                        <th class="bg-danger text-white">Direktorat</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    

    @endcomponent

@endsection

@push('additional-js')

<script type="text/javascript">
    function showUnread(url,sopName,id) {
        $.ajax({
            type: "GET",
            url:  url,
            beforeSend: function()
            {   
                // $('#modal_'+modalName+'_ajax_submit').attr('data-kt-indicator', 'on').attr('disabled','disabled');
            },
            success: function (result) {
                if(result.success){
                    var el = '';

                    $('#modal_unread_users_form').find('h5').html('Unread Users of '+sopName);
                    
                    $.each(result.data,function(key,item){
                        el += '<tr>';
                        el += '<td>'+(item.name ?? '-')+'</td>'
                        el += '<td>'+(item.outlet ? item.outlet.name : '-')+'</td>'
                        el += '<td>'+(item.jabatan ? item.jabatan.name : '-')+'</td>'
                        el += '<td>'+(item.kota_link ? item.kota_link.name : '-')+'</td>'
                        el += '<td>'+(item.unit_bisnis ? item.unit_bisnis.name : '-')+'</td>'
                        el += '<td>'+(item.direktorat ? item.direktorat.name : '-')+'</td>'
                        el += '</tr>';
                    });

                    $('#unread_users_export_button').attr('href','{{route('sop.export.unread-users')}}/'+id)

                    if($.fn.DataTable.isDataTable('#unread_users_tbl')){
                        $('#unread_users_tbl').DataTable().clear();
                        $('#unread_users_tbl').DataTable().destroy();
                    }
                    $('#unread_users_tbl tbody').html(el)
                    $('#unread_users_tbl').DataTable();

                    $('.dataTable').wrap('<div class="dataTables_scrollX" />');
                    $('#unread_users_tbl').DataTable().columns.adjust();

                }else{
                    swaling({'text': result.message, 'icon': 'error'})
                    // displayErrorInput(formEl, result.errors)
                }
            },
            error: function(xhr, textStatus, errorThrown){
                console.log(errorThrown);
                toasting()
            }
        }).always(function(){
            $('#modal_unread_users').modal('show');
        })
    }
</script>

@endpush
