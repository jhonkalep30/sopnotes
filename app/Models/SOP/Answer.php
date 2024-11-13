<?php

namespace App\Models\SOP;

use App\Models\BaseModel;

class Answer extends BaseModel
{
	protected $guarded = [];
	protected $appends = ['is_trigger'];

	public function question()
	{
		return $this->belongsTo(Question::class);
	}

	public static function getTypeList($only = null)
	{
		$types = [
            'text' => 'Text', 
            'select2' => 'Select',
            'radio' => 'Radio',
            'checkbox' => 'Checkbox',
            'textarea' => 'Textarea',
            'date' => 'date',
        ];

        if($only != null){
        	$result = [];
        	foreach($types as $key => $value){
        		if(in_array($key, $only)){
	        		$result[$key] = $value;
        		}
        	}

        	return $result;
        }

        return $types;
	}

	public static function getMultipleList()
	{
		return ['select2','radio','checkbox'];
	}

	public function getIsTriggerAttribute()
	{
		$questions = Question::where('answer_id',$this->id)->first();
		return $questions ? 1 : 0;
	}
}
