<?php

use App\Skill;
use Illuminate\Database\Seeder;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = [
            'Leadership skills', 'English language knowledge', 'Communication skills', 'Problem solving', 'Programming skills',
            'Ability to learn', 'Workflow behaviour', 'Sense of humor'
        ];

        foreach ($skills as $skill) {
            $skill = new Skill();

            $skill->name = $skills[0];

            $skill->save();

            array_shift($skills);
        }

    }
}
