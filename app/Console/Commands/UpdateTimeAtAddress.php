<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MobileOpportunity\MobileSalesInformation;

class UpdateTimeAtAddress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atlas:update-time-at-address {opportunity?}';

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
        if ($this->argument('opportunity')) {
            $opportunities = MobileSalesInformation::where('mobile_opportunity_id', $this->argument('opportunity'))
                                                    ->get();
        } else {
            $opportunities = MobileSalesInformation::all();
        }

        $opportunities->each(function ($opportunity) {
            $this->info('---------------');
            $this->info($opportunity->id);

            $timeAtAddress1 = $this->getNumberFromText($opportunity->address_1_time_at_address);
            $timeAtAddress2 = $this->getNumberFromText($opportunity->address_2_time_at_address);

            $this->info($timeAtAddress1);
            $this->info($timeAtAddress2);

            $opportunity->update([
                'address_1_time_at_address' => $timeAtAddress1,
                'address_2_time_at_address' => $timeAtAddress2,
            ]);
        });
    }

    public function getNumberFromText($string)
    {
        preg_match_all('!\d+!', $string, $matches);

        $number = $matches[0][0] ?? 0;

        if (str_contains(strtolower($string), ['months', 'mnths']) && !str_contains(strtolower($string), ['year', 'yr'])) {
            if ($number > 12) {
                return round($number / 12);
            }

            return 0;
        }

        return $number ?? 0;
    }
}
