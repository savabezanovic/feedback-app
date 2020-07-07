<?php


namespace App\Repositories;


use App\Skill;

class SkillRepository
{
    /**
     * @var Skill
     */
    private $skill;

    public function __construct(Skill $skill)
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
        return $this->skill->create($request->all());
    }

    public function update($request, $skill)
    {
        return $skill->update($request->all());
    }

    public function delete($skill)
    {
        $skill->delete();
    }
}
