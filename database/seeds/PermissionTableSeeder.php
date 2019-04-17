<?php

use App\Models\User\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert([
            [
                'name' => 'Create',
                'slug' => 'create_customer',
                'permission_type_id' => 1,
            ],
            [
                'name' => 'Create',
                'slug' => 'create_mobile',
                'permission_type_id' => 2,
            ],
            [
                'name' => 'Edit',
                'slug' => 'edit_mobile',
                'permission_type_id' => 2,
            ],
            [
                'name' => 'Read',
                'slug' => 'read_mobile',
                'permission_type_id' => 2,
            ],
            [
                'name' => 'Upload Files',
                'slug' => 'upload_files_mobile',
                'permission_type_id' => 2,
            ],
            [
                'name' => 'Delete Files',
                'slug' => 'delete_files_mobile',
                'permission_type_id' => 2,
            ],
            [
                'name' => 'Can be assigned opportunities',
                'slug' => 'assignable_mobile',
                'permission_type_id' => 2,
            ],
            [
                'name' => 'Can recover opportunities',
                'slug' => 'recoverable_mobile',
                'permission_type_id' => 2,
            ],
            [
                'name' => 'Awaiting Bill',
                'slug' => 'awaiting_bill_mobile',
                'permission_type_id' => 3,
            ],
            [
                'name' => 'Awaiting Validation',
                'slug' => 'awaiting_validation_mobile',
                'permission_type_id' => 3,
            ],
            [
                'name' => 'Awaiting Assignment',
                'slug' => 'awaiting_assignment_mobile',
                'permission_type_id' => 3,
            ],
            [
                'name' => 'Awaiting Closer Contact',
                'slug' => 'awaiting_closer_contact_mobile',
                'permission_type_id' => 3,
            ],
            [
                'name' => 'Awaiting Callback',
                'slug' => 'awaiting_callback_mobile',
                'permission_type_id' => 3,
            ],
            [
                'name' => 'Awaiting Commercials',
                'slug' => 'awaiting_commercials_mobile',
                'permission_type_id' => 3,
            ],
            [
                'name' => 'Awaiting Proposal',
                'slug' => 'awaiting_proposal_mobile',
                'permission_type_id' => 3,
            ],
            [
                'name' => 'Awaiting Acceptance',
                'slug' => 'awaiting_acceptance_mobile',
                'permission_type_id' => 3,
            ],
            [
                'name' => 'Awaiting Customer Information',
                'slug' => 'awaiting_letterhead_mobile',
                'permission_type_id' => 3,
            ],
            [
                'name' => 'Awaiting Purchase order',
                'slug' => 'awaiting_purchase_order_mobile',
                'permission_type_id' => 3,
            ],
            [
                'name' => 'Awaiting Credit check',
                'slug' => 'awaiting_credit_check_mobile',
                'permission_type_id' => 3,
            ],
            [
                'name' => 'Passed Credit Check',
                'slug' => 'passed_credit_check_mobile',
                'permission_type_id' => 3,
            ],
            [
                'name' => 'Show All Leads',
                'slug' => 'show_all_leads_mobile',
                'permission_type_id' => 4,
            ],


            ///////////////////////////

            [
                'name' => 'Create',
                'slug' => 'create_energy',
                'permission_type_id' => 5,
            ],
            [
                'name' => 'Edit',
                'slug' => 'edit_energy',
                'permission_type_id' => 5,
            ],
            [
                'name' => 'Read',
                'slug' => 'read_energy',
                'permission_type_id' => 5,
            ],
            [
                'name' => 'Upload Files',
                'slug' => 'upload_files_energy',
                'permission_type_id' => 5,
            ],
            [
                'name' => 'Delete Files',
                'slug' => 'delete_files_energy',
                'permission_type_id' => 5,
            ],
            [
                'name' => 'Can be assigned opportunities',
                'slug' => 'assignable_energy',
                'permission_type_id' => 5,
            ],
            [
                'name' => 'Can recover opportunities',
                'slug' => 'recoverable_energy',
                'permission_type_id' => 5,
            ],
            [
                'name' => 'Awaiting Bill',
                'slug' => 'awaiting_bill_energy',
                'permission_type_id' => 6,
            ],
            [
                'name' => 'Awaiting Letter of Authority',
                'slug' => 'awaiting_letter_of_authority_energy',
                'permission_type_id' => 6,
            ],
            [
                'name' => 'Awaiting Validation',
                'slug' => 'awaiting_validation_energy',
                'permission_type_id' => 6,
            ],
            [
                'name' => 'Awaiting Assignment',
                'slug' => 'awaiting_assignment_energy',
                'permission_type_id' => 6,
            ],
            [
                'name' => 'Awaiting Closer Contact',
                'slug' => 'awaiting_closer_contact_energy',
                'permission_type_id' => 6,
            ],
            [
                'name' => 'Awaiting Callback',
                'slug' => 'awaiting_callback_energy',
                'permission_type_id' => 6,
            ],
            [
                'name' => 'Awaiting Current Supplier Response',
                'slug' => 'awaiting_current_supplier_response_energy',
                'permission_type_id' => 6,
            ],
            [
                'name' => 'Awaiting Tender Request',
                'slug' => 'awaiting_tender_request_energy',
                'permission_type_id' => 6,
            ],
            [
                'name' => 'Awaiting Tender Responses',
                'slug' => 'awaiting_tender_responses_energy',
                'permission_type_id' => 6,
            ],
            [
                'name' => 'Awaiting Quote',
                'slug' => 'awaiting_quote_energy',
                'permission_type_id' => 6,
            ],
            [
                'name' => 'Awaiting Acceptance',
                'slug' => 'awaiting_acceptance_energy',
                'permission_type_id' => 6,
            ],
            [
                'name' => 'Accepted',
                'slug' => 'accepted_energy',
                'permission_type_id' => 6,
            ],

            [
                'name' => 'Show All Leads',
                'slug' => 'show_all_leads_energy',
                'permission_type_id' => 7,
            ],

            [
                'name' => 'Vet leads',
                'slug' => 'vettable_mobile',
                'permission_type_id' => 2,
            ],


        ]);
    }
}
