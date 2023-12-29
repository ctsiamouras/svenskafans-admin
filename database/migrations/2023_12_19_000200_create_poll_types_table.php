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
        Schema::create('poll_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        // Insert admin user roles
        $today = Carbon::now();
        DB::table('poll_types')->insert([
            [
                'id' => 1,
                'name' => 'open',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 2,
                'name' => 'yes_no',
                'created_at' => $today,
                'updated_at' => $today,
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('poll_types');
    }
};
