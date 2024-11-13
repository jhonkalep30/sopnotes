<?php

namespace App\Exports\SOP\Report;

use App\Exports\BaseExport;
use App\Exports\SOP\Report\ReportSheet;

class ReportExport extends BaseExport
{
    protected $params;

    public function __construct($params = [])
    {
        $this->params = $params;
    }

    public function sheets(): array
    {
        $sheets[] = new ReportSheet($this->params);
        
        return $sheets;
    }
}
