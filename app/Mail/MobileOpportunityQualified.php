<?php

namespace App\Mail;

use App\Models\MobileOpportunity\MobileOpportunity;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MobileOpportunityQualified extends Mailable
{
    public $opportunity;
    public $qualifier;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param MobileOpportunity $opportunity
     */
    public function __construct(MobileOpportunity $opportunity)
    {
        $this->opportunity = $opportunity->load([
            'customer',
            'qualifier'
        ]);

        $this->qualifier = auth()->user();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Opportunity Qualified')
                    ->view('mobile.opportunities.emails.qualfied');
    }
}
