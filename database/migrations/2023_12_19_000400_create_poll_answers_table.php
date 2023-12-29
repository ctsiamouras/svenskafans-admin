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
        Schema::create('poll_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poll_id')->index();
            $table->string('answer', 100);
            $table->integer('number_of_answers')->default(0);
            $table->timestamps();

            $table->unique('poll_id', 'answer');

            $table->foreign('poll_id')
                ->references('id')
                ->on('polls')
                ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('poll_answers');
    }
};
