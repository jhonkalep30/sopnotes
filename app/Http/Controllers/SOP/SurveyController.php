<?php

namespace App\Http\Controllers\SOP;

use App\Components\Filters\SOP\SurveyFilter;
use App\Components\Helpers\ResponseHelper;
use App\Exports\SOP\SurveyExport;
use App\Exports\SOP\SurveyTemplate;
use App\Exports\SOP\SurveyTemplateExport;
use App\Exports\SOP\Unread\UnreadUsersExport;
use App\Http\Controllers\BaseController;
use App\Imports\SOP\Survey\SurveyImport;
use App\Models\ACL\User;
use App\Models\Assets\Asset;
use App\Models\SOP\Answer;
use App\Models\SOP\Question;
use App\Models\SOP\QuestionGroup;
use App\Models\SOP\Survey;
use App\Models\SOP\SurveyAvailability;
use App\Models\SOP\SurveyClassifier;
use App\Models\SOP\SurveyFeedback;
use App\Models\SOP\SurveyFeedbackDetail;
use App\Models\SOP\SurveyFile;
use App\Models\SOP\SurveyReport;
use App\Models\SOP\SurveyReportDetail;
use App\Models\SOP\SurveyReportSummary;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class SurveyController extends BaseController
{
    protected 
        $model = Survey::class,
        $export = SurveyExport::class,
        $import = SurveyImport::class,
        $template = SurveyTemplateExport::class,
        $filter = SurveyFilter::class,
        $with_relation = ['classifiers'],
        $views = 'sop.survey',
        $edit_url = 'sop/detail',
        $delete_url = 'sop/delete',
        $raw_columns = ['name','status','form','classifiers','file','unread_users','url','files'],
        $order_by = ['column' => 'id','method' => 'desc'],
        $upload_prefix = 'template';


    public function save(Request $request)
    {
        $result = DB::transaction(function() use($request){
            if(@$request->id){
                $model = $this->model::findOrFail(@$request->id);
                $request->validate(array_merge(method_exists($model, 'ruleOnUpdate') ? $model->ruleOnUpdate() : [], method_exists($this, 'ruleOnUpdate') ? $this->ruleOnUpdate() : []));
            }else{
                $model = new $this->model;
                $request->validate(array_merge(method_exists($model, 'rule') ? $model->rule() : [], method_exists($this, 'rule') ? $this->rule() : []));
            }

            $model->name = @$request->name;
            $model->description = @$request->description;
            $model->frequency = @$request->frequency;
            $model->url = @$request->url;
            $model->save();

            // Uploading Files
            if($request->hasFile('file_path')){
                
                // Deleting Existing Files
                $existingFiles = SurveyFile::where('survey_id',$model->id)->get();
                foreach($existingFiles as $existingFile){
                    Asset::where('file',$existingFile->file_path)->delete(); 
                    delete_file($existingFile->file_path);
                    $existingFile->delete();
                }
                
                foreach($request->file_path as $file){
                    $name = $file->getClientOriginalName();
                    $size = $file->getSize();
                    $ext = $file->extension();
                    $file_path = upload_file($file, $this->upload_prefix);


                    // Upload Survey Files
                    $surveyFile = SurveyFile::create([
                        'survey_id' => $model->id,
                        'file_path' => $file_path,
                    ]);

                    // Registering Asset
                    $asset = Asset::create([
                        'name' => $name,
                        'size' => $size,
                        'ext' => $ext,
                        'file' => $file_path,
                    ]);
                }
            }

            SurveyClassifier::where('survey_id',$model->id)->delete();
            foreach(@$request->classifiers ?? [] as $classifier_id){
                SurveyClassifier::create([
                    'survey_id' => $model->id,
                    'classifier_id' => $classifier_id,
                ]);
            }

            return $model;
        });

        return ResponseHelper::sendResponse($result, 'Data Has Been Saved!');
    }

    public function customDatatable($datatable)
    {
        return $datatable->editColumn('name',function($row){
                            $el = '';
                            foreach($row->classifiers as $classifier){
                                $el .= '<span class="badge badge-primary me-1 mb-1">'.$classifier->name.'</span>';
                            }

                            if($el == ''){
                                $el .= '<span class="badge badge-info me-1 mb-1">All Classifiers</span>';
                            }

                            $class = "danger";
                            if($row->privacy == 1) $class = "success";
                            $status = '<span class="badge badge-'.$class.' me-1 mb-1">'.($row->privacy == 1 ? 'Published' : 'Not Published').'</span>';

                            $frequency = '<span class="badge badge-warning me-1 mb-1">'.Survey::getFrequency($row->frequency).'</span>';

                            return '<div>'.$row->name.'<br>'.$status.''.$frequency.''.$el.'</div>';
                        })
                        ->addColumn('classifiers',function($row){
                            $el = '';
                            foreach($row->classifiers as $classifier){
                                $el .= '<span class="badge badge-primary mx-1">'.$classifier->name.'</span>';
                            }

                            if($el == ''){
                                $el .= '<span class="badge badge-info mx-1">All Classifiers</span>';
                            }

                            return $el;
                        })
                        ->addColumn('unread_users',function($row){
                            $total = $row->unreadUsers()->count();
                            return $total > 0 ? '<span class="badge badge-danger" style="cursor:pointer" onclick="showUnread(\''.route('sop.unread',['id' => $row->id]).'\',\''.$row->name.'\',\''.encrypt_id($row->id).'\')">'.$total.' '.($total > 1 ? 'user' : 'users').'</span>' : '<span class="badge badge-success">All users has been readed</span>';
                        })
                        ->addColumn('status',function($row){
                            $class = "danger";
                            if($row->privacy == 1) $class = "success";
                            return '<span class="badge badge-'.$class.'">'.($row->privacy == 1 ? 'Published' : 'Not Published').'</span>';
                        })
                        ->addColumn('form',function($row){
                            return '<a href="'.route('sop.form').'?id='.encrypt_id($row->id).'" class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Form Editor</a>';
                        })
                        ->addColumn('file',function($row){
                            return @$row->file_path ? '<a target="_blank" href="'.$row->file_path.'" class="btn btn-sm btn-primary"><i class="fas fa-download"></i> Download</a>' : '-';
                        })
                        ->addColumn('files',function($row){
                            $el = '<a href="javascript:void(0)" class="btn btn-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start"><i class="fas fa-paperclip"></i> '.count($row->files).' Attachments</a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold fs-6 w-150px py-4" data-kt-menu="true" data-popper-placement="bottom-start">
                                        <div class="menu-item px-3">';

                            foreach($row->files as $key => $file){
                                $el .= '<a class="menu-link edit-button" href="'.$file->file_path.'" target="_blank">Attachment #'.($key+1).'</a>';
                            }

                            $el .= '</div></div>';

                            return count($row->files) > 0 ? $el : '-';
                        })
                        ->editColumn('url',function($row){
                            return @$row->url ? '<a target="_blank" href="'.$row->url.'" class="btn btn-sm btn-primary"><i class="fas fa-external-link"></i> Open Link</a>' : '-';
                        })
                        ->editColumn('frequency',function($row){
                            return $row->frequency ? Survey::getFrequency($row->frequency) : '-';
                        })
                        ->editColumn('description',function($row){
                            return $row->description ?? '-';
                        })
                        ->editColumn('published_at',function($row){
                            return $row->published_at ? Carbon::parse($row->published_at)->translatedFormat('d F Y H:i:s') : '-';
                        });
    }

    public function form(Request $request)
    {
        $id = decrypt_hash($request->id);

        $data = Survey::findOrFail($id);

        return view($this->views.'.form',['data' => $data]);
    }

    public function viewChecklist()
    {
        $data = Survey::where('privacy',1)
                    ->get()
                    ->groupBy('frequency');

        return view($this->views.'.checklist',['data' => $data]);
    }

    public function publish(Request $request,$id)
    {
        $data = Survey::findOrFail(decrypt_hash($id));
        if($data->privacy == 0){
            $data->privacy = 1;
            $data->published_at = Carbon::now()->format('Y-m-d H:i:s');
            $data->save();
            return ResponseHelper::sendResponse($data, config('dynamic-survey.survey').' Has Been Published!');
        }else{
            $data->privacy = 0;
            $data->published_at = null;
            $data->save();
            return ResponseHelper::sendResponse($data, config('dynamic-survey.survey').' Has Been Unpublished!');
        }

    }

    public function fill(Request $request)
    {
        $data = Survey::where('id',decrypt_hash($request->id))->where('privacy',1)->first();
        if($data){
            if($data->is_available == 1){
                return view($this->views.'.checklist-fill',['data' => $data]);
            }
        }

        abort(404);
    }

    public function checklistStart(Request $request)
    {
        $survey = Survey::find(decrypt_hash($request->id));
        if($survey){
            $data = SurveyReport::create([
                'user_id' => Auth::user()->id,
                'survey_id' => $survey->id,
                'outlet_id' => @Auth::user()->outlet->id,
                'kota_id' => @Auth::user()->kota_id,
                'unit_bisnis_id' => @Auth::user()->unit_bisnis_id,
                'direktorat_id' => @Auth::user()->direktorat_id,
                'survey' => $survey->name,
                'description' => $survey->description,
                'started_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            return ResponseHelper::sendResponse($data, 'Checklist Filling Has Been Started!');
        }

        return ResponseHelper::sendError('SOP Not Found');
    }

    public function checklistSave(Request $request)
    {
        $survey = Survey::find(decrypt_hash($request->id));
        if(!$survey) return ResponseHelper::sendError('SOP Not Found');

        $report = SurveyReport::where('survey_id',$survey->id)
                            ->where('user_id',Auth::user()->id)
                            ->whereNotNull('started_at')
                            ->whereNull('ended_at')
                            ->first();

        if(!$report) return ResponseHelper::sendError('Report Not Found');

        $result = DB::transaction(function() use($request,$report,$survey){
            $total = 0;
            $completed = 0;
            foreach($survey->question_groups as $question_group){
                foreach($question_group->questions as $question){
                    $answer = @$request->answer[$question->id];
                    
                    if(is_array($answer)){
                        $result = [];
                        foreach($answer as $v){
                            if($v != null){
                                $result[] = @$request->freetext[$question->id][$v] != null ? $v.'|'.$request->freetext[$question->id][$v] :  $v;
                                $completed++;
                            }
                        }

                        if(count($result) == 0){
                            $answer = null;
                        }else{
                            $answer = json_encode($result);
                        }
                    }else{
                        if($answer != null || $answer != '') $completed++;
                    }

                    $origin_answer = null;
                    if($question->answers){
                        $total += $question->answers->count();
                        $origin_answer = json_encode($question->answers->pluck('content')->toArray());
                    }else{
                        $total++;
                    }

                    SurveyReportDetail::create([
                        'survey_report_id' => $report->id,
                        'question_group_id' => $question_group->id,
                        'question_id' => $question->id,
                        'question_group' => $question_group->name,
                        'question' => $question->content,
                        'origin_answer' => $origin_answer,
                        'answer' => $answer,
                    ]);
                }
            }

            $available_at = Carbon::now();
            if($survey->frequency == 'daily') $available_at = Carbon::tomorrow();
            if($survey->frequency == 'weekly') $available_at = $available_at->copy()->addWeek()->startOfWeek();
            if($survey->frequency == 'monthly') $available_at = $available_at->copy()->addMonth()->startOfMonth();

            SurveyAvailability::updateOrCreate([
                'survey_id' => $survey->id,
                'user_id' => Auth::user()->id,
            ],[
                'available_at' => $available_at->format('Y-m-d H:i:s')
            ]);

            $report->ended_at = Carbon::now()->format('Y-m-d H:i:s');
            $report->save();

            $feedbackCount = 0;
            foreach($request->feedback as $key => $values){
                if($key == 'question_group') $module_name = QuestionGroup::class;
                if($key == 'question') $module_name = Question::class;
                if($key == 'answer') $module_name = Answer::class;
                foreach($values as $module_id => $feedback){
                    if($feedback != null || $feedback != ''){
                        $surveyFeedback = SurveyFeedback::firstOrCreate([
                            'survey_report_id' => $report->id,
                        ]);

                        // $surveyFeedback = SurveyFeedback::firstOrCreate([
                        //     'survey_id' => $survey->id,
                        //     'user_id' => Auth::user()->id,
                        // ]);

                        $feedbackDetail = SurveyFeedbackDetail::updateOrCreate([
                            'survey_feedback_id' => $surveyFeedback->id,
                            'module_id' => $module_id,
                            'module_name' => $module_name,
                        ],[
                            'feedback' => $feedback
                        ]);

                        $feedbackCount++;
                    }
                }
            }

            $uncompleted = $total - $completed;

            $started_at = Carbon::parse($report->started_at);
            $ended_at = Carbon::parse($report->ended_at);
            $duration = $ended_at->diffInSeconds($started_at);
            
            SurveyReportSummary::updateOrCreate([
                'survey_report_id' => $report->id,
            ],[
                'total' => $total,
                'uncompleted' => $uncompleted,
                'completed' => $completed,  
                'feedback' => $feedbackCount,
                'duration' => $duration,
            ]);

            return ['success' => true];
        });

        if($result['success']) return redirect()->route('checklist.view');
    }

    public function viewFeedback()
    {
        return view($this->views.'.feedback');
    }

    public function unread($id)
    {
        $survey = Survey::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $survey->unreadUsers()
        ]);
    }

    public function exportUnreadUsers($id = null)
    {
        if($id == null) abort(404);

        $survey = Survey::where('id',decrypt_hash($id))->first();
        if(!$survey) abort(404);

        $request = new Request([
            'id' => decrypt_hash($id),
        ]);
        
        $request->validate([
            'id' => 'required|integer',
        ]);

        $title = implode(' ', \Str::ucsplit(class_basename(UnreadUsersExport::class))).' - '.$survey->name;

        $fileName = $title.' (@'.Carbon::now()->format('YmdHis').').xlsx';

        return (new UnreadUsersExport($request->all()))->download($fileName);
    }
}
