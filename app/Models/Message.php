<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'Message';

    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'Created' => 'date:H:i',
        'Changed' => 'date:H:i',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'FK_TeamID',
        'FK_GuestUserID',
        'TextBody',
        'NicName',
        'IP',
        'Link',
        'Created',
        'Changed',
        'isThreaded',
        'threadParent',
        'threadAmount',
        'FK_CategoryID',
        'FK_ThreadID',
        'Latitude',
        'Longitude',
        'IsMobile',
        'UpVotes',
        'VisibilityMode',
        'FK_FanTvId',
        'HiddenPost',
    ];

    /**
     * Many to One association for Site
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class, 'FK_TeamID', 'id');
    }
}
