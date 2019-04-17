<?php

namespace App\Console\Commands;


use App\Helpers\Tender\Mobile\ProcessMobileTender;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\Tenders\Supplier;
use App\Models\Tenders\Tender;
use App\Models\Tenders\TenderType;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class ProcessMobileTenders extends Command
{
    protected $tenders;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atlas:process-mobile-tenders';

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

        if (Schema::hasTable('tenders')) {
            $this->tenders = Tender::where('expires_at', '<=', Carbon::now())
                                   ->whereNull('completed_at')
                                   ->get();
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->tenders->each(function ($tender) {
            if ($tender->type->name == 'mobile') {
                (new ProcessMobileTender($tender))->handle();
            }
        });
    }
}
