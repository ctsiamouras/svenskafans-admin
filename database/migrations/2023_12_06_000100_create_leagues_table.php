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
            $table->string('name', 50)->unique()->collation('Finnish_Swedish_CI_AS');
            $table->unsignedInteger('site_id')->nullable();
            $table->boolean('show_in_mobile')->default(true);
            $table->string('league_table_dividers', 50)->nullable()->collation('Finnish_Swedish_CI_AS');
            $table->string('league_url', 100)->nullable()->collation('Finnish_Swedish_CI_AS');
            $table->integer('live_score_sort_order');
            $table->text('collection_page_intro_text')->nullable()->collation('Finnish_Swedish_CI_AS');
            $table->unsignedBigInteger('tournament_id')->nullable();
            $table->unsignedInteger('resource_version')->default(0);
            $table->timestamps();

            $table->foreign('site_id')->references('id')->on('Site')->nullOnDelete();
//            $table->foreign('tournament_id')->references('id')->on('tournaments')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leagues');
    }
};
