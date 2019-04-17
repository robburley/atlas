<?php

namespace App\Mail;

use App\Models\MobileOpportunity\MobileOpportunity;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JucGenerated extends Mailable
{
    public $opportunity;
    public $sender;
    public $filePath;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param MobileOpportunity $opportunity
     * @param $filePath
     */
    public function __construct(MobileOpportunity $opportunity, $filePath)
    {
        $this->opportunity = $opportunity->load([
            'customer',
            'juc'
        ]);

        $this->sender = auth()->user();

        $this->filePath = $filePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(auth()->user()->email)
                    ->subject('JUC')
                    ->view('mobile.opportunities.emails.juc')
                    ->attach($this->filePath, [
                        'as'   => str_slug($this->opportunity->customer->company_name) . '_juc.xlsm',
                    ]);
    }
}
