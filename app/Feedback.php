<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'creator_id', 'target_user_id', 'comment_wrong', 'comment_improve'
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'feedback_skill')
            ->withPivot('score')
            ->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
