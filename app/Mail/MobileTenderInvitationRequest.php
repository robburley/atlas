<?php

namespace App\Mail;


use App\Models\Customer\Contact;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\Tenders\Supplier;
use App\Models\Tenders\Tender;
use App\Models\Tenders\TenderInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MobileTenderInvitationRequest extends Mailable
{
    public $invitation;
    public $supplier;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * @param TenderInvitation $invitation
     * @param Supplier $supplier
     */
    public function __construct(TenderInvitation $invitation, Supplier $supplier)
    {
        $this->invitation = $invitation;
        $this->supplier = $supplier;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Win Win Management Hardware Tender')
                    ->markdown('tenders.mobile.email.tender');
    }
}
