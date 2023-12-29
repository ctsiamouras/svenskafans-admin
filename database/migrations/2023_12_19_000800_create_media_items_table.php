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
        Schema::create('media_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('image_id')->nullable();
            $table->unsignedBigInteger('media_item_type_id')->nullable();
            $table->integer('sort_order');
            $table->string('external_media_id')->nullable();
            $table->string('description', 256)->nullable();
            $table->timestamps();

            $table->foreign('article_id')
                ->references('id')
                ->on('articles')
                ->cascadeOnDelete();

            $table->foreign('image_id')
                ->references('id')
                ->on('images')
                ->nullOnDelete();

            $table->foreign('media_item_type_id')
                ->references('id')
                ->on('media_item_types')
                ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('media_items');
    }
};
