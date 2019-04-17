<?php

use App\Models\MobileOpportunity\MobileOpportunityStatus;
use Illuminate\Database\Seeder;

class MobileOpportunityStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MobileOpportunityStatus::create([
            'name' => 'Awaiting Bill',
            'colour' => 'blue',
            'slug' => 'awaiting-bill',
            'permission' => 'awaiting_bill_mobile',
        ]);
        MobileOpportunityStatus::create([
            'name' => 'Awaiting Validation',
            'colour' => 'warning',
            'slug' => 'awaiting-validation',
            'permission' => 'awaiting_validation_mobile',
        ]);
        MobileOpportunityStatus::create([
            'name' => 'Awaiting Assignment',
            'colour' => 'warning',
            'slug' => 'awaiting-assignment',
            'permission' => 'awaiting_assignment_mobile',
        ]);
        MobileOpportunityStatus::create([
            'name' => 'Awaiting Closer Contact',
            'colour' => 'purple',
            'slug' => 'awaiting-closer-contact',
            'permission' => 'awaiting_closer_contact_mobile',
        ]);
        MobileOpportunityStatus::create([
            'name' => 'Awaiting Callback',
            'colour' => 'purple',
            'slug' => 'awaiting-callback',
            'permission' => 'awaiting_callback_mobile',
        ]);
        MobileOpportunityStatus::create([
            'name' => 'Awaiting Commercials',
            'colour' => 'purple',
            'slug' => 'awaiting-commercials',
            'permission' => 'awaiting_commercials_mobile',
        ]);
        MobileOpportunityStatus::create([
            'name' => 'Awaiting Proposal',
            'colour' => 'warning',
            'slug' => 'awaiting-proposal',
            'permission' => 'awaiting_proposal_mobile',
        ]);
        MobileOpportunityStatus::create([
            'name' => 'Awaiting Acceptance',
            'colour' => 'blue',
            'slug' => 'awaiting-acceptance',
            'permission' => 'awaiting_acceptance_mobile',
        ]);
        MobileOpportunityStatus::create([
            'name' => 'Awaiting Information',
            'colour' => 'blue',
            'slug' => 'awaiting-customer-information',
            'permission' => 'awaiting_letterhead_mobile',
        ]);
        MobileOpportunityStatus::create([
            'name' => 'Awaiting Purchase Order',
            'colour' => 'blue',
            'slug' => 'awaiting-purchase-order',
            'permission' => 'awaiting_purchase_order_mobile',
        ]);
        MobileOpportunityStatus::create([
            'name' => 'Awaiting Credit Check',
            'colour' => 'secondary',
            'slug' => 'awaiting-credit-check',
            'permission' => 'awaiting_credit_check_mobile',
        ]);
        MobileOpportunityStatus::create([
            'name' => 'Awaiting Fulfilment',
            'colour' => 'secondary',
            'slug' => 'awaiting-fulfilment',
            'permission' => 'awaiting_fulfilment_mobile',
        ]);
        MobileOpportunityStatus::create([
            'name' => 'Failed Credit Check',
            'colour' => 'danger',
            'slug' => 'failed-credit-check',
            'blown' => 1,
            'unrecoverable' => 1
        ]);
        MobileOpportunityStatus::create([
            'name' => 'Not Qualified',
            'colour' => 'danger',
            'slug' => 'not_qualified',
            'blown' => 1
        ]);
        MobileOpportunityStatus::create([
            'name' => "No Contact",
            'colour' => 'danger',
            'slug' => "no_contact",
            'blown' => 1
        ]);
        MobileOpportunityStatus::create([
            'name' => "Do Not Call",
            'colour' => 'danger',
            'slug' => "do_not_call",
            'blown' => 1
        ]);
        MobileOpportunityStatus::create([
            'name' => "Won't Deal",
            'colour' => 'danger',
            'slug' => "wont_deal",
            'blown' => 1
        ]);
        MobileOpportunityStatus::create([
            'name' => "Not Within Window",
            'colour' => 'danger',
            'slug' => "not_within_window",
            'blown' => 1
        ]);
        MobileOpportunityStatus::create([
            'name' => "Won't Change Network",
            'colour' => 'danger',
            'slug' => "wont_change_network",
            'blown' => 1
        ]);
        MobileOpportunityStatus::create([
            'name' => "No Buying Signals",
            'colour' => 'danger',
            'slug' => "no_buying_signals",
            'blown' => 1
        ]);
        MobileOpportunityStatus::create([
            'name' => "Doesn't Stack",
            'colour' => 'danger',
            'slug' => "doesnt_stack",
            'blown' => 1
        ]);
    }
}








