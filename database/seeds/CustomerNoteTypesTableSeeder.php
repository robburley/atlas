<?php

use App\Models\Customer\CustomerFileType;
use App\Models\Customer\CustomerNoteType;
use Illuminate\Database\Seeder;

class CustomerNoteTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomerNoteType::create([
            'name' => 'Outbound Call',
            'past_tense' => 'an outbound call was made',
            'manual' => 1,
            'icon' => 'phone'
        ]);
        CustomerNoteType::create([
            'name' => 'Inbound Call',
            'past_tense' => 'an inbound call was made',
            'manual' => 1,
            'icon' => 'phone'
        ]);
        CustomerNoteType::create([
            'name' => 'Email',
            'past_tense' => 'an email was sent',
            'manual' => 1,
            'icon' => 'envelope'
        ]);
        CustomerNoteType::create([
            'name' => 'Update',
            'past_tense' => 'an opportunity was updated',
            'manual' => 1,
            'icon' => 'refresh'
        ]);
        CustomerNoteType::create([
            'name' => 'Status Change',
            'past_tense' => 'an opportunity status was changed',
            'manual' => 0,
            'icon' => 'info-circle'
        ]);
        CustomerNoteType::create([
            'name' => 'New Opportunity',
            'past_tense' => 'a new opportunity was made',
            'manual' => 0,
            'icon' => 'star'
        ]);
        CustomerNoteType::create([
            'name' => 'Qualification',
            'past_tense' => 'an opportunity was qualified',
            'manual' => 0,
            'icon' => 'thumbs-up'
        ]);
    }
}








