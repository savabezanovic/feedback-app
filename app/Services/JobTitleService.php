<?php


namespace App\Services;


use App\Repositories\JobTitleRepository;

class JobTitleService
{
    /**
     * @var JobTitleRepository
     */
    private $jobTitle;

    public function __construct(JobTitleRepository $jobTitle)
    {
        $this->jobTitle = $jobTitle;
    }

    public function all()
    {
        return $this->jobTitle->all();
    }

    public function paginated($perPage)
    {
        return $this->jobTitle->paginated($perPage);
    }

    public function find($id)
    {
        return $this->jobTitle->find($id);
    }

    public function create($request)
    {
        return $this->jobTitle->create($request);
    }

    public function delete($id)
    {
        return $this->jobTitle->delete($this->find($id));
    }

    public function update($request, $id)
    {
        return $this->jobTitle->update($request, $this->find($id));
    }
}
