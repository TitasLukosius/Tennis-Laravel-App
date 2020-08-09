<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function achievements() {
        return $this->belongsToMany(Achievement::class,'user_achievements');
    }

    public function roles() {
        return $this->belongsTo(UserRole::class);
    }

    public function invitationsReceived() {
        return $this->hasMany(Invitation::class, 'to_user_id');
    }

    public function invitationsSent() {
        return $this->hasMany(Invitation::class, 'from_user_id');
    }
}
