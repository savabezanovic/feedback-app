<?php

use App\Company;
use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            'quantox', 'levi9', 'vega', 'vivify'
        ];

        foreach ($companies as $company) {

            $company = new Company();

            $company->name = $companies[0];

            $company->save();

            array_shift($companies);
        }
    }
}
