<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Влад', 'Аля', 'Огульник', 'Аня', 'Кристина', 'Максим', 'Настя', 'Рома'
        ];

        foreach ($names as $name) {
            User::create(['name' => $name, 'is_active' => true]);
        }
    }
}
