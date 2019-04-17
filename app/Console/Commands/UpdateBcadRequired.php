<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MobileOpportunity\MobileOpportunity;

class UpdateBcadRequired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atlas:bcad-required';

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
        $opportunities = MobileOpportunity::has('selectedDealCalculator')
                                            ->where('mobile_opportunity_status_id', '>=', 8)
                                            ->with([
                                                'selectedDealCalculator.overview',
                                                'selectedDealCalculator.primaryConnections.tariff'
                                            ])
                                            ->get();

        $opportunities->each(function ($opportunity) {
            dump($opportunity->id);

            $dealCalculator = $opportunity->selectedDealCalculator->first();

            $opportunity->update([
                'bcad_required' => $dealCalculator->overview->bcad > 0 || $dealCalculator->getBcadDiff() > 0
            ]);
        });
    }
}
