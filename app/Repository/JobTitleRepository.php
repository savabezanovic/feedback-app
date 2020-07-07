<?php


namespace App\Repositories;


use App\JobTitle;

class JobTitleRepository
{
    /**
     * @var JobTitle
     */
    private $jobTitle;

    public function __construct(JobTitle $jobTitle)
    {
        $this->jobTitle = $jobTitle;
    }

    public function all()
    {
        return $this->jobTitle->all();
    }

    public function paginated($perPage)
    {
        return $this->jobTitle->paginate($perPage);
    }

    public function find($id)
    {
        return $this->jobTitle->find($id);
    }

    public function create($request)
    {
        return $this->jobTitle->create($request->all());
    }

    public function delete($jobTitle)
    {
        $jobTitle->delete();
    }

    public function update($request, $jobTitle)
    {
        return $jobTitle->update($request->all());
    }
}
