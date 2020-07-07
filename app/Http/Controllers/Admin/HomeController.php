<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Repositories\FeedbackDurationRepository;
use App\Services\CompanyService;
use App\Services\FeedbackDurationService;
use App\Services\FeedbackService;
use App\Services\JobTitleService;
use App\Services\UserService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var CompanyService
     */
    private $companyService;
    /**
     * @var JobTitleService
     */
    private $jobTitleService;
    /**
     * @var FeedbackDurationService
     */
    private $feedbackDurationService;
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(CompanyService $companyService, JobTitleService $jobTitleService, FeedbackDurationService $feedbackDurationService, UserService $userService)
    {
        $this->companyService = $companyService;
        $this->jobTitleService = $jobTitleService;
        $this->feedbackDurationService = $feedbackDurationService;
        $this->userService = $userService;
    }

    public function index(AdminRequest $request)
    {
        $positions = $this->jobTitleService->all();

        $durations = $this->feedbackDurationService->all();

        $highest = $this->userService->highestAverageFeedbackScore();

        $lowest = $this->userService->lowestAverageFeedbackScore();

        return view('admin.index', compact(['positions', 'durations', 'highest', 'lowest']));
    }
}
