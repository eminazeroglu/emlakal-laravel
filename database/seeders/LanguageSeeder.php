<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $language_model = new Language();
        $language_model->truncate();
        $languages = [
            ['name' => 'Azərbaycan', 'code' => 'az', 'active' => 1],
            ['name' => 'English', 'code' => 'en', 'active' => 0],
            ['name' => 'Русский', 'code' => 'ru', 'active' => 0],
        ];
        foreach ($languages as $language):
            $language_model->insert([
                'name'      => $language['name'],
                'code'      => $language['code'],
                'is_active' => $language['active']
            ]);
        endforeach;
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
