<?php

namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    protected $fillable = [
        'name', 'active', 'feedback_duration_id'
    ];

    public function feedbackDuration()
    {
        return $this->belongsTo(FeedbackDuration::class);
    }

    public function members()
    {
        return $this->hasMany(User::class);
    }

    // without admin and with active status
    public function users()
    {
        $users = $this->members()->with('profile.jobTitle')
            ->where('company_id', $this->id)
            ->where('active', true)
            ->get();

        return $users->filter(function ($user) {
            if($user->role[0]->name != 'admin') {
                return $user;
            }
        });
    }

    // shows also inactive users
    public function adminListUsers()
    {
        $users = $this->members()->with('profile.jobTitle')
            ->where('company_id', $this->id)
            ->get();

        return $users->filter(function ($user) {
            if($user->role[0]->name != 'admin') {
                return $user;
            }
        });
    }

    public function inactiveUsers()
    {
        $users = $this->members()->with('profile.jobTitle')
            ->where('company_id', $this->id)
            ->where('active', false)
            ->get();

        return $users->filter(function ($user) {
            if($user->role[0]->name != 'admin') {
                return $user;
            }
        });
    }

    public function nextFeedbackSessionDate()
    {
        $feedbackTime = $this->feedbackDuration()->first()->value;

        return Carbon::parse(now())->addSeconds($feedbackTime)->format('H:i, F, d');
    }
}
