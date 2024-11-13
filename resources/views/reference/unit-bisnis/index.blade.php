@extends(config('theme.layouts.admin'),[
    'title' => 'Unit Bisnis',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        [
            'label' => 'Reference'
        ],
        [
            'label' => 'Unit Bisnis'
        ],
    ]

])

@section('content')


    @component(config('theme.components').'.card',['name' => 'unit_bisnis_card'])
        {!!
            DatatableBuilderHelper::render(route('unit.bisnis.datatable'), [
                'columns' => [
                    'id',
                    'action',
                    'name'
                ],
                'pluginOptions' => [
                    'columnDefs' => [
                        ['targets' => 0,'visible' => false],
                        ['targets' => 1,'width' => '10px !important'],
                    ],
                ],
                'elOptions' => [
                    'id' => 'unit_bisnis_table',
                ],
                'toolbarLocation' => '#unit_bisnis_card .card-toolbar',
                'titleLocation' => '#unit_bisnis_card .card-title',
                'create' => [
                    'modal' => 'modal_form_unit_bisnis'
                ],
            ])
        !!}
    @endcomponent

    @component(config('theme.components').'.modal-ajax-form',[
        'title' => 'Create Unit Bisnis',
        'name' => 'modal_form_unit_bisnis',
        'table' => 'unit_bisnis_table',
        'additionalClass' => 'mw-650px',
        'size' => '',
        'url' => route('unit.bisnis.save'),
    ])

        {{ Form::textInput('name',null, ['formAlignment' => 'vertical', 'required' => 'required']) }}

    @endcomponent

@endsection
