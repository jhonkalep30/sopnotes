<?php

namespace App\Exports\NPS;

use App\Exports\BaseExport;
use App\Exports\NPS\NetPromoterScoreSheet;

class NetPromoterScoreExport extends BaseExport
{
    protected $params;

    public function __construct($params = [])
    {
        $this->params = $params;
    }

    public function sheets(): array
    {
        $sheets[] = new NetPromoterScoreSheet($this->params);
        
        return $sheets;
    }
}
