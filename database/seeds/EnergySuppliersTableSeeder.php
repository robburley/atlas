<?php

use App\Models\EnergyOpportunity\EnergySupplier;
use Illuminate\Database\Seeder;

class EnergySuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EnergySupplier::create(['name' => 'Axis']);
        EnergySupplier::create(['name' => 'BGB Upfront']);
        EnergySupplier::create(['name' => 'British Gas']);
        EnergySupplier::create(['name' => 'CNG']);
        EnergySupplier::create(['name' => 'Corona Energy']);
        EnergySupplier::create(['name' => 'Crown Gas & Power']);
        EnergySupplier::create(['name' => 'Duel Energy']);
        EnergySupplier::create(['name' => 'E.ON']);
        EnergySupplier::create(['name' => 'EDF Energy']);
        EnergySupplier::create(['name' => 'Extra Energy']);
        EnergySupplier::create(['name' => 'Gazprom']);
        EnergySupplier::create(['name' => 'Haven']);
        EnergySupplier::create(['name' => 'npower']);
        EnergySupplier::create(['name' => 'Opus Energy']);
        EnergySupplier::create(['name' => 'Other']);
        EnergySupplier::create(['name' => 'Ovo']);
        EnergySupplier::create(['name' => 'Scottish Power']);
        EnergySupplier::create(['name' => 'SSE']);
        EnergySupplier::create(['name' => 'Total Gas & Power']);
        EnergySupplier::create(['name' => 'Yorkshire Gas & Power']);
    }
}
