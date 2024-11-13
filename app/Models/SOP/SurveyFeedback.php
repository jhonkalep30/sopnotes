<?php

namespace App\Models\SOP;

use App\Models\BaseModel;
use App\Models\ACL\User;

class SurveyFeedback extends BaseModel
{
	protected $table = 'survey_feedback';
	protected $guarded = [];

	public function survey()
	{
		return $this->belongsTo(Survey::class);
	}
	
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function details()
	{
		return $this->hasMany(SurveyFeedbackDetail::class);
	}
}
