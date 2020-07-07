<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSkillRequest;
use App\Http\Requests\EditSkillRequest;
use App\Http\Requests\SuperAdminRequest;
use App\Services\SkillService;

class SkillController extends Controller
{
    /**
     * @var SkillService
     */
    private $skillService;

    public function __construct(SkillService $skillService)
    {
        $this->skillService = $skillService;
    }

    public function index(SuperAdminRequest $request)
    {
        $skills = $this->skillService->all();

        return response()->json(['skills' => $skills]);
    }

    public function store(CreateSkillRequest $request)
    {
        $this->skillService->store($request);

        return response()->json(['success' => 'New skill is stored']);
    }

    public function update(EditSkillRequest $request, $id)
    {
        $this->skillService->update($request, $id);

        return response()->json(['success' => 'Skill updated']);
    }

    public function destroy(SuperAdminRequest $request, $id)
    {
        $this->skillService->delete($id);

        return response()->json(['success' => 'Skill deleted']);
    }
}
