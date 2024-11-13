@extends(config('theme.layouts.admin'),[
    'title' => 'Jenis SOP',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        [
            'label' => 'Reference'
        ],
        [
            'label' => 'Jenis SOP'
        ],
    ]

])

@section('content')


    @component(config('theme.components').'.card',['name' => 'sop_type_card'])
        {!!
            DatatableBuilderHelper::render(route('sop.type.datatable'), [
                'columns' => [
                    'id',
                    'name'
                ],
                'pluginOptions' => [
                    'columnDefs' => [
                        ['targets' => 0,'visible' => false],
                        //['targets' => 1,'width' => '10px !important'],
                    ],
                ],
                'elOptions' => [
                    'id' => 'sop_type_table',
                ],
                'toolbarLocation' => '#sop_type_card .card-toolbar',
                'titleLocation' => '#sop_type_card .card-title',
                //'create' => [
                //    'modal' => 'modal_form_sop_type'
                //],
            ])
        !!}
    @endcomponent

    @component(config('theme.components').'.modal-ajax-form',[
        'title' => 'Create Jenis SOP',
        'name' => 'modal_form_sop_type',
        'table' => 'sop_type_table',
        'additionalClass' => 'mw-650px',
        'size' => '',
        'url' => route('sop.type.save'),
    ])

        {{ Form::textInput('name',null, ['formAlignment' => 'vertical', 'required' => 'required']) }}

    @endcomponent

@endsection
