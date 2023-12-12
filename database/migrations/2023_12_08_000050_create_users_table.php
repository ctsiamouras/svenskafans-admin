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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100)->index();
            $table->string('last_name', 100)->index();
//            $table->string('email', 100)->unique()->index();
            $table->string('email', 100)->nullable()->index();
            $table->string('nickname', 100)->nullable()->index();
            $table->string('username', 100)->unique()->index();
            $table->string('password', 100);
            $table->string('phone', 100)->nullable();
            $table->timestamp('last_login')->nullable()->default(null);
            $table->timestamp('last_password_change')->nullable();
            $table->integer('failed_login')->default(false);
            $table->boolean('locked')->default(false);
            $table->unsignedBigInteger('user_role_id')->nullable();
            $table->boolean('has_photo')->default(false);
            $table->boolean('show_email')->default(false);
            $table->string('twitter_name')->nullable();
            $table->string('resource_version')->nullable();
            $table->string('name')->default('');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_role_id')
                ->references('id')
                ->on('user_roles')
                ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
