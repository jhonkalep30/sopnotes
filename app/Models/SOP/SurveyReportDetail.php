<?php

namespace App\Models\SOP;

use App\Models\BaseModel;

class SurveyReportDetail extends BaseModel
{
	protected $guarded = [];

	public function report()
	{
		return $this->belongsTo(SurveyReport::class,'survey_report_id');
	}
}
