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
        Schema::create('media_item_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        // Insert media item types
        $today = Carbon::now();
        DB::table('media_item_types')->insert([
            [
                'id' => 1,
                'name' => 'image',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 2,
                'name' => 'youtube_clip',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 3,
                'name' => 'fan_tv_clip',
                'created_at' => $today,
                'updated_at' => $today,
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('media_item_types');
    }
};
