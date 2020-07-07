<?php


namespace App\Services;


use App\Repositories\CompanyRepository;
use App\User;

class CompanyService
{
    /**
     * @var CompanyRepository
     */
    private $company;
    /**
     * @var StorageService
     */
    private $storageService;

    public function __construct(CompanyRepository $company, StorageService $storageService)
    {
        $this->company = $company;
        $this->storageService = $storageService;
    }

    public function all()
    {
        return $this->company->all();
    }

    public function find($id)
    {
        return $this->company->find($id);
    }

    public function store($request)
    {
        return $this->company->store($request);
    }

    public function update($request, $id)
    {
        $company = $this->company->find($id);

        if ($request->feedback_duration_id) {

            return $this->company->updateFeedbackDurationTime($company, $request);
        }

        if ($company->name !== $request->name) {

            $this->storageService->updateCompanyDirectoryName($company, $request->name);
        }

        return $this->company->update($company, $request);
    }

    public function delete($id)
    {
        $company = $this->find($id);

        $this->storageService->deleteCompanyDirectory($company);

        return $this->company->delete($company);
    }
}
