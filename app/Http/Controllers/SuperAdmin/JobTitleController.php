<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateJobTitleRequest;
use App\Http\Requests\SuperAdminRequest;
use App\Http\Requests\UpdateJobTitleRequest;
use App\Services\JobTitleService;
use Illuminate\Http\Request;

class JobTitleController extends Controller
{
    /**
     * @var JobTitleService
     */
    private $jobTitleService;

    public function __construct(JobTitleService $jobTitleService)
    {
        $this->jobTitleService = $jobTitleService;
    }

    public function index(SuperAdminRequest $request)
    {
        $jobTitles = $this->jobTitleService->paginated(5);

        $links = $jobTitles->links()->render();

        return response()->json(['positions' => $jobTitles, 'links' => $links]);
    }

    public function paginationFetchData(SuperAdminRequest $request)
    {
        $jobTitles = $this->jobTitleService->paginated(5);

        $links = $jobTitles->links()->render();

        return response()->json(['jobTitles' => $jobTitles, 'links' => $links]);
    }

    public function store(CreateJobTitleRequest $request)
    {
        $this->jobTitleService->create($request);

        return response()->json(['success' => 'Job is saved']);
    }

    public function update(UpdateJobTitleRequest $request, $id)
    {
        $this->jobTitleService->update($request, $id);

        return response()->json(['success' => 'Job is updated']);
    }

    public function destroy(SuperAdminRequest $request, $id)
    {
        $this->jobTitleService->delete($id);

        return response()->json(['success' => 'Job is deleted']);
    }
}
