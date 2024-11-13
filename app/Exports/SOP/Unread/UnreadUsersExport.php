<?php

namespace App\Exports\SOP\Unread;

use App\Exports\BaseExport;
use App\Exports\SOP\Unread\UnreadUsersSheet;

class UnreadUsersExport extends BaseExport
{
    protected $params;

    public function __construct($params = [])
    {
        $this->params = $params;
    }

    public function sheets(): array
    {
        $sheets[] = new UnreadUsersSheet($this->params);
        
        return $sheets;
    }
}
