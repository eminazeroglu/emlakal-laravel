<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Permission extends BaseModel
{
    protected $appends    = ['name', 'option'];
    protected $hidden     = ['translate_name', 'option_field'];
    public    $timestamps = false;

    public function name(): Attribute
    {
        return new Attribute(
            get: fn() => helper()->translate($this->translate_name)
        );
    }

    public function option(): Attribute
    {
        return new Attribute(
            get: fn() => collect(json_decode($this->option_field, true))->map(fn($i) => [
                'value' => $i,
                'text'  => helper()->translate('crm.Permission.Option.' . ucfirst($i))
            ])
        );
    }

    public function scopeKey($q, $val)
    {
        return $q->where('key', $val);
    }
}
