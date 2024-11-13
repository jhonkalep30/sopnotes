<?php

namespace App\Http\Controllers\SOP;

use App\Components\Filters\SOP\AnswerFilter;
use App\Components\Helpers\ResponseHelper;
use App\Exports\SOP\AnswerExport;
use App\Exports\SOP\AnswerTemplate;
use App\Exports\SOP\AnswerTemplateExport;
use App\Http\Controllers\BaseController;
use App\Imports\SOP\Answer\AnswerImport;
use App\Models\SOP\Answer;
use App\Models\SOP\Question;
use Illuminate\Http\Request;
use DB;

class AnswerController extends BaseController
{
    protected 
        $model = Answer::class,
        $export = AnswerExport::class,
        $import = AnswerImport::class,
        $template = AnswerTemplateExport::class,
        $filter = AnswerFilter::class,
        $with_relation = ['question'],
        $views = 'sop.answer',
        $edit_url = 'answer/detail',
        $delete_url = 'answer/delete';
        // $raw_columns = ['status','form'];

    public function save(Request $request)
    {
        $existing = $this->model::where('question_id',$request->question_id)->get();

        $newPosition = $existing->count() + 1;

        $request->merge([
            'position' => $newPosition,
        ]);

        return parent::save($request);
    }

    public function delete($id)
    {
        $id = request()->id;

        $result = DB::transaction(function() use($id){
            $model = $this->model::findOrFail($id);

            // Deleting Questions With Answer Trigger
            $questions = Question::where('answer_id',$model->id)->delete();

            $model->delete();

            return $model;
        });

        return ResponseHelper::sendResponse($result, 'Data Has Been Deleted!');
    }
}
