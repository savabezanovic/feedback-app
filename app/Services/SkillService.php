<?php


namespace App\Services;


use App\Repositories\SkillRepository;

class SkillService
{
    /**
     * @var SkillRepository
     */
    private $skill;

    public function __construct(SkillRepository $skill)
    {
        $this->skill = $skill;
    }

    public function all()
    {
        return $this->skill->all();
    }

    public function find($id)
    {
        return $this->skill->find($id);
    }

    public function store($request)
    {
        return $this->skill->store($request);
    }

    public function update($request, $id)
    {
        $skill = $this->find($id);

        return $this->skill->update($request, $skill);
    }

    public function delete($id)
    {
        $skill = $this->find($id);

        return $this->skill->delete($skill);
    }
}
