@extends(config('theme.layouts.admin'),[
    'title' => 'Kota',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        [
            'label' => 'Reference'
        ],
        [
            'label' => 'Kota'
        ],
    ]

])

@section('content')


    @component(config('theme.components').'.card',['name' => 'kota_card'])
        {!!
            DatatableBuilderHelper::render(route('kota.datatable'), [
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
                    'id' => 'kota_table',
                ],
                'toolbarLocation' => '#kota_card .card-toolbar',
                'titleLocation' => '#kota_card .card-title',
                'create' => [
                    'modal' => 'modal_form_kota'
                ],
            ])
        !!}
    @endcomponent

    @component(config('theme.components').'.modal-ajax-form',[
        'title' => 'Create Kota',
        'name' => 'modal_form_kota',
        'table' => 'kota_table',
        'additionalClass' => 'mw-650px',
        'size' => '',
        'url' => route('kota.save'),
    ])

        {{ Form::textInput('name',null, ['formAlignment' => 'vertical', 'required' => 'required']) }}

    @endcomponent

@endsection
