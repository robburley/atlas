<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Http\Controllers\MobileOpportunity\SalesSheetController;

class UpdateCashFlow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atlas:update-cash-flow';

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
        $opportunities = MobileOpportunity::doesntHave('cashFlowItem')
                                            ->where('dealt_at', '>', '2017-09-21 16:15:00')
                                            ->whereHas('status', function ($q) {
                                                $q->whereNotNull('order');
                                            })
                                            ->where(function ($qry) {
                                                $qry->whereHas('status', function ($q) {
                                                    $q->where('order', '>=', 11)
                                                      ->whereNotNull('order');
                                                })
                                                ->orHas('corrections');
                                            })
                                            ->get();

        $opportunities->each(function ($opportunity) {
            dump($opportunity->id);
            (new SalesSheetController)->generateSalesSheet($opportunity->customer, $opportunity);
        });

        dd($opportunities->count());
    }
}
