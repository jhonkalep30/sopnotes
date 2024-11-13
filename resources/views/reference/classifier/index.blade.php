@extends(config('theme.layouts.admin'),[
    'title' => 'Jenis Classifier',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        [
            'label' => 'Reference'
        ],
        [
            'label' => 'Jenis Classifier'
        ],
    ]

])

@section('content')


    @component(config('theme.components').'.card',['name' => 'classifier_card'])
        {!!
            DatatableBuilderHelper::render(route('classifier.datatable'), [
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
                    'id' => 'classifier_table',
                ],
                'toolbarLocation' => '#classifier_card .card-toolbar',
                'titleLocation' => '#classifier_card .card-title',
                'create' => [
                    'modal' => 'modal_form_classifier'
                ],
            ])
        !!}
    @endcomponent

    @component(config('theme.components').'.modal-ajax-form',[
        'title' => 'Create Jenis Classifier',
        'name' => 'modal_form_classifier',
        'table' => 'classifier_table',
        'additionalClass' => 'mw-650px',
        'size' => '',
        'url' => route('classifier.save'),
    ])

        {{ Form::textInput('name',null, ['formAlignment' => 'vertical', 'required' => 'required']) }}

    @endcomponent

@endsection
