<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('external_game_id')->nullable()->index();
            $table->unsignedBigInteger('team_home_id')->index();
            $table->unsignedBigInteger('team_away_id')->index();
            $table->dateTime('start_date')->nullable();
//            $table->dateTime('end_date')->nullable();
            $table->unsignedBigInteger('game_type_id')->index();
            $table->string('referee', 50)->nullable();
            $table->string('arena', 100)->nullable();
            $table->integer('spectators')->nullable();
            $table->integer('goal_home')->nullable();
            $table->integer('goal_away')->nullable();
            $table->unsignedBigInteger('game_status_id')->index();
//            $table->integer('league_round_id')->nullable();
            $table->boolean('show_in_live_score')->default(false);
//            $table->integer('season_start')->nullable();
//            $table->integer('season_end')->nullable();
//            $table->string('team_home_name', 100)->nullable();
//            $table->string('team_away_name', 100)->nullable();
//            $table->integer('round')->nullable();
            $table->timestamps();

            $table->foreign('team_home_id')
                ->references('id')
                ->on('teams')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('team_away_id')
                ->references('id')
                ->on('teams')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('game_type_id')
                ->references('id')
                ->on('game_types');

            $table->foreign('game_status_id')
                ->references('id')
                ->on('game_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
};
