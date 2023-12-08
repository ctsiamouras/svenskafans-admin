<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $table = 'Site';

    public $timestamps = false;

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
        'SiteName',
        'SiteURL',
        'IsVisible',
        'MenuColor',
        'HeaderColor',
        'META_Keywords',
        'META_Description',
        'UseInMember',
        'TextColor',
        'FirstGameDate',
        'ShowInMobile',
        'ShowInLeftMenu',
        'Title',
        'LeagueLeapsOverTwoYears',
        'SortOrder',
        'FK_SportID',
        'FK_CountryID',
        'HasTournament',
        'ResourceVersion',
    ];

    /**
     * One to Many association for Teams
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teams()
    {
        return $this->hasMany(Team::class, 'FK_SiteID', 'id');
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
        return $this->belongsTo(Country::class, 'FK_CountryID', 'id');
    }

    /**
     * Many to One association for Sport
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sport()
    {
        return $this->belongsTo(Sport::class, 'FK_SportID', 'id');
    }
}
