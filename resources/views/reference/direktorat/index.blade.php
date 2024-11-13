@extends(config('theme.layouts.admin'),[
    'title' => 'Direktorat',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        [
            'label' => 'Reference'
        ],
        [
            'label' => 'Direktorat'
        ],
    ]

])

@section('content')


    @component(config('theme.components').'.card',['name' => 'direktorat_card'])
        {!!
            DatatableBuilderHelper::render(route('direktorat.datatable'), [
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
                    'id' => 'direktorat_table',
                ],
                'toolbarLocation' => '#direktorat_card .card-toolbar',
                'titleLocation' => '#direktorat_card .card-title',
                'create' => [
                    'modal' => 'modal_form_direktorat'
                ],
            ])
        !!}
    @endcomponent

    @component(config('theme.components').'.modal-ajax-form',[
        'title' => 'Create Direktorat',
        'name' => 'modal_form_direktorat',
        'table' => 'direktorat_table',
        'additionalClass' => 'mw-650px',
        'size' => '',
        'url' => route('direktorat.save'),
    ])

        {{ Form::textInput('name',null, ['formAlignment' => 'vertical', 'required' => 'required']) }}

    @endcomponent

@endsection
