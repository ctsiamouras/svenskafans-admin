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
        Schema::table('AdminUser', function(Blueprint $table) {
            $table->renameColumn('AdminUserID', 'id');
            $table->renameColumn('Password', 'password');
            $table->string('name')->default('');
            $table->rememberToken();
            $table->timestamps();

            $table->index('Email');
            $table->index('NicName');
            $table->index('FirstName');
            $table->index('LastName');
            $table->index('UserName');
        });
    }

    public function down()
    {
        Schema::table('AdminUser', function(Blueprint $table) {
            $table->renameColumn('id', 'AdminUserID');
            $table->renameColumn('password', 'Password');
            $table->dropColumn('name');
            $table->dropColumn('remember_token');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');

            $table->dropIndex(['Email']);
            $table->dropIndex(['NicName']);
            $table->dropIndex(['FirstName']);
            $table->dropIndex(['LastName']);
            $table->dropIndex(['UserName']);
        });
    }
};
