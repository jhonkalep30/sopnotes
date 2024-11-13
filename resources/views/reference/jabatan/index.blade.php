@extends(config('theme.layouts.admin'),[
    'title' => 'Jabatan',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        [
            'label' => 'Reference'
        ],
        [
            'label' => 'Jabatan'
        ],
    ]

])

@section('content')


    @component(config('theme.components').'.card',['name' => 'jabatan_card'])
        {!!
            DatatableBuilderHelper::render(route('jabatan.datatable'), [
                'columns' => [
                    'id',
                    'action',
                    'name',
                    ['attribute' => 'role.name', 'label' => 'Role'],
                    'classifier',
                    'level_jabatan',
                    'jenis_jabatan',
                    'active',
                ],
                'pluginOptions' => [
                    'columnDefs' => [
                        ['targets' => 0,'visible' => false],
                        ['targets' => 4,'searchable' => false],
                        ['targets' => 1,'width' => '10px !important'],
                        ['targets' => 7,'className' => 'text-center'],
                    ],
                ],
                'elOptions' => [
                    'id' => 'jabatan_table',
                ],
                'toolbarLocation' => '#jabatan_card .card-toolbar',
                'titleLocation' => '#jabatan_card .card-title',
                'create' => [
                    'modal' => 'modal_form_jabatan'
                ],
                'noWrap' => true
            ])
        !!}
    @endcomponent

    @component(config('theme.components').'.modal-ajax-form',[
        'title' => 'Create Jabatan',
        'name' => 'modal_form_jabatan',
        'table' => 'jabatan_table',
        'additionalClass' => 'mw-650px',
        'size' => '',
        'url' => route('jabatan.save'),
    ])

        {{ Form::textInput('name',null, ['formAlignment' => 'vertical', 'required' => 'required']) }}

        {{ 
            Form::select2Input('role_id', null, route('role.list'),[
                'labelText' => 'Role',
                'required' => 'required',
                'formAlignment' => 'vertical',
                'ajaxParams' => ['exclude_master' => 1],
                'pluginOptions' => ['allowClear' => false],
            ]) 
        }}

        {{ 
            Form::select2Input('classifiers', null, route('classifier.list'),[
                'labelText' => 'Classifier',
                'formAlignment' => 'vertical',
                'pluginOptions' => ['allowClear' => false, 'multiple' => true],
            ]) 
        }}

        {{ 
            Form::select2Input('level_jabatan', null, [
                'PELAKSANA' => 'PELAKSANA',
                'SUPERVISOR' => 'SUPERVISOR',
                'ASISTEN MANAGER' => 'ASISTEN MANAGER',
                'MANAGER' => 'MANAGER',
            ], [
                'pluginOptions' => ['allowClear' => false],
                'formAlignment' => 'vertical'
            ]) 
        }}

        {{ 
            Form::select2Input('jenis_jabatan', null, [
                'PJ' => 'PJ',
                'DEFINITIF' => 'DEFINITIF',
            ], [
                'pluginOptions' => ['allowClear' => false],
                'formAlignment' => 'vertical'
            ]) 
        }}

        {{ 
            Form::switchInput('active', 1, ['formAlignment' => 'vertical'])
        }}

    @endcomponent

@endsection

@push('additional-js')
<script type="text/javascript">
    // function customViewData_jabatan_table(data) {
    //     var result = []

    //     $.each(data.jabatan_classifiers,function(key,item){
    //         result[key] = [item.classifier.id, item.classifier.name]
    //     })
        
    //     select2_setValue_test_classifier_id(result)
    // }
</script>
@endpush
