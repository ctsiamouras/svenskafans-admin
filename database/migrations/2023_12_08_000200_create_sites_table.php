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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->index();
            $table->string('url');
            $table->integer('show_in_lists')->default(false);
            $table->string('menu_color', 50)->nullable();
            $table->string('header_color', 50)->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description', 300)->nullable();
            $table->boolean('use_in_member')->default(false);
            $table->string('text_color', 50)->nullable();
            $table->dateTime('first_game_date')->nullable();
            $table->boolean('show_in_mobile')->default(true);
            $table->boolean('show_in_left_menu')->default(false);
            $table->string('title', 150)->nullable();
            $table->boolean('league_leaps_over_two_years')->default(false);
            $table->integer('sort_order');
            $table->unsignedBigInteger('sport_id')->nullable()->index();
            $table->unsignedBigInteger('country_id')->nullable()->index();
            $table->boolean('has_tournament')->default(false);
            $table->integer('resource_version')->default(0);
            $table->timestamps();

            $table->foreign('sport_id')
                ->references('id')
                ->on('sports')
                ->nullOnDelete();

            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sites');
    }
};
