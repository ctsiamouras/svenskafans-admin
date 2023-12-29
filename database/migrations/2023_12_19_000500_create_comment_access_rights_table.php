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
        Schema::create('comment_access_rights', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        // Insert admin user roles
        $today = Carbon::now();
        DB::table('comment_access_rights')->insert([
            [
                'id' => 1,
                'name' => 'not_active',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 2,
                'name' => 'active',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 3,
                'name' => 'active_but_locked',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 4,
                'name' => 'active_for_members',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 5,
                'name' => 'active_for_team_members',
                'created_at' => $today,
                'updated_at' => $today,
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('comment_access_rights');
    }
};
