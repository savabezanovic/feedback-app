<?php

use App\Profile;
use App\Services\CompanyService;
use App\Services\JobTitleService;
use App\Services\UserService;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{

    /**
     * @var \App\Services\UserService
     */
    private $userService;
    /**
     * @var Faker
     */
    private $faker;
    /**
     * @var \App\Services\JobTitleService
     */
    private $jobTitleService;
    private $companyService;

    public function __construct(UserService $userService, Faker $faker, JobTitleService $jobTitleService, CompanyService $companyService)
    {
        $this->userService = $userService;
        $this->faker = $faker;
        $this->jobTitleService = $jobTitleService;
        $this->companyService = $companyService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = $this->userService->all()->pluck('id')->toArray();
        $positions = $this->jobTitleService->all()->pluck('id')->toArray();

        foreach ($users as $userId) {

            $profile = new Profile();

            $profile->user_id = $userId;
            $profile->job_title_id = $positions[array_rand($positions)];

//            $profile->save();

            $company = $this->companyService->find($profile->user->company_id);
//            $picture = $this->faker->image();
//            $name = $profile->id . '.' . $picture->getClientOriginalExtension();
//            $name = $profile->user->id . '.jpg';
//            $path = public_path('profile-pictures/' . $company->name);
//            Storage::disk('public')->putFileAs('profile-pictures/' . $company->name, $picture, $name);

//            $profile->picture = asset('storage/profile-pictures/' . $company->name . '/' . $name);
            $profile->picture = $this->faker->imageUrl();

            $profile->save();
        }
    }
}
