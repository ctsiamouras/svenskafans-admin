<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question',
        'poll_type_id',
        'number_of_votes',
        'team_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
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
     * Many to One association for Poll Type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pollType()
    {
        return $this->belongsTo(PollType::class, 'poll_type_id', 'id');
    }

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
     * One to Many association for Poll Answers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pollAnswers()
    {
        return $this->hasMany(PollAnswer::class, 'poll_id', 'id');
    }

    /**
     * One to Many association for Articles
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'poll_id', 'id');
    }
}
