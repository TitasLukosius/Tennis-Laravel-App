<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'surname', 'points'];

    public function users() {
        return $this->belongsToMany(User::class, 'user_achievements');
    }
}
