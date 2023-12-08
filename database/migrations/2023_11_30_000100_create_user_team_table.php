<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_team', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('team_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('AdminUser')->cascadeOnDelete();
            $table->foreign('team_id')->references('id')->on('Team')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_team');
    }
};
