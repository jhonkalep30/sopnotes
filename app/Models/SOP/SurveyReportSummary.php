<?php

namespace App\Models\SOP;

use App\Models\BaseModel;

class SurveyReportSummary extends BaseModel
{
	protected $guarded = [];

	public function report()
	{
		return $this->belongsTo(SurveyReport::class,'survey_report_id');
	}
}
