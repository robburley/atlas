<?php

use App\Models\User\PermissionType;
use Illuminate\Database\Seeder;

class PermissionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PermissionType::create([
            'name' => 'Customer',
            'slug' => 'customer',
        ]);

        PermissionType::create([
            'name' => 'Mobile',
            'slug' => 'mobile',
        ]);

        PermissionType::create([
            'name' => 'Mobile Statuses',
            'slug' => 'mobile',
        ]);

        PermissionType::create([
            'name' => 'Mobile Leads',
            'slug' => 'mobile',
        ]);

        PermissionType::create([
            'name' => 'Energy',
            'slug' => 'energy',
        ]);

        PermissionType::create([
            'name' => 'Energy Statuses',
            'slug' => 'energy',
        ]);

        PermissionType::create([
            'name' => 'Energy Leads',
            'slug' => 'energy',
        ]);
    }
}
