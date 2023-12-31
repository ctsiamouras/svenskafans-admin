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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->integer('file_size')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('header', 500)->nullable();
            $table->string('description', 5000)->nullable();
            $table->unsignedBigInteger('site_id')->nullable()->index();
            $table->unsignedBigInteger('team_id')->nullable()->index();
//            $table->integer('image_type_id')->nullable();
            $table->string('rights_text', 500)->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('site_id')
                ->references('id')
                ->on('sites')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }
};
