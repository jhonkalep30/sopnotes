<?php

namespace App\Models\SOP;

use App\Models\BaseModel;

class Question extends BaseModel
{
	protected $guarded = [];

	public function question_group()
	{
		return $this->belongsTo(QuestionGroup::class);
	}

	public function parent()
	{
		return $this->belongsTo(Question::class,'parent_id');
	}

	public function answer()
	{
		return $this->belongsTo(Answer::class,'answer_id');
	}

	public function answers()
	{
		return $this->hasMany(Answer::class);
	}
}
