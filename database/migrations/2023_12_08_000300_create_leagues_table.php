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
        Schema::create('leagues', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->index();
            $table->unsignedBigInteger('site_id')->nullable()->index();
            $table->unsignedBigInteger('tournament_id')->nullable()->index();
            $table->boolean('show_in_mobile')->default(true);
            $table->string('table_dividers', 50)->nullable();
            $table->string('url', 100)->unique()->nullable();
            $table->integer('live_score_sort_order');
            $table->text('collection_page_intro_text')->nullable();
            $table->integer('resource_version')->default(0);
            $table->timestamps();

            $table->foreign('site_id')->references('id')->on('sites')->nullOnDelete();
//            $table->foreign('tournament_id')->references('id')->on('tournaments')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leagues');
    }
};
