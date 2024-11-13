<?php

namespace App\Models\ACL;

use App\Models\ACL\Menu;
use App\Models\ACL\Permission;
use App\Models\BaseModel;

class Menu extends BaseModel
{
    protected $guarded = [];
    protected $appends = ['select2_label'];

    public static function rule(){
        return [
            'label' => 'required',
            'parent_id' => 'nullable|numeric|exists:menus,id',
            'permission_id' => 'nullable|numeric|exists:permissions,id',
            'type' => 'required',
            'is_hidden' => 'nullable|numeric',
            'order' => 'nullable|numeric',
        ];
    }

    public static function ruleOnUpdate(){
        $rule = self::rule();
        // $rule['label'] = 'nullable';
        // $rule['type'] = 'nullable';

        return $rule;
    }

    public function parent(){
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function childs(){
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function permission(){
        return $this->belongsTo(Permission::class, 'permission_id');
    }

    public function getSelect2LabelAttribute()
    {
        return '<div class="badge badge-secondary me-2">'.$this->type.'</div>'.$this->label;
    }
}
