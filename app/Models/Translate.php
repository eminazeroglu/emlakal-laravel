<?php

namespace App\Models;

class Translate extends BaseModel
{
    public $timestamps = false;

    public function language(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Language::class, 'lang', 'code');
    }

    public function getKeys(): array
    {
        return [
            [
                'name' => 'Xəta mesajları',
                'key'  => 'validator'
            ],
            [
                'name' => 'Tarix',
                'key'  => 'date',
            ],
            [
                'name' => 'Statik',
                'key'  => 'enum',
            ],
            [
                'name' => 'Tablar',
                'key'  => 'routeTab',
            ],
            [
                'name' => 'Bildirişlər',
                'key'  => 'notification'
            ],
            [
                'name' => 'Düymələr',
                'key'  => 'button'
            ],
            [
                'name' => 'Giriş səhifəsi',
                'key'  => 'login'
            ],
            [
                'name' => 'Qeydiyyat səhifəsi',
                'key'  => 'register'
            ],
            [
                'name' => 'Şifrə unutdum səhifəsi',
                'key'  => 'forgetPassword'
            ],
            [
                'name' => 'Şifrə yeniləmə səhifəsi',
                'key'  => 'resetPassword'
            ],
            [
                'name'     => 'Admin panel',
                'key'      => 'crm',
                'children' => [
                    [
                        'name' => 'Səhifə başlığı',
                        'key'  => 'crm.Header'
                    ],
                    [
                        'name' => 'Menyular',
                        'key'  => 'crm.Sidebar'
                    ],
                    [
                        'name' => 'Dil səhifəsi',
                        'key'  => 'crm.Language'
                    ],
                    [
                        'name' => 'İstifadəçi səhifəsi',
                        'key'  => 'crm.User'
                    ]
                ]
            ],
        ];
    }
}
