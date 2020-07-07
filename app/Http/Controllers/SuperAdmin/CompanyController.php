<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\EditCompanyRequest;
use App\Http\Requests\SuperAdminRequest;
use App\Services\CompanyService;

class CompanyController extends Controller
{
    /**
     * @var CompanyService
     */
    private $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index(SuperAdminRequest $request)
    {
        $companies = $this->companyService->all();

        return response()->json(['companies' => $companies]);
    }

    public function store(CreateCompanyRequest $request)
    {
        $company = $this->companyService->store($request);

        return response()->json(['company' => $company, 'success' => 'Good job, fella. You successfully stored a new company']);
    }

    public function edit(SuperAdminRequest $request, $id)
    {
        $company = $this->companyService->find($id);

        return response()->json(['company', $company]);
    }

    public function update(EditCompanyRequest $request, $id)
    {
        $this->companyService->update($request, $id);

        return response()->json(['success' => 'Company is updated']);
    }

    public function destroy(SuperAdminRequest $request, $id)
    {
        $this->companyService->delete($id);

        return response()->json(['success' => 'Company is deleted']);
    }
}
