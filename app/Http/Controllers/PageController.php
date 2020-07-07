<?php

namespace App\Http\Controllers;

use App\Http\Requests\DashboardRequest;
use App\Http\Requests\ProfileRequest;
use App\Services\CompanyService;
use App\Services\FeedbackService;
use App\Services\ProfileService;
use App\Services\SkillService;
use App\Services\UserService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * @var SkillService
     */
    private $skillService;
    /**
     * @var FeedbackService
     */
    private $feedbackService;
    /**
     * @var CompanyService
     */
    private $companyService;
    private $userService;
    /**
     * @var ProfileService
     */
    private $profileService;

    public function __construct(ProfileService $profileService, SkillService $skillService,UserService $userService, FeedbackService $feedbackService, CompanyService $companyService)
    {
        $this->skillService = $skillService;
        $this->feedbackService = $feedbackService;
        $this->companyService = $companyService;
        $this->userService = $userService;
        $this->profileService = $profileService;
    }

    public function index()
    {
        return view('homepage');
    }

    public function dashboard(DashboardRequest $request)
    {
        $skills = $this->skillService->all();

        $titles = [
            'Really bad', 'Kinda bad', 'Meh', 'Pretty good', 'Awesome'
        ];

        return view('dashboard', compact(['skills', 'titles']));
    }

    public function profile(ProfileRequest $request, $id)
    {
        $skills = $this->skillService->all();

        return view('profile', compact(['skills']));
    }

    public function feedback()
    {
        return view('feedback');
    }
}
