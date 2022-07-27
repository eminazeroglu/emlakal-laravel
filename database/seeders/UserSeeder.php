<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Schema;

class UserSeeder extends Seeder
{
    public function randomUser()
    {
        for ($i = 0; $i < 100; $i++):
            $faker               = Factory::create();
            $user                = new User();
            $user->email         = $faker->unique()->safeEmail();
            $user->password      = bcrypt('secret');
            $user->permission_id = 1;
            $user->name          = $faker->firstName;
            $user->surname       = $faker->lastName;
            $user->photo_path    = 'photo-' . rand(1, 10) . '.jpg';
            $user->phone         = $faker->phoneNumber;
            $user->gender        = $i % 3 == 0 ? 'woman' : 'man';
            $user->is_active     = $i % 3 === 0 ? 0 : 1;
            $user->is_block      = 0;
            $user->save();
        endfor;
    }

    public function defaultUser()
    {
        $faker = Factory::create();
        $items = [
            [
                'email'   => 'admin@app.com',
                'name'    => $faker->firstName,
                'surname' => $faker->lastName
            ],
            [
                'email'   => 'support@app.com',
                'name'    => $faker->firstName,
                'surname' => $faker->lastName
            ]
        ];
        foreach ($items as $item):
            $user                = new User();
            $user->email         = $item['email'];
            $user->password      = bcrypt('secret');
            $user->permission_id = 2;
            $user->name          = $item['name'];
            $user->surname       = $item['surname'];
            $user->photo_path    = 'photo-' . rand(1, 10) . '.jpg';
            $user->gender        = 'man';
            $user->is_active     = 1;
            $user->is_block      = 0;
            $user->save();
        endforeach;
    }

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $user = new User();
        $user->truncate();
        $this->defaultUser();
        // $this->randomUser();
        Schema::enableForeignKeyConstraints();
    }
}
