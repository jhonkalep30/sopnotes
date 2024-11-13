<?php

namespace App\Models\Reference;

use App\Models\ACL\Role;
use App\Models\BaseModel;
use App\Models\Reference\JabatanClassifier;

class Jabatan extends BaseModel
{
	protected $table = 'jabatan';

	protected $guarded = [];

	public function rule()
    {
        return [
            'name' => 'required|string',
            'role_id' => 'required|integer|exists:roles,id',
            'level_jabatan' => 'nullable|string',
            'jenis_jabatan' => 'nullable|string',
            'active' => 'nullable|numeric',
        ];
    }

    public function ruleOnUpdate()
    {
        return [
            'name' => 'nullable|string',
            'role_id' => 'nullable|integer|exists:roles,id',
            'level_jabatan' => 'nullable|string',
            'jenis_jabatan' => 'nullable|string',
            'active' => 'nullable|numeric',
        ];
    }

	public function role()
	{
		return $this->belongsTo(Role::class);
	}

	public function jabatanClassifiers()
	{
		return $this->hasMany(JabatanClassifier::class, 'jabatan_id');
	}

    public function classifiers()
    {
        return $this->belongsToMany(Classifier::class,JabatanClassifier::class,'jabatan_id','classifier_id')
                    // ->withPivot()
                    ->whereNull('jabatan_classifiers.deleted_at');
    }
}
