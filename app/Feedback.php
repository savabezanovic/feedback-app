<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Feedback extends Model
{

    public function user() {

        return $this->belongsToMany(User::class);

    }

    public function comentator() {

        return $this->belongsToMany(User::class);

    }

}