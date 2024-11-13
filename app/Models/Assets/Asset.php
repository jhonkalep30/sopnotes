<?php

namespace App\Models\Assets;

use App\Models\ACL\Role;
use App\Models\BaseModel;

class Asset extends BaseModel
{
	protected $guarded = [];
    protected $hidden = [];

	public function rule()
    {
        return [
            'file' => 'required',
        ];
    }

    public function ruleOnUpdate()
    {
        return [
            'file' => 'nullable',
        ];
    }
}
