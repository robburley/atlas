<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MobileOpportunity\MobileOpportunity;

class ResetBondPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atlas:reset-bond-payment {opportunity}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $opportunity = MobileOpportunity::where('id', $this->argument('opportunity'))
                                                ->first();

        $opportunity->update([
            'mobile_opportunity_status_id' => 25
        ]);

        $opportunity->adobeSignDocumentBondAgreement()->delete();
    }
} 
