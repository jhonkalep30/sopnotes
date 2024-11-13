@extends(config('theme.layouts.admin'),[
    'title' => 'Report',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        [
            'label' => 'SOP'
        ],
        ['label' => 'Report'],
    ]

])

@section('content')

    @component(config('theme.components').'.filter',['name' => 'report_filter','buttonLocation' => '#report_card .card-toolbar'])
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
            Form::select2Input('outlet', null, route('outlet.list'),[
                'formAlignment' => 'vertical',
                'pluginOptions' => ['allowClear' => true],
            ]) 
        }}

        {{ 
            Form::select2Input('unit_bisnis', null, route('unit.bisnis.list'),[
                'formAlignment' => 'vertical',
                'pluginOptions' => ['allowClear' => true],
            ]) 
        }}

        {{ 
            Form::dateInput('start_date', null,[
                'formAlignment' => 'vertical',
            ]) 
        }}

        {{ 
            Form::dateInput('end_date', null,[
                'formAlignment' => 'vertical',
            ]) 
        }}
    @endcomponent

    @component(config('theme.components').'.card',['name' => 'report_card'])
        {!!
            DatatableBuilderHelper::render(route('report.datatable'), [
                'columns' => [
                    'action',['attribute' => 'user_name','label' => 'User'],'outlet','unit_bisnis',['attribute' => 'survey','label' => config('dynamic-survey.survey')],
                    ['attribute' => 'duration','label' => 'Waktu'],'summary'
                ],
                'pluginOptions' => [
                    'columnDefs' => [
                        // ['targets' => 0,'width' => '10px'],
                        // ['targets' => 3,'className' => 'text-center']
                    ],
                ],
                'elOptions' => [
                    'id' => 'report_table',
                ],
                'toolbarLocation' => '#report_card .card-toolbar',
                'titleLocation' => '#report_card .card-title',
                'filter_form' => 'report_filter',
                // 'create' => [
                //     'modal' => 'modal_form_survey'
                // ],
                'export' => [
                    'url' => route('report.export'),
                    'title' => 'SOP Report'
                ],
                // 'import' => [
                //     'url' => route('sop.import'),
                //     'template' => route('sop.download-template'),
                //     'title' => 'NPS'
                // ],
                'job_trace' => [
                    'title' => 'SOP Report',
                    'filters' => [
                        App\Exports\SOP\Report\ReportExport::class,
                        // App\Imports\NPS\NetPromoterScoreImport::class
                    ],
                ],
                'noWrap' => true,
            ])
        !!}
    @endcomponent

    @component(config('theme.components').'.modal-ajax-form',[
        'title' => 'Detail Summary',
        'name' => 'modal_detail_report',
        'withDefaultJS' => false,
        'withDefaultSubmit' => false,
        // 'additionalClass' => 'mw-768px',
        'size' => 'xl',
    ])

    <div class="row">
        <div class="col-12">
            <h5>Feedback</h5>
            <table class="table table-bordered" id="feedback_tbl">
                <thead>
                    <tr>
                        <th class="bg-warning text-white">{{config('dynamic-survey.question')}}</th>
                        <th class="bg-warning text-white">{{config('dynamic-survey.answer')}}</th>
                        <th class="bg-warning text-white">Feedback</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="col-12">
            <h5>Uncompleted {{config('dynamic-survey.answer')}}</h5>
            <table class="table table-bordered" id="uncompleted_tbl">
                <thead>
                    <tr>
                        <th class="bg-danger text-white">{{config('dynamic-survey.question_group')}}</th>
                        <th class="bg-danger text-white">{{config('dynamic-survey.question')}}</th>
                        <th class="bg-danger text-white">{{config('dynamic-survey.answer')}}</th>
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
    $(document).ready(function(){

    });

    function viewDetailReport(url) {
        $.ajax({
            type: "GET",
            url:  url,
            beforeSend: function()
            {   
                // $('#modal_'+modalName+'_ajax_submit').attr('data-kt-indicator', 'on').attr('disabled','disabled');
            },
            success: function (result) {
                if(result.success){
                    var elUncompleted = '';
                    if(result.data.uncompleted){
                        $.each(result.data.uncompleted,function(question_group,questions){
                            $.each(questions,function(question,answers){
                                $.each(answers,function(key,answer){
                                    elUncompleted += '<tr><td>'+question_group+'</td><td>'+question+'</td><td>'+answer+'</td></tr>';
                                });
                            });
                        })
                    }else{
                        // elUncompleted += '<tr><td colspan="3">Empty Data</td></tr>';
                    }

                    var elFeedback = '';
                    if(result.data.feedback){
                        $.each(result.data.feedback,function(key,item){
                            elFeedback += '<tr><td>'+item.question+'</td><td>'+item.answer+'</td><td>'+item.content+'</td></tr>';
                        })
                    }else{
                        // elFeedback += '<tr><td colspan="3">Empty Data</td></tr>';
                    }

                    if($.fn.DataTable.isDataTable('#feedback_tbl')){
                        $('#feedback_tbl').DataTable().clear();
                        $('#feedback_tbl').DataTable().destroy();
                    }

                    if($.fn.DataTable.isDataTable('#uncompleted_tbl')){
                        $('#uncompleted_tbl').DataTable().clear();
                        $('#uncompleted_tbl').DataTable().destroy();
                    }

                    $('#uncompleted_tbl tbody').html(elUncompleted)
                    $('#feedback_tbl tbody').html(elFeedback)

                    $('#feedback_tbl').DataTable()
                    $('#uncompleted_tbl').DataTable()
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
            $('#modal_detail_report').modal('show');
        })
    }
</script>

@endpush
