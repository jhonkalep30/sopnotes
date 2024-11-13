<?php

namespace App\Models\SOP;

use App\Models\ACL\User;
use App\Models\BaseModel;
use App\Models\Reference\Direktorat;
use App\Models\Reference\Kota;
use App\Models\Reference\Outlet;
use App\Models\Reference\UnitBisnis;

class SurveyReport extends BaseModel
{
	protected $guarded = [];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function outlet()
	{
		return $this->belongsTo(Outlet::class);
	}

	public function kota()
	{
		return $this->belongsTo(Kota::class);
	}

	public function unit_bisnis()
	{
		return $this->belongsTo(UnitBisnis::class);
	}

	public function direktorat()
	{
		return $this->belongsTo(Direktorat::class);
	}

	public function survey_origin()
	{
		return $this->belongsTo(Survey::class,'survey_id');
	}

	public function details()
	{
		return $this->hasMany(SurveyReportDetail::class);
	}
}
