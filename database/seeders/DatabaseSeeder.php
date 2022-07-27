<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguageSeeder::class);
        $this->call(SeoMetaTagSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(TranslateSeeder::class);
    }
}
