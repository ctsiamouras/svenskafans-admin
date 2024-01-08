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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id')->nullable()->index();
            $table->unsignedBigInteger('site_id')->nullable()->index();
//            $table->integer('article_type_id')->nullable();
            $table->string('header', 2000)->nullable();
            $table->string('intro', 5000)->nullable();
            $table->text('body_text')->nullable();
            $table->string('url');
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('game_id')->nullable()->index();
//            $table->integer('blog_id')->nullable();
            $table->unsignedBigInteger('article_type_id')->nullable()->index();
            $table->unsignedBigInteger('collection_page_id')->nullable()->index();
            $table->string('nickname', 500)->nullable();
//            $table->integer('IsDeleted')->default(0)->nullable();
//            $table->dateTime('Created')->nullable();
            $table->dateTime('published')->nullable();
//            $table->dateTime('Modified')->nullable();
            $table->unsignedBigInteger('old_article_id')->nullable()->index();
            $table->integer('number_of_views')->nullable()->default(0);
            $table->integer('number_of_comments')->nullable()->default(0);
            $table->unsignedBigInteger('comment_access_right_id')->nullable()->index();
            $table->unsignedBigInteger('image_id')->nullable()->index();
            $table->string('image_caption', 2500)->nullable();
            $table->boolean('team_show_only')->default(false);
            $table->boolean('hide_header')->default(false);
            $table->boolean('hide_author_info')->default(false);
            $table->boolean('links_in_text')->default(false);
            $table->text('body_text_linked')->nullable();
//            $table->integer('FK_MediaCollectionId')->default(0)->nullable(false);
            $table->string('read_more_links')->nullable();
            $table->integer('mobile_views')->nullable()->default(0);
            $table->integer('app_views')->nullable()->default(0);
            $table->integer('web_views')->nullable()->default(0);
            $table->boolean('hide_read_more_box')->default(false);
            $table->boolean('hide_share_box')->default(false);
            $table->unsignedBigInteger('poll_id')->default(0)->nullable()->index();
            $table->string('embed_src', 500)->nullable();
//            $table->integer('FK_GradeGroupId')->nullable();
//            $table->integer('FK_WpID')->nullable();
            $table->boolean('update_linked_text')->default(false);
            $table->string('video_content', 500)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreign('site_id')
                ->references('id')
                ->on('sites')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreign('game_id')
                ->references('id')
                ->on('games')
                ->nullOnDelete();

            $table->foreign('article_type_id')
                ->references('id')
                ->on('article_types')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreign('collection_page_id')
                ->references('id')
                ->on('collection_pages')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreign('old_article_id')
                ->references('id')
                ->on('articles')
                ->cascadeOnDelete();

            $table->foreign('image_id')
                ->references('id')
                ->on('images')
                ->nullOnDelete();

            $table->foreign('poll_id')
                ->references('id')
                ->on('polls')
                ->nullOnDelete();

            $table->foreign('comment_access_right_id')
                ->references('id')
                ->on('comment_access_rights')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
