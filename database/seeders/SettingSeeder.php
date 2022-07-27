<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Schema;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $items = [
            [
                'key'         => 'general',
                'value_field' => json_encode([
                    'language'    => 'az',
                    'address'     => ['Appication address'],
                    'emails'      => ['support@app.com'],
                    'phones'      => [
                        [
                            'number'   => '(+99412) XXX XX XX',
                            'whatsapp' => true,
                        ],
                        [
                            'number'   => '(+99412) XXX XX XX',
                            'whatsapp' => false
                        ],
                        [
                            'number'   => '(+99450) XXX XX XX',
                            'whatsapp' => false
                        ]
                    ],
                    'map'         => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3037.9129190429667!2d49.85921991564881!3d40.410779863924766!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40307d5679fa5487%3A0x421c7abe7fb496c7!2sA.Y%20Plaza%20Biznes%20Center!5e0!3m2!1str!2s!4v1612758072311!5m2!1str!2s',
                    'theme_color' => '#000'
                ])
            ],
            [
                'key'         => 'work-time',
                'value_field' => json_encode([
                    'weekdays' => '09:00 - 18:00',
                    'weekend'  => '09:00 - 18:00',
                    'sunday'   => '09:00 - 15:00',
                ])
            ],
            [
                'key'         => 'logo',
                'value_field' => json_encode([
                    'logo'             => 'logo.png',
                    'admin_logo'       => 'admin-logo.png',
                    'admin_logo_color' => 'admin-logo-color.jpg',
                    'footer'           => 'footer.png',
                    'mobile'           => 'mobile.png',
                    'favicon'          => 'favicon.png',
                    'wallpaper'        => 'wallpaper.jpg',
                ])
            ],
            [
                'key'         => 'html',
                'value_field' => json_encode([
                    'head' => null,
                    'body' => null
                ])
            ],
            [
                'key'         => 'social-page',
                'value_field' => json_encode([
                    ['icon' => 'icon-facebook', 'url' => 'https://facebook.com'],
                    ['icon' => 'icon-instagram', 'url' => 'https://instagram.com'],
                    ['icon' => 'icon-twitter', 'url' => 'https://twitter.com'],
                    ['icon' => 'icon-linkedin', 'url' => 'https://linkedin.com'],
                ])
            ],
            [
                'key'         => 'format',
                'value_field' => json_encode([
                    'file'  => [
                        'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                        'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    ],
                    'photo' => [
                        'image/jpeg', 'image/png'
                    ]
                ])
            ],
            [
                'key'         => 'mail',
                'value_field' => json_encode([
                    'email' => 'no-replay@app.com',
                    'name'  => 'Application name'
                ])
            ],
            [
                'key'         => 'notification',
                'value_field' => json_encode([
                    'key' => 'Test'
                ])
            ],
        ];
        Schema::disableForeignKeyConstraints();
        $model = new Setting();
        $model->truncate();
        foreach ($items as $item):
            $model = new Setting();
            $model->insert($item);
        endforeach;
        Schema::enableForeignKeyConstraints();
    }
}
