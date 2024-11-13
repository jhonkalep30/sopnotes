@extends(config('theme.layouts.admin'),[
    'title' => 'Outlet',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        [
            'label' => 'Reference'
        ],
        [
            'label' => 'Outlet'
        ],
    ]

])

@section('content')


    @component(config('theme.components').'.card',['name' => 'outlet_card'])
        {!!
            DatatableBuilderHelper::render(route('outlet.datatable'), [
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
                    'id' => 'outlet_table',
                ],
                'toolbarLocation' => '#outlet_card .card-toolbar',
                'titleLocation' => '#outlet_card .card-title',
                'create' => [
                    'modal' => 'modal_form_outlet'
                ],
            ])
        !!}
    @endcomponent

    @component(config('theme.components').'.modal-ajax-form',[
        'title' => 'Create Outlet',
        'name' => 'modal_form_outlet',
        'table' => 'outlet_table',
        'additionalClass' => 'mw-650px',
        'size' => '',
        'url' => route('outlet.save'),
    ])

        {{ Form::textInput('name',null, ['formAlignment' => 'vertical', 'required' => 'required']) }}

    @endcomponent

@endsection
