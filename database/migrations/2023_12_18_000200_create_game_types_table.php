<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('game_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        // Insert game types
        $today = Carbon::now();
        DB::table('game_types')->insert([
            [
                'id' => 1,
                'name' => 'league',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 2,
                'name' => 'cup',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 3,
                'name' => 'other',
                'created_at' => $today,
                'updated_at' => $today,
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('game_types');
    }
};
