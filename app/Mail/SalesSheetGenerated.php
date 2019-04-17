<?php

namespace App\Mail;

use App\Models\MobileOpportunity\MobileOpportunity;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SalesSheetGenerated extends Mailable
{
    public $opportunity;
    public $filePath;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param MobileOpportunity $opportunity
     */
    public function __construct(MobileOpportunity $opportunity, $filePath)
    {
        $this->opportunity = $opportunity->load([
            'customer'
        ]);

        $this->filePath = $filePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Sales Sheet Generated')
                    ->view('mobile.opportunities.emails.sales-sheet')
                    ->attach($this->filePath, [
                        'as' => $this->opportunity->customer->company_name .'_sales-sheet.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
