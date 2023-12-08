<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

//class User extends Authenticatable implements FilamentUser, HasName
class User extends Authenticatable implements HasName
{
    use HasApiTokens, HasFactory, Notifiable;
//    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

//    public function canAccessPanel(Panel $panel): bool
//    {
//        return true;
//    }

    protected $table = 'AdminUser';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'FirstName',
        'LastName',
        'Email',
        'NicName',
        'UserName',
        'password',
        'Phone',
        'LastLoggin',
        'LastPWDChange',
        'FailedLoggin',
        'Locked',
        'FK_AdminUserTypeID',
        'HasPhoto',
        'ShowEmail',
        'TwitterName',
        'ResourceVersion',
        'name',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'LastLoggin',
        'LastPWDChange',
        'FailedLoggin',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getFilamentName(): string
    {
        return "{$this->FirstName} {$this->LastName}";
    }

    /**
     * Many to One association for Site
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(UserRole::class, 'FK_AdminUserTypeID', 'id');
    }

    /**
     * Many to Many association for Site
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'user_team');
    }
}
