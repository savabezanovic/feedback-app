<?php

use App\Services\CompanyService;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * @var CompanyService
     */
    private $companyService;
    /**
     * @var Faker
     */
    private $faker;

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function __construct(CompanyService $companyService, Faker $faker)
    {
        $this->companyService = $companyService;
        $this->faker = $faker;
    }

    public function run()
    {
        // admins

        foreach ($this->companyService->all() as $company) {

            $admin = new User();

            $admin->first_name = $this->faker->firstName;
            $admin->last_name = $this->faker->lastName;
            $admin->email = $company->name . '-admin@feedback-app.com';
            $admin->email_verified_at = now();
            $admin->password = Hash::make('admin123');
            $admin->remember_token = Str::random(10);
            $admin->company_id = $company->id;

            $admin->save();

            $admin->role()->attach(2);
        }

        // superadmin

        $superadmin = new User();

        $superadmin->first_name = 'my name is';
        $superadmin->last_name = 'mister so mighty buahahaha';
        $superadmin->email = 'superadmin@feedback-app.com';
        $superadmin->email_verified_at = now();
        $superadmin->password = Hash::make('superadmin');
        $superadmin->remember_token = Str::random(10);

        $superadmin->save();

        $superadmin->role()->attach(1);
    }
}
