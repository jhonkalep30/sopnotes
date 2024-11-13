<?php

namespace App\Models\SOP;

use App\Models\BaseModel;
use App\Models\Reference\Classifier;

class SurveyClassifier extends BaseModel
{
	protected $guarded = [];

	public function survey()
	{
		return $this->belongsTo(Survey::class);
	}

	public function classifier()
	{
		return $this->belongsTo(Classifier::class);
	}
}
