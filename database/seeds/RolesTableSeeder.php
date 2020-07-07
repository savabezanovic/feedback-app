<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'superadmin', 'admin'
        ];

        foreach ($roles as $role) {

            $role = Role::create(['name' => $role]);
        }
    }
}
