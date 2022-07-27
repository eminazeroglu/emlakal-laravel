<?php

namespace App\Models;

class Language extends BaseModel
{
    protected $hidden = [];
    protected $fillable = [
        'name',
        'code',
        'is_active'
    ];

    public $timestamps = false;

    public function translates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Translate::class, 'lang', 'code');
    }

    public function scopeName($q, $val)
    {
        return $q->where('name', $val);
    }

    public function scopeNameLike($q, $val)
    {
        return $q->where('name', 'like', '%' . $val . '%');
    }

    public function scopeCode($q, $val)
    {
        return $q->where('code', $val);
    }

    public function scopeActive($q, $active = 1)
    {
        return $q->where('is_active', $active);
    }
}
