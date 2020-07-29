<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JobTitleService;

class TestController extends Controller
{
    public function __construct(JobTitleService $jobTitleService)
    {
        $this->jobTitleService = $jobTitleService;
    }

    public function test() {
        $test = $this->jobTitleService->findByName("Admin");
        return view('test', compact('test'));
    }
}
