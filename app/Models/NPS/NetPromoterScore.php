<?php

namespace App\Models\NPS;

use App\Models\BaseModel;

class NetPromoterScore extends BaseModel
{
	protected $guarded = [];

	public function stagingData()
	{
		return $this->belongsTo(StagingData::class);
	}
}
