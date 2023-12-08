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
        Schema::table('Site', function(Blueprint $table) {
            $table->renameColumn('SiteID', 'id');

            $table->index('SiteName');
            $table->index('Title');
            $table->index('FK_SportID');
            $table->index('FK_CountryID');
        });
    }

    public function down()
    {
        Schema::table('Site', function(Blueprint $table) {
            $table->renameColumn('id', 'SiteID');

            $table->dropIndex(['SiteName']);
            $table->dropIndex(['Title']);
            $table->dropIndex(['FK_SportID']);
            $table->dropIndex(['FK_CountryID']);
        });
    }
};
