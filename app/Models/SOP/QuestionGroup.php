<?php

namespace App\Models\SOP;

use App\Models\BaseModel;

class QuestionGroup extends BaseModel
{
	protected $guarded = [];

	public function survey()
	{
		return $this->belongsTo(Survey::class);
	}

	public function questions()
	{
		return $this->hasMany(Question::class);
	}
}
