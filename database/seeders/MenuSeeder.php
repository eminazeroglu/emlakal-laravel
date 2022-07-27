<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function items(): array
    {
        return [
            ['name' => 'Ana səhifə', 'link' => '/', 'type' => 'header'],
            ['name' => 'Haqqımızda', 'link' => '/about', 'type' => 'header'],
        ];
    }

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $model = new Menu();
        $model->truncate();
        foreach ($this->items() as $index => $item):
            if ($item['name']):
                $langs      = \App\Models\Language::query()->pluck('code');
                $translates = [];
                foreach ($langs as $lang):
                    $translates[$lang] = [
                        'name' => $item['name']
                    ];
                endforeach;
                $model->create([
                    'link'       => $item['link'],
                    'type'       => $item['type'],
                    'position'   => $index + 1,
                    'translates' => $translates,
                    'is_active'  => 1
                ]);
            endif;
        endforeach;
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
