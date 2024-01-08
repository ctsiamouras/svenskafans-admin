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
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->string('question', 500);
            $table->unsignedBigInteger('poll_type_id')->index();
            $table->integer('number_of_votes')->default(0);
            $table->unsignedBigInteger('team_id')->index();
            $table->timestamps();

            $table->foreign('poll_type_id')
                ->references('id')
                ->on('poll_types');

            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('polls');
    }
};
