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
        Schema::table('Team', function(Blueprint $table) {
            $table->renameColumn('TeamID', 'id');
        });
    }

    public function down()
    {
        Schema::table('Team', function(Blueprint $table) {
            $table->renameColumn('id', 'TeamID');
        });
    }
};