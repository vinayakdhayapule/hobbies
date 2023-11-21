<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hobby;

class HobbiesTableSeeder extends Seeder
{
    public function run()
    {
        $hobbies = [
            ['name' => 'Reading'],
            ['name' => 'Gardening'],
            // Add more hobbies as needed
        ];

        foreach ($hobbies as $hobby) {
            Hobby::create($hobby);
        }
    }
}

