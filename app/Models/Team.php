<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
//    use SoftDeletes;

    protected $table = 'Team';

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
        'TeamName',
        'TeamNameLong',
        'TeamNameShort',
        'FK_SiteID',
        'FK_LeagueID',
        'HasTeamPage',
        'Created',
        'BrandName',
        'MsMessage',
        'AdTomaParameter',
        'PlayersTeamImageId',
        'MapPlayers',
    ];

    /**
     * Many to One association for Site
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function site()
    {
        return $this->belongsTo(Site::class, 'FK_SiteID', 'id');
    }

    /**
     * Many to One association for League
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function league()
    {
        return $this->belongsTo(League::class, 'FK_LeagueID', 'id');
    }

    /**
     * Many to Many association for User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_team', 'team_id', 'user_id');
    }
}
