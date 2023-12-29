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
        Schema::create('game_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        // Insert game statuses
        $today = Carbon::now();
        DB::table('game_statuses')->insert([
            [
                'id' => 1,
                'name' => 'not_started',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 2,
                'name' => 'ongoing',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 3,
                'name' => 'completed',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 4,
                'name' => 'canceled',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 5,
                'name' => 'deferred',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 6,
                'name' => 'interrupted',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 7,
                'name' => 'pushed_forward',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 8,
                'name' => 'walk_over',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 9,
                'name' => 'not_decided',
                'created_at' => $today,
                'updated_at' => $today,
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('game_statuses');
    }
};
