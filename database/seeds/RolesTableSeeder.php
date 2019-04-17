<?php

use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Admin',
        ]);

        Role::create([
            'name' => 'Support Staff',
        ]);

        Role::create([
            'name' => 'Closer',
        ]);

        Role::create([
            'name' => 'Lead Generator',
        ]);
    }
}