<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

use App\User;

class Company extends Model
{

    public function user() {

        return $this->belongsToMany(User::class);

    }

    public function admin() {

        return $this->belongsTo(User::class);

    }

}
