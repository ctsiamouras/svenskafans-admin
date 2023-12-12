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
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->string('role', 50);
            $table->timestamps();
            $table->softDeletes();
        });

        // Insert admin user roles
        $today = Carbon::now();
        DB::table('user_roles')->insert([
            [
                'id' => 1,
                'role' => 'super_admin',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 2,
                'role' => 'league_editor',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 3,
                'role' => 'team_editor',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'id' => 4,
                'role' => 'forum_editor',
                'created_at' => $today,
                'updated_at' => $today,
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('user_roles');
    }
};
