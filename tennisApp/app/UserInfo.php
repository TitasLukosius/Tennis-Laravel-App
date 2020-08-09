<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'surname', 'age', 'gender', 'city', 'NTRP', 'description', 'photo'];
}
