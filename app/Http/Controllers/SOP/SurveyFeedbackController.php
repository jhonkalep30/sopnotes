<?php

namespace App\Http\Controllers\SOP;

use App\Components\Filters\SOP\SurveyFeedbackFilter;
use App\Components\Helpers\ResponseHelper;
use App\Exports\SOP\SurveyFeedbackExport;
use App\Exports\SOP\SurveyFeedbackTemplate;
use App\Exports\SOP\SurveyFeedbackTemplateExport;
use App\Http\Controllers\BaseController;
use App\Imports\SOP\Survey\SurveyFeedbackImport;
use App\Models\SOP\QuestionGroup;
use App\Models\SOP\Question;
use App\Models\SOP\Answer;
use App\Models\SOP\SurveyFeedback;
use App\Models\SOP\SurveyFeedbackDetail;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class SurveyFeedbackController extends BaseController
{
    protected 
        $model = SurveyFeedback::class,
        $export = SurveyFeedbackExport::class,
        $import = SurveyFeedbackImport::class,
        $template = SurveyFeedbackTemplateExport::class,
        $filter = SurveyFeedbackFilter::class,
        $with_relation = ['user'],
        $views = 'sop.survey',
        // $edit_url = 'sop/detail',
        // $delete_url = 'sop/delete',
        $raw_columns = ['part','content'];

    public function view()
    {
        return view($this->views.'.feedback');
    }

    public function datatable(Request $request)
    {
        $filters = new SurveyFeedbackFilter($request);

        $data = SurveyFeedbackDetail::filter($filters)
                                ->join('survey_feedback','survey_feedback_details.survey_feedback_id','survey_feedback.id')
                                ->join('users','survey_feedback.user_id','users.id')
                                ->get();

        return \DataTables::of($data)
                        ->addColumn('feedback_at',function($row){
                            return Carbon::parse($row->survey_feedback->created_at)->translatedFormat('d F Y H:i:s');
                        })
                        ->addColumn('survey',function($row){
                            return @$row->survey_feedback->survey->name ?? '-';
                        })
                        ->addColumn('user_name',function($row){
                            return @$row->survey_feedback->user->name ?? '-';
                        })
                        ->addColumn('part',function($row){
                            if($row->module_name == QuestionGroup::class) $part = '<span class="badge badge-info">Section</span>';
                            if($row->module_name == Question::class) $part = '<span class="badge badge-primary">Question</span>';
                            if($row->module_name == Answer::class) $part = '<span class="badge badge-warning">Answer</span>';
                            return $part;
                        })
                        ->addColumn('content',function($row){
                            $data = $row->module_name::find($row->module_id);
                            $content = @$data->content;
                            if($row->module_name == QuestionGroup::class) $content = $data->name.'<br>'.$data->description;
                            return $content;
                        })
                        ->rawColumns($this->raw_columns)
                        ->make(true);
    }
}
