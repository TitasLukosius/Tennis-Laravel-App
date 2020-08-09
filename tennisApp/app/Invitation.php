<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    public $timestamps = false;
    protected $fillable = ['from_user_id', 'to_user_id', 'date_time', 'place',];

    public function toUser() {
        return $this->belongsToMany(User::class, 'invitations');
    }

    public function fromUser() {
        return $this->belongsToMany(User::class, 'invitations');
    }
}
