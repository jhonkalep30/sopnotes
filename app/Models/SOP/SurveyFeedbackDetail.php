<?php

namespace App\Models\SOP;

use App\Models\BaseModel;
use App\Models\ACL\User;

class SurveyFeedbackDetail extends BaseModel
{
	protected $guarded = [];

	public function survey_feedback()
	{
		return $this->belongsTo(SurveyFeedback::class);
	}
}
