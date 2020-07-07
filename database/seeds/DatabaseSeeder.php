<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             RolesTableSeeder::class,
             FeedbackDurationSeeder::class,
             CompaniesTableSeeder::class,
             JobTitlesTableSeeder::class,
             UsersTableSeeder::class,
             ProfilesTableSeeder::class,
             SkillsTableSeeder::class,
             SuperAdminSeeder::class,
         ]);
    }
}
