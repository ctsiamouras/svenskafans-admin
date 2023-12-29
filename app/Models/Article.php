<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id',
        'site_id',
        'header',
        'intro',
        'body_text',
        'url',
        'user_id',
        'game_id',
        'article_type_id',
        'collection_page_id',
        'nickname',
        'published',
        'old_article_id',
        'number_of_views',
        'number_of_comments',
        'comment_access_right_id',
        'image_id',
        'image_caption',
        'team_show_only',
        'hide_header',
        'hide_author_info',
        'links_in_text',
        'body_text_linked',
        'read_more_links',
        'view_mobile',
        'view_app',
        'view_web',
        'hide_read_more_box',
        'hide_share_box',
        'poll_id',
        'embed_src',
        'update_linked_text',
        'video_content',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'team_show_only' => 'boolean',
        'hide_header' => 'boolean',
        'hide_author_info' => 'boolean',
        'links_in_text' => 'boolean',
        'hide_read_more_box' => 'boolean',
        'hide_share_box' => 'boolean',
        'update_linked_text' => 'boolean',
        'created_at' => 'date:Y-m-d H:i',
        'updated_at' => 'date:Y-m-d H:i',
        'deleted_at' => 'date:Y-m-d H:i',
    ];

    /**
     * The attributes that are hidden.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Many to One association for Team
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    /**
     * Many to One association for Site
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    /**
     * Many to One association for User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Many to One association for Game
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }

    /**
     * Many to One association for Article Type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function articleType()
    {
        return $this->belongsTo(ArticleType::class, 'article_type_id', 'id');
    }

    /**
     * Many to One association for Collection Page
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function collectionPage()
    {
        return $this->belongsTo(CollectionPage::class, 'collection_page_id', 'id');
    }

    /**
     * Many to One association for Old Article
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function oldArticle()
    {
        return $this->belongsTo(Article::class, 'old_article_id', 'id');
    }

    /**
     * One to Many association for Old Articles
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oldArticles()
    {
        return $this->hasMany(Article::class, 'old_article_id', 'id');
    }

    /**
     * Many to One association for Comment Access Right
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commentAccessRight()
    {
        return $this->belongsTo(CommentAccessRight::class, 'comment_access_right_id', 'id');
    }

    /**
     * Many to One association for Image
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id', 'id');
    }

    /**
     * Many to One association for Poll
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poll()
    {
        return $this->belongsTo(Poll::class, 'poll_id', 'id');
    }

    /**
     * One to Many association for Media Items
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mediaItems()
    {
        return $this->hasMany(MediaItem::class, 'article_id', 'id');
    }
}
