<?php

namespace App\Exports\ACL\Users;

use App\Exports\ACL\Users\UserSheet;
use App\Exports\BaseExport;


class UserExport extends BaseExport
{
    protected $params;

    public function __construct($params = [])
    {
        $this->params = $params;
    }

    public function sheets(): array
    {
        $sheets[] = new UserSheet($this->params);
        
        return $sheets;
    }
}
