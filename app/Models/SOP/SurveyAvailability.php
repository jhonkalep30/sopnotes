<?php

namespace App\Models\SOP;

use App\Models\BaseModel;
use App\Models\ACL\User;

class SurveyAvailability extends BaseModel
{
	protected $guarded = [];

	public function survey()
	{
		return $this->belongsTo(Survey::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
