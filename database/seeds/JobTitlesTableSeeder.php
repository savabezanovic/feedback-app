<?php

use App\JobTitle;
use Illuminate\Database\Seeder;

class JobTitlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            'Senior Software Engineer', 'QA Automation Lead', 'Paid Intern', 'Poor non-paid Intern', 'Junior Web Developer',
            'Medior Web Developer', 'HR Manager', 'Team Leader', 'Project Manager', 'Web Designer', 'Graphic Designer'
        ];

        foreach ($positions as $position) {

            $jobTitle = new JobTitle();

            $jobTitle->name = $position;
            $jobTitle->save();
        }
    }
}
