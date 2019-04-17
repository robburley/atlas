<?php

namespace App\Mail;

use App\Models\MobileOpportunity\MobileOpportunity;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

class ConnectionTemplateUploaded extends Mailable
{
    public $opportunity;
    public $filePath;
    public $user;
    public $message;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param MobileOpportunity $opportunity
     */
    public function __construct(MobileOpportunity $opportunity, $filePath, $message)
    {
        $this->opportunity = $opportunity->load([
            'customer',
            'selectedDealCalculator.primaryConnections.tariff.type',
            'selectedDealCalculator.overview'
        ]);

        $this->filePath = $filePath;

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
                    ->subject($this->opportunity->customer->company_name . ' ' . $this->message)
                    ->view('mobile.opportunities.emails.connection-template')
                    ->attach($this->filePath, [
                        'as' => $this->opportunity->customer->company_name . '_connection_template.' . File::extension(storage_path("app/$this->filePath"))
                    ])
                    ->attach(storage_path('app/' . $this->opportunity->purchaseOrder->first()->location), [
                        'as' => $this->opportunity->customer->company_name . '_purchase_order_cif.pdf'
                    ]);
    }
}
