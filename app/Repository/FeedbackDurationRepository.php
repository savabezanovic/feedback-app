<?php


namespace App\Repositories;


use App\FeedbackDuration;

class FeedbackDurationRepository
{
    /**
     * @var FeedbackDuration
     */
    private $feedbackDuration;

    public function __construct(FeedbackDuration $feedbackDuration)
    {
        $this->feedbackDuration = $feedbackDuration;
    }

    public function all()
    {
        return $this->feedbackDuration->all();
    }
}
