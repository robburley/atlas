<?php

namespace App\Mail;


use App\Models\Customer\Contact;
use App\Models\MobileOpportunity\MobileOpportunity;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProposalGenerated extends Mailable
{
    public $opportunity;
    public $filePath;
    public $user;
    public $contact;
    public $message;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param MobileOpportunity $opportunity
     * @param $filePath
     * @param Contact $contact
     * @param $message
     */
    public function __construct(MobileOpportunity $opportunity, $filePath, Contact $contact, $message)
    {
        $this->opportunity = $opportunity->load([
            'customer'
        ]);

        $this->filePath = $filePath;

        $this->contact = $contact;

        $this->user = auth()->user();

        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(auth()->user()->email)
                    ->subject('Your Win Win Proposal')
                    ->markdown('mobile.opportunities.emails.proposal')
                    ->attach($this->filePath, [
                        'as'   => str_slug($this->opportunity->customer->company_name) . '_proposal.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
