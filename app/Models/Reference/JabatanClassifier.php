<?php

namespace App\Models\Reference;

use App\Models\BaseModel;
use App\Models\Reference\Classifier;
use App\Models\Reference\Jabatan;

class JabatanClassifier extends BaseModel
{
	protected $guarded = [];

	public function jabatan()
	{
		return $this->belongsTo(Jabatan::class);
	}

	public function classifier()
	{
		return $this->belongsTo(Classifier::class);
	}
}
