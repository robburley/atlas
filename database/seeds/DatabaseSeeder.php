<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(MobileNetworksTableSeeder::class);
        $this->call(MobileOpportunityStatusesTableSeeder::class);
        $this->call(CustomerFileTypesTableSeeder::class);
        $this->call(PermissionTypesTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(CustomerNoteTypesTableSeeder::class);
        $this->call(PermissionUserTableSeeder::class);
        $this->call(EnergySuppliersTableSeeder::class);
        $this->call(EnergyOpportunityStatusesTableSeeder::class);
    }
}
