<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackDuration extends Model
{
    protected $fillable = [
        'name', 'value'
    ];

    public function companies()
    {
        return $this->hasMany(FeedbackDuration::class);
    }
}
