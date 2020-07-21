<?php


namespace App\Services;


use App\Repositories\FeedbackDurationRepository;

class FeedbackDurationService
{
    /**
     * @var FeedbackDurationRepository
     */
    private $feedbackDuration;

    public function __construct(FeedbackDurationRepository $feedbackDuration)
    {
        $this->feedbackDuration = $feedbackDuration;
    }

    public function all()
    {
        return $this->feedbackDuration->all();
    }
}
