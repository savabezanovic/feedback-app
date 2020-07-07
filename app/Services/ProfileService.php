<?php


namespace App\Services;


use App\Repositories\ProfileRepository;

class ProfileService
{
    /**
     * @var ProfileRepository
     */
    private $profile;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var FeedbackService
     */
    private $feedbackService;

    public function __construct(ProfileRepository $profile, UserService $userService, FeedbackService $feedbackService)
    {
        $this->profile = $profile;
        $this->userService = $userService;
        $this->feedbackService = $feedbackService;
    }
}
