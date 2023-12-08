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
        Schema::table('Message', function(Blueprint $table) {
//            $table->renameColumn('MessageID', 'id');
            $table->foreign('FK_TeamID')->references('id')->on('Team');

//            $table->index('FK_TeamID');
//            $table->index('Created');
        });
    }

    public function down()
    {
        Schema::table('Message', function(Blueprint $table) {
//            $table->renameColumn('id', 'MessageID');
            $table->dropForeign(['FK_TeamID']);

//            $table->dropIndex(['FK_TeamID']);
//            $table->dropIndex(['Created']);
        });
    }
};
