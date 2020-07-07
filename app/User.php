<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'active', 'company_id'
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

    public function profile() {

        return $this->hasOne(Profile::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'creator_id');
    }

    public function feedbacked()
    {
        return $this->hasMany(Feedback::class, 'target_user_id');
    }

    public function role()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasFeedback()
    {
        return $this->feedbacked()->where('creator_id', auth()->user()->id)
            ->where('created_at', '>=', Carbon::now()->subSeconds($this->company->feedbackDuration->value))
            ->latest()
            ->first();
    }

    public function activeFeedback()
    {
        return $this->feedbacked()->where('target_user_id', auth()->user()->id)
            ->where('created_at', '>=', Carbon::now()->subSeconds($this->company->feedbackDuration->value))
            ->latest()
            ->first();
    }

    public function activeFeedbacks()
    {
        return $this->feedbacked()->where('target_user_id', auth()->user()->id)
            ->where('created_at', '>=', Carbon::now()->subSeconds($this->company->feedbackDuration->value))
            ->latest()
            ->get();
    }

    public function allFeedback()
    {
        return $this->feedbacked()->where('target_user_id', $this->id)
            ->get();
    }

    public function averageFeedbackScore()
    {
        $pivots = [];

        if ($this->allFeedback()) {

            foreach ($this->allFeedback() as $feedback) {

                $pivots[] = $feedback->skills->avg('pivot.score');
            }

            return collect($pivots)->avg();
        }

        return false;
    }

    public function doneFeedback()
    {
        foreach ($this->company->users()->pluck('id')->toArray() as $memberId) {

            if ($memberId !== auth()->user()->id) {

                if (!$this->feedbacks()->where('target_user_id', $memberId)
                    ->where('created_at', '>=', Carbon::now()->subSeconds($this->company->feedbackDuration->value))
                    ->latest()
                    ->exists()) {

                    return false;
                }
            }
        }
        return true;
    }

    public function teammates()
    {
        $users = $this->company->members()
                ->where('active', true)
                ->get()->except($this->id);

        return $users->filter(function ($user) {
            if($user->role != "admin") {
                return $user;
            }
        });
    }
}
