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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->index();
            $table->string('long_name', 50)->nullable();
            $table->string('short_name', 50)->nullable();
            $table->unsignedBigInteger('site_id')->nullable()->index();
            $table->unsignedBigInteger('league_id')->nullable()->index();
            $table->boolean('has_team_page')->default(false);
            $table->string('brand_name', 50)->nullable();
            $table->string('ms_message', 1024)->default('');
            $table->unsignedBigInteger('players_team_image_id')->default(0)->nullable()->index();
            $table->boolean('map_players')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('site_id')
                ->references('id')
                ->on('sites')
                ->nullOnDelete();

            $table->foreign('league_id')
                ->references('id')
                ->on('leagues')
                ->nullOnDelete();

//            $table->foreign('players_team_image_id')
//                ->references('id')
//                ->on('players_team_image')
//                ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teams');
    }
};
