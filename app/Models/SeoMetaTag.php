<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

class SeoMetaTag extends BaseModel
{
    protected $fillable = [
        'url',
        'title',
        'description',
        'keywords',
        'bots',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function bots(): Attribute
    {
        return new Attribute(
            get: fn($i) => json_decode($i, true)
        );
    }

    public function scopeUrl($q, $url)
    {
        return $q->where('url', $url);
    }

    public function scopeUrlLike($q, $url)
    {
        return $q->where('url', 'like', '%' . $url . '%');
    }

    public function scopeTitleLike($q, $title)
    {
        return $q->where('title', 'like', '%' . $title . '%');
    }
}
