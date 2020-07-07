<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name', 'slug'
    ];

    public function feedbacks()
    {
        return $this->belongsToMany(Feedback::class, 'feedback_skill')
            ->withPivot('score')
            ->withTimestamps();
    }

    public function averageForUser($user)
    {
        $perUser = [];

        foreach ($this->feedbacks()->where('target_user_id', $user->id)->get() as $feedback)  {

            $perUser[] = $feedback->skills->where('id', $this->id)->avg('pivot.score');
        }

        return collect($perUser)->avg();
    }
}
