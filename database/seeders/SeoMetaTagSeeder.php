<?php

namespace Database\Seeders;

use App\Models\SeoMetaTag;
use Illuminate\Database\Seeder;
use Schema;

class SeoMetaTagSeeder extends Seeder
{
    public function items(): array
    {
        return [
            [
                'url'         => '/',
                'title'       => 'Ana səhifə',
                'description' => 'Ana səhifə açıqlama',
                'keywords'    => 'Ana səhifə, Home Page',
            ],
            [
                'url'         => '/contact',
                'title'       => 'Əlaqə',
                'description' => 'Əlaqə açıqlama',
                'keywords'    => 'Əlaqə, Contact Page',
            ]
        ];
    }

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $model = new SeoMetaTag();
        $model->truncate();
        foreach ($this->items() as $item):
            $model              = new SeoMetaTag();
            $model->url         = $item['url'];
            $model->title       = $item['title'];
            $model->description = $item['description'];
            $model->keywords    = $item['keywords'];
            $model->bots        = json_encode([
                'robots'    => 'index, follow, archive',
                'googlebot' => 'index, follow, archive',
                'yahoobot'  => 'index, follow, archive',
                'alexabot'  => 'index, follow, archive',
                'msnbot'    => 'index, follow, archive',
                'dmozbot'   => 'index, follow, archive',
            ]);
            $model->save();
        endforeach;
        Schema::enableForeignKeyConstraints();
    }
}
