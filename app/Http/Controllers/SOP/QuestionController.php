<?php

namespace App\Http\Controllers\SOP;

use App\Components\Filters\SOP\QuestionFilter;
use App\Components\Helpers\ResponseHelper;
use App\Exports\SOP\QuestionExport;
use App\Exports\SOP\QuestionTemplate;
use App\Exports\SOP\QuestionTemplateExport;
use App\Http\Controllers\BaseController;
use App\Imports\SOP\Question\QuestionImport;
use App\Models\SOP\Answer;
use App\Models\SOP\Question;
use Illuminate\Http\Request;

class QuestionController extends BaseController
{
    protected 
        $model = Question::class,
        $export = QuestionExport::class,
        $import = QuestionImport::class,
        $template = QuestionTemplateExport::class,
        $filter = QuestionFilter::class,
        $with_relation = ['parent','answer'],
        $select = 'questions.*',
        $views = 'sop.question',
        $edit_url = 'question/detail',
        $delete_url = 'question/delete';
        // $raw_columns = ['status','form'];

    public function save(Request $request)
    {
        $existing = $this->model::where('question_group_id',$request->question_group_id)->get();

        $newPosition = $existing->count() + 1;

        $request->merge([
            'position' => $newPosition,
        ]);

        return parent::save($request);
    }

    public function bulkCreateAnswer(Request $request)
    {
        $question = Question::find($request->question_id);
        if($question){
            $arr = preg_split("/\r\n|\n|\r/", $request->answer);
            foreach($arr as $value){
                if($value != null || $value != ''){
                    
                    $existing = Answer::where('question_id',$question->id)->get();
                    $newPosition = $existing->count() + 1;

                    Answer::updateOrCreate([
                        'question_id' => $request->question_id,
                        'content' => $value,
                    ],[
                        'position' => $newPosition,
                        'is_required' => 1,
                    ]);
                }
            }

            return ResponseHelper::sendResponse($question, 'Bulk Create Success!');
        }

        return ResponseHelper::sendError(config('dynamic-survey.question').' Not Found');
    }
}
