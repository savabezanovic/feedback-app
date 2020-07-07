<?php


namespace App\Repositories;


use App\Feedback;
use Carbon\Carbon;

class FeedbackRepository
{
    /**
     * @var Feedback
     */
    private $feedback;

    public function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    public function find($id)
    {
        return $this->feedback->find($id);
    }

    public function findByUser($id)
    {
        return $this->feedback->where('target_user_id', $id)
            ->where('creator_id', auth()->user()->id)
            ->latest()
            ->first();
    }

    public function store($request)
    {
        return $this->feedback->create([
            'creator_id' => auth()->user()->id,
            'target_user_id' => $request->data['user_id'],
            'comment_wrong' => $request->data['feedback_1'],
            'comment_improve' => $request->data['feedback_2']
        ]);
    }

    public function addSkill($feedback, $id, $score)
    {
        $feedback->skills()->attach($id, ['score' => $score]);
    }

    public function allActiveForUser($user)
    {
        return $this->feedback->where('created_at', '>=', Carbon::now()->subSeconds($user->company->feedbackDuration->value))
            ->where('target_user_id', $user->id)
            ->get();
    }
}
