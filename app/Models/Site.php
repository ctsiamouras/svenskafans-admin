<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'url',
        'show_in_lists',
        'menu_color',
        'header_color',
        'meta_keywords',
        'meta_description',
        'use_in_member',
        'text_color',
        'first_game_date',
        'show_in_mobile',
        'show_in_left_menu',
        'title',
        'league_leaps_over_two_years',
        'sort_order',
        'sport_id',
        'country_id',
        'has_tournament',
        'resource_version',
    ];

    /**
     * One to Many association for Teams
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teams()
    {
        return $this->hasMany(Team::class, 'site_id', 'id');
    }

    /**
     * One to Many association for Leagues
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leagues()
    {
        return $this->hasMany(League::class, 'site_id', 'id');
    }

    /**
     * Many to One association for Country
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    /**
     * Many to One association for Sport
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sport()
    {
        return $this->belongsTo(Sport::class, 'sport_id', 'id');
    }
}
