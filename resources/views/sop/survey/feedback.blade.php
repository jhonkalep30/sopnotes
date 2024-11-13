@extends(config('theme.layouts.admin'),[
    'title' => 'Feedback',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        [
            'label' => 'SOP'
        ],
        ['label' => 'Feedback'],
    ]

])

@section('content')

    @component(config('theme.components').'.filter',['name' => 'feedback_filter','buttonLocation' => '#feedback_card .card-toolbar'])
        {{ 
            Form::select2Input('user', null, route('user.list'),[
                'formAlignment' => 'vertical',
                'pluginOptions' => ['allowClear' => true],
            ]) 
        }}

        {{ 
            Form::select2Input('survey', null, route('sop.list'),[
                'labelText' => 'Template',
                'formAlignment' => 'vertical',
                'pluginOptions' => ['allowClear' => true],
            ]) 
        }}

        {{ 
            Form::dateInput('date', null,[
                'formAlignment' => 'vertical',
            ]) 
        }}
    @endcomponent

    @component(config('theme.components').'.card',['name' => 'feedback_card'])
        {!!
            DatatableBuilderHelper::render(route('feedback.datatable'), [
                'columns' => [
                    'action','survey',['attribute' => 'user_name','label' => 'User'],'part','content','feedback','feedback_at'
                ],
                'pluginOptions' => [
                    'columnDefs' => [
                        // ['targets' => 0,'width' => '10px'],
                        // ['targets' => 3,'className' => 'text-center']
                    ],
                ],
                'elOptions' => [
                    'id' => 'feedback_table',
                ],
                'toolbarLocation' => '#feedback_card .card-toolbar',
                'titleLocation' => '#feedback_card .card-title',
                'filter_form' => 'feedback_filter',
                // 'create' => [
                //     'modal' => 'modal_form_survey'
                // ],
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
@endsection

@push('additional-js')

<script type="text/javascript">

</script>

@endpush
