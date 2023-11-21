<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHobbiesTable extends Migration
{
    public function up()
    {
        Schema::create('hobbies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Insert static data
        $hobbies = [
            ['name' => 'Reading'],
            ['name' => 'Gardening'],
            // Add more hobbies as needed
        ];

        DB::table('hobbies')->insert($hobbies);
    }

    public function down()
    {
        Schema::dropIfExists('hobbies');
    }
}


