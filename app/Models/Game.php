<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'external_game_id',
        'team_home_id',
        'team_away_id',
        'start_date',
        'game_type_id',
        'referee',
        'arena',
        'spectators',
        'goal_home',
        'goal_away',
        'game_status_id',
        'show_in_live_score',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'show_in_live_score' => 'boolean',
        'created_at' => 'date:Y-m-d H:i',
        'updated_at' => 'date:Y-m-d H:i',
    ];

    /**
     * The attributes that are hidden.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Many to One association for Team (home)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teamHome()
    {
        return $this->belongsTo(Team::class, 'team_home_id', 'id');
    }

    /**
     * Many to One association for Team (away)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teamAway()
    {
        return $this->belongsTo(Team::class, 'team_away_id', 'id');
    }

    /**
     * Many to One association for Game Type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game_type()
    {
        return $this->belongsTo(GameType::class, 'game_type_id', 'id');
    }

    /**
     * Many to One association for Game Status
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game_status()
    {
        return $this->belongsTo(GameStatus::class, 'game_status_id', 'id');
    }

    /**
     * One to Many association for Articles
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'game_id', 'id');
    }
}
