<?php

use App\Models\MobileOpportunity\MobileNetwork;
use Illuminate\Database\Seeder;

class MobileNetworksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MobileNetwork::create(['name' => 'None']);
        MobileNetwork::create(['name' => 'Any']);
        MobileNetwork::create(['name' => 'EE']);
        MobileNetwork::create(['name' => 'O2']);
        MobileNetwork::create(['name' => 'Other']);
        MobileNetwork::create(['name' => 'Three']);
        MobileNetwork::create(['name' => 'Vodafone']);
        MobileNetwork::create(['name' => 'Plan.com']);
        MobileNetwork::create(['name' => 'BT']);
        MobileNetwork::create(['name' => 'Virgin']);
        MobileNetwork::create(['name' => 'Tesco']);
        MobileNetwork::create(['name' => 'Giffgaff']);
        MobileNetwork::create(['name' => 'Lyca Mobile']);
        MobileNetwork::create(['name' => 'Orange']);
        MobileNetwork::create(['name' => 'kinex']);
        MobileNetwork::create(['name' => 'Daisy Telecom']);
    }
}
