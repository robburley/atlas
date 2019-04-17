<?php

use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'username' => 'dd',
            'password' => 'local',
            'name'     => 'Dave Duckworth',
            'email'    => 'dave@suttoncross.co.uk',
            'role_id'    => Role::where('name', 'Admin')->first()->id,
        ]);

        \DB::table('users')->insert([
            0 => [
                'id' => 2,
                'username' => 'closer',
                'password' => '$2y$10$PbMs3mAEx1w8mi5eLKCdW.RPCZc.hq2ZhU762PjECaR0kRljbSMjK',
                'name' => 'Example Closer',
                'email' => 'closer@example.org',
                'active' => 1,
                'role_id' => Role::where('name', 'Closer')->first()->id,
            ],
            1 => [
                'id' => 3,
                'username' => 'leadgen',
                'password' => '$2y$10$RD.yAE8pRYUgI4NoDOs5rubCnELXVDz3XJ/virb0Tj234aDhrXVrK',
                'name' => 'Example Lead Generator',
                'email' => 'leadgen@example.org',
                'active' => 1,
                'role_id' => Role::where('name', 'Lead Generator')->first()->id,
            ],
            2 => [
                'id' => 4,
                'username' => 'adminstaff',
                'password' => '$2y$10$xgxZDQb7WLcq1lilrcFUb.VKcFJ2FogX5bsUJ7VUfcHG52nU3VoOW',
                'name' => 'Example Admin Staff',
                'email' => 'adminstaff@example.org',
                'active' => 1,
                'role_id' => Role::where('name', 'Support Staff')->first()->id,
            ],
        ]);
        
        
    }
}