<?php

namespace App\Exports\ACL\Users;

use App\Exports\ACL\Roles\RoleSheet;
use App\Exports\ACL\Users\UserTemplate;
use App\Exports\BaseExport;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UserTemplateExport extends BaseExport implements WithMultipleSheets
{   
    public function sheets(): array
    {
        return [
            new UserTemplate,
            new RoleSheet([], 'Role'),
        ];
    }
}