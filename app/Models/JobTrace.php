<?php

namespace App\Models;

use App\Models\ACL\User;

class JobTrace extends BaseModel
{
    protected $guarded = [];

    const PROCESSING = 0;
    const SUCCESS = 100;
    const FAILED = 999;

    public function user()
    {
        return $this->belongsTo(User::class,'requested_by');
    }

    public function getStatus()
    {
        if($this->status == self::SUCCESS) return 'Success';
        if($this->status == self::FAILED) return 'Failed'; 

        return 'Processing'; 
    }

    public function getStatusHtml()
    {
        if($this->status == self::SUCCESS) return '<span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Success</span>';
        if($this->status == self::FAILED) return '<span class="badge badge-light-danger fw-bold fs-8 px-2 py-1 ms-2">Failed</span>'; 

        return '<span class="badge badge-light-primary fw-bold fs-8 px-2 py-1 ms-2">Processing</span>'; 
    }
}
