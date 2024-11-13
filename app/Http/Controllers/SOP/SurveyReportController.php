<?php

namespace App\Http\Controllers\SOP;

use App\Components\Filters\SOP\SurveyReportFilter;
use App\Components\Helpers\ResponseHelper;
use App\Exports\SOP\Report\ReportExport;
use App\Exports\SOP\SurveyReportTemplate;
use App\Exports\SOP\SurveyReportTemplateExport;
use App\Http\Controllers\BaseController;
use App\Imports\SOP\Report\ReportImport;
use App\Models\SOP\Answer;
use App\Models\SOP\Question;
use App\Models\SOP\Survey;
use App\Models\SOP\SurveyFeedback;
use App\Models\SOP\SurveyReport;
use App\Models\SOP\SurveyReportDetail;
use App\Models\SOP\SurveyReportSummary;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class SurveyReportController extends BaseController
{
    protected 
        $model = SurveyReport::class,
        $export = ReportExport::class,
        $import = ReportImport::class,
        $template = SurveyReportTemplateExport::class,
        $filter = SurveyReportFilter::class,
        $with_relation = ['user'],
        $views = 'sop.survey',
        // $edit_url = 'sop/detail',
        // $delete_url = 'sop/delete',
        $raw_columns = ['answer','duration','summary','survey'];

    public function view()
    {
        return view($this->views.'.report');
    }

    public function datatable(Request $request)
    {
        $filters = new SurveyReportFilter($request);

        $data = SurveyReportSummary::filter($filters)
                                // ->join('survey_reports','survey_report_summaries.survey_report_id','survey_reports.id')
                                // ->join('users','survey_reports.user_id','users.id')
                                ->orderByDesc('survey_report_summaries.id')
                                ->get();

        // $data = SurveyReport::filter($filters)
        //                     ->leftJoin('survey_report_details','survey_report_details.survey_report_id','survey_reports.id')
        //                     ->join('users','survey_reports.user_id','users.id')
        //                     ->select('survey_report_details.*','survey_reports.*','survey_report_details.id as id')
        //                     ->orderByDesc('survey_report_details.id')
        //                     ->get();

        return \DataTables::of($data)
                        ->editColumn('survey',function($row){
                            return (@$row->report->survey_origin->name ?? '-').(@$row->report->survey_origin->frequency ? '<br><span class="badge badge-primary">'.Survey::getFrequency($row->report->survey_origin->frequency).'</span>' : '');
                        })
                        ->addColumn('duration',function($row){
                            $started_at = Carbon::parse($row->report->started_at);
                            $ended_at = Carbon::parse($row->report->ended_at);

                            if($row->report->ended_at == null){
                                return '<span class="badge badge-warning">Sedang Mengerjakan</span>';
                            }else{
                                return '<table>
                                            <tr>
                                                <td style="padding:2px;"><strong>Mulai</strong></td>
                                                <td style="padding:2px;"><strong>:</strong></td>
                                                <td style="padding:2px;"><span class="badge badge-primary">'.$started_at->translatedFormat('d F Y H:i:s').'</span></td>
                                            </tr>
                                            <tr>
                                                <td style="padding:2px;"><strong>Selesai</strong></td>
                                                <td style="padding:2px;"><strong>:</strong></td>
                                                <td style="padding:2px;"><span class="badge badge-success">'.$ended_at->translatedFormat('d F Y H:i:s').'</span></td>
                                            </tr>
                                            <tr>
                                                <td style="padding:2px;"><strong>Durasi</strong></td>
                                                <td style="padding:2px;"><strong>:</strong></td>
                                                <td style="padding:2px;"><span class="badge badge-danger">'.$ended_at->diffForHumans($started_at,true).'</span></td>
                                            </tr>
                                        </table>';
                            }
                        })
                        ->addColumn('user_name',function($row){
                            return @$row->report->user->name ?? '-';
                        })
                        ->addColumn('frequency',function($row){
                            return @$row->report->survey_origin->frequency ? Survey::getFrequency($row->report->survey_origin->frequency) : '-';
                        })
                        ->addColumn('outlet',function($row){
                            return @$row->report->outlet->name ?? '-';
                        })
                        ->addColumn('unit_bisnis',function($row){
                            return @$row->report->unit_bisnis->name ?? '-';
                        })
                        ->addColumn('summary',function($row){
                            return '<table>
                                        <tr>
                                            <td style="padding:2px;"><strong>Completed</strong></td>
                                            <td style="padding:2px;"><strong>:</strong></td>
                                            <td style="padding:2px;"><span class="badge badge-success">'.$row->completed.'</span></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:2px;"><strong>Uncompleted</strong></td>
                                            <td style="padding:2px;"><strong>:</strong></td>
                                            <td style="padding:2px;"><span class="badge badge-danger">'.$row->uncompleted.'</span></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:2px;"><strong>Feedback</strong></td>
                                            <td style="padding:2px;"><strong>:</strong></td>
                                            <td style="padding:2px;"><span class="badge badge-warning">'.$row->feedback.'</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <button type="button" class="btn btn-info btn-sm" style="width:100%;" onclick="viewDetailReport(\''.route('report.detail-summary',['id' => $row->report->id]).'\')">View Detail</button>
                                            </td>
                                        </tr>
                                    </table>';
                        })
                        ->editColumn('question_group',function($row){
                            return @$row->report->question_group ?? '-';
                        })
                        ->editColumn('question',function($row){
                            return @$row->report->question ?? '-';
                        })
                        ->editColumn('answer',function($row){
                            $answer = json_decode($row->report->answer,true);
                            if(is_array($answer)){
                                $result = null;
                                foreach($answer as $item){
                                    $result .= '<span class="badge badge-primary me-1">'.$item.'</span>';
                                }

                                return $result;
                            }else{
                                $answer = $row->report->answer;
                            }

                            return @$answer ?? '-';
                        })
                        ->rawColumns($this->raw_columns)
                        ->make(true);
    }

    public function detailSummary($id)
    {
        $result = [];
        
        $report = SurveyReport::where('id',$id)->first();
        if($report){
            foreach($report->details as $detail){
                $answers = [];
                foreach(json_decode($detail->answer,true) ?? [] as $answer){
                    $exp = explode('|', $answer);
                    $answers[] = $exp[0];
                }

                foreach(json_decode($detail->origin_answer,true) ?? [] as $origin_answer){
                    if(!in_array($origin_answer, $answers)){
                        $result['uncompleted'][$detail->question_group][$detail->question][] = $origin_answer;
                    }
                }

            }

            $feedback = SurveyFeedback::where('survey_report_id',$report->id)->first();

            if($feedback){
                foreach($feedback->details as $key => $feedbackDetail){
                    $origin = $feedbackDetail->module_name::where('id',$feedbackDetail->module_id)->first();
                    // if($feedbackDetail->module_name == QuestionGroup::class) $section = '<span class="badge badge-primary">'.config('dynamic-survey.question_group').'</span>';
                    if($feedbackDetail->module_name == Question::class){
                        // $section = '<span class="badge badge-info">'.config('dynamic-survey.question').'</span>';
                        $question = $origin->name ?? $origin->content;
                        $answer = '-';
                    } 
                    if($feedbackDetail->module_name == Answer::class){
                        $question = $origin->question->name ?? $origin->question->content;
                        $answer = $origin->name ?? $origin->content;
                    }
                    // $result['feedback'][$key]['section'] = $section;
                    $result['feedback'][$key]['question'] = $question;
                    $result['feedback'][$key]['answer'] = $answer;
                    $result['feedback'][$key]['origin'] = $origin->name ?? $origin->content;
                    $result['feedback'][$key]['content'] = $feedbackDetail->feedback;
                }
            }
            
            
            return ResponseHelper::sendResponse($result, 'Data Found!');
        }
    }

    public function oldDetailSummary($id)
    {
        $result = [];
        
        $data = SurveyReportDetail::where('id',$id)->first();
        if($data){
            $question = Question::where('id',$data->question_id)->first();
            if($question){
                $text = [];
                foreach(json_decode($data->answer,true) ?? [] as $key => $answer){
                    $exp = explode('|', $answer);
                    $text[] = $exp[0];
                }

                foreach(json_decode($data->origin_answer,true) ?? [] as $key => $origin_answer){
                    if(!in_array($origin_answer, $text)){
                        $result['uncompleted'][] = $origin_answer;
                    }
                }

                // foreach($question->answers as $k => $v){
                //     if(!in_array($v->content, $text)){
                //         $result['uncompleted'][] = $v->content;
                //     }
                // }
            }
            
            $feedback = SurveyFeedback::where('survey_id',$data->report->survey_id)
                                    ->where('user_id',$data->report->user_id)
                                    ->first();

            if($feedback){
                foreach($feedback->details as $key => $detail){
                    $origin = $detail->module_name::where('id',$detail->module_id)->first();
                    if($detail->module_name == QuestionGroup::class) $section = '<span class="badge badge-primary">'.config('dynamic-survey.question_group').'</span>';
                    if($detail->module_name == Question::class) $section = '<span class="badge badge-info">'.config('dynamic-survey.question').'</span>';
                    if($detail->module_name == Answer::class) $section = '<span class="badge badge-success">'.config('dynamic-survey.answer').'</span>';
                    $result['feedback'][$key]['section'] = $section;
                    $result['feedback'][$key]['origin'] = $origin->name ?? $origin->content;
                    $result['feedback'][$key]['content'] = $detail->feedback;
                }
            }
            
            return ResponseHelper::sendResponse($result, 'Data Found!');
        }
    }
}
