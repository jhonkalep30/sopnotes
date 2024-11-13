<?php

namespace App\Models\SOP;

use App\Models\BaseModel;
use Auth;
use Carbon\Carbon;
use App\Models\Reference\Classifier;

class SurveyFile extends BaseModel
{
	protected $guarded = [];

	public function survey()
	{
		return $this->belongsTo(Survey::class);
	}

}
