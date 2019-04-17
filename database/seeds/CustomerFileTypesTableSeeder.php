<?php

use App\Models\Customer\CustomerFileType;
use Illuminate\Database\Seeder;

class CustomerFileTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomerFileType::create(['name' => 'Mobile Bill', 'slug' => 'mobile_bills', 'type' => 'mobile', 'manual' => 1]);
        CustomerFileType::create(['name' => 'Deal Calculator', 'slug' => 'deal_calculator', 'type' => 'mobile', 'manual' => 0]);
        CustomerFileType::create(['name' => 'Proposal', 'slug' => 'proposal', 'type' => 'mobile', 'manual' => 0]);
        CustomerFileType::create(['name' => 'Letterhead', 'slug' => 'letterhead', 'type' => 'mobile', 'manual' => 0]);
        CustomerFileType::create(['name' => 'Purchase Order', 'slug' => 'purchase_order', 'type' => 'mobile', 'manual' => 0]);
        CustomerFileType::create(['name' => 'Sales Sheet', 'slug' => 'sales_sheet', 'type' => 'mobile', 'manual' => 1]);
        CustomerFileType::create(['name' => 'Energy Bill', 'slug' => 'energy_bills', 'type' => 'energy', 'manual' => 1]);
        CustomerFileType::create(['name' => 'Letter Of Authority', 'slug' => 'letter_of_authority', 'type' => 'energy', 'manual' => 1]);
        CustomerFileType::create(['name' => 'Current Supplier Response', 'slug' => 'current_supplier_response', 'type' => 'energy', 'manual' => 0]);
        CustomerFileType::create(['name' => 'Energy Tender', 'slug' => 'energy_tender', 'type' => 'energy', 'manual' => 0]);
        CustomerFileType::create(['name' => 'Energy Tender Response', 'slug' => 'energy_tender_response', 'type' => 'energy', 'manual' => 1]);
        CustomerFileType::create(['name' => 'Energy Quote', 'slug' => 'energy_quote', 'type' => 'energy', 'manual' => 0]);
    }
}
