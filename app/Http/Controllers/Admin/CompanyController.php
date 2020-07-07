<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUpdateCompanyRequest;
use App\Services\CompanyService;
use Illuminate\Http\Request;

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

    public function update(AdminUpdateCompanyRequest $request, $id)
    {
        $this->companyService->update($request, $id);

        return response()->json(['success' => 'Company is updated']);
    }
}
