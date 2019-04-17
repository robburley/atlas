<?php

use App\Models\EnergyOpportunity\EnergyOpportunityStatus;
use Illuminate\Database\Seeder;

class EnergyOpportunityStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EnergyOpportunityStatus::create([
            'name' => 'Awaiting Bill',
            'colour' => 'blue',
            'slug' => 'awaiting-bill',
            'permission' => 'awaiting_bill_energy',
        ]);
        EnergyOpportunityStatus::create([
            'name' => 'Awaiting Letter of Authority',
            'colour' => 'warning',
            'slug' => 'awaiting-letter-of-authority',
            'permission' => 'awaiting_letter_of_authority_energy',
        ]);
        EnergyOpportunityStatus::create([
            'name' => 'Awaiting Validation',
            'colour' => 'warning',
            'slug' => 'awaiting-validation',
            'permission' => 'awaiting_validation_energy',
        ]);
        EnergyOpportunityStatus::create([
            'name' => 'Awaiting Assignment',
            'colour' => 'warning',
            'slug' => 'awaiting-assignment',
            'permission' => 'awaiting_assignment_energy',
        ]);
        EnergyOpportunityStatus::create([
            'name' => 'Awaiting Closer Contact',
            'colour' => 'purple',
            'slug' => 'awaiting-closer-contact',
            'permission' => 'awaiting_closer_contact_energy',
        ]);
        EnergyOpportunityStatus::create([
            'name' => 'Awaiting Callback',
            'colour' => 'purple',
            'slug' => 'awaiting-callback',
            'permission' => 'awaiting_callback_energy',
        ]);
        EnergyOpportunityStatus::create([
            'name' => 'Awaiting Current Supplier Response',
            'colour' => 'warning',
            'slug' => 'awaiting-current-supplier-response',
            'permission' => 'awaiting_current_supplier_response_energy',
        ]);
        EnergyOpportunityStatus::create([
            'name' => 'Awaiting Tender Request',
            'colour' => 'warning',
            'slug' => 'awaiting-tender-request',
            'permission' => 'awaiting_tender_request_energy',
        ]);
        EnergyOpportunityStatus::create([
            'name' => 'Awaiting Tender Responses',
            'colour' => 'warning',
            'slug' => 'awaiting-tender-responses',
            'permission' => 'awaiting_tender_responses_energy',
        ]);
        EnergyOpportunityStatus::create([
            'name' => 'Awaiting Quote',
            'colour' => 'blue',
            'slug' => 'awaiting-quote',
            'permission' => 'awaiting_quote_energy',
        ]);
        EnergyOpportunityStatus::create([
            'name' => 'Awaiting Acceptance',
            'colour' => 'secondary',
            'slug' => 'awaiting-acceptance',
            'permission' => 'awaiting_acceptance_energy',
        ]);
        EnergyOpportunityStatus::create([
            'name' => 'Accepted',
            'colour' => 'success',
            'slug' => 'accepted',
            'permission' => 'accepted_energy',
        ]);
        EnergyOpportunityStatus::create([
            'name' => 'Blown',
            'colour' => 'secondary',
            'slug' => 'blown',
            'blown' => 1,
            'permission' => 'blown',
        ]);
    }
}










