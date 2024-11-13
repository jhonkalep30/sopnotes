<?php

namespace App\Http\Controllers\SOP;

use App\Components\Filters\SOP\QuestionGroupFilter;
use App\Components\Helpers\ResponseHelper;
use App\Exports\SOP\QuestionGroupExport;
use App\Exports\SOP\QuestionGroupTemplate;
use App\Exports\SOP\QuestionGroupTemplateExport;
use App\Http\Controllers\BaseController;
use App\Imports\SOP\QuestionGroup\QuestionGroupImport;
use App\Models\SOP\QuestionGroup;
use Illuminate\Http\Request;

class QuestionGroupController extends BaseController
{
    protected 
        $model = QuestionGroup::class,
        $export = QuestionGroupExport::class,
        $import = QuestionGroupImport::class,
        $template = QuestionGroupTemplateExport::class,
        $filter = QuestionGroupFilter::class,
        $with_relation = ['questions.answers'],
        $views = 'sop.question-group',
        $edit_url = 'question-group/detail',
        $delete_url = 'question-group/delete';
        // $raw_columns = ['status','form'];

    public function save(Request $request)
    {
        $existing = $this->model::where('survey_id',$request->survey_id)->get();

        $newPosition = $existing->count() + 1;

        $request->merge([
            'position' => $newPosition,
        ]);

        return parent::save($request);
    }
}
