<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Setting extends BaseModel
{
    protected     $hidden     = ['value_field'];
    protected     $appends    = ['value', 'photo'];
    public        $timestamps = false;
    public string $path       = 'setting';
    protected $fillable = [
        'value_field'
    ];

    public function value(): Attribute
    {
        return new Attribute(
            get: fn() => $this->value_field ? json_decode($this->value_field, true) : []
        );
    }

    public function scopeKey($q, $val)
    {
        return $q->where('key', $val);
    }
}
