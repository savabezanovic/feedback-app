<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdminRequest;
use App\Services\CompanyService;
use App\Services\JobTitleService;

class SuperAdminController extends Controller
{
    /**
     * @var CompanyService
     */
    private $companyService;
    /**
     * @var JobTitleService
     */
    private $jobTitleService;

    public function __construct(CompanyService $companyService, JobTitleService $jobTitleService)
    {
        $this->companyService = $companyService;
        $this->jobTitleService = $jobTitleService;
    }

    public function index(SuperAdminRequest $request)
    {
        $companies = $this->companyService->all();

        $positions = $this->jobTitleService->all();

        return view('superadmin.control-panel', compact(['companies', 'positions']));
    }
}
