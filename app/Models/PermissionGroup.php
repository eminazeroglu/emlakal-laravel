<?php

namespace App\Models;

class PermissionGroup extends BaseModel
{
    protected $appends = ['name'];

    protected $fillable = [
        'translates',
        'url'
    ];

    public $timestamps = false;

    public function permissions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PermissionPivotGroup::class, 'group_id', 'id');
    }
}
