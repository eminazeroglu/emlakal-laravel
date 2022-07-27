<?php

namespace App\Models;

class PermissionPivotGroup extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'permission_id',
        'group_id',
        'option_field',
    ];

    public function permission(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Permission::class, 'id', 'permission_id');
    }

    public function group(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PermissionGroup::class, 'id', 'group_id');
    }
}
