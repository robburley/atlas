<?php

namespace App\Console\Commands;


use App\Mail\MobileTenderInvitationRequest;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\Tenders\Supplier;
use App\Models\Tenders\Tender;
use App\Models\Tenders\TenderType;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Mail;

class CreateMobileTenders extends Command
{
    protected $expiryDate;
    protected $tenderType;
    protected $suppliers;
    protected $opportunities;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atlas:create-mobile-tenders';

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

        $this->expiryDate = Carbon::parse('this Monday 5pm');

        if (
            Schema::hasTable('tender_types') &&
            Schema::hasTable('suppliers')
        ) {
            $this->tenderType = TenderType::where('name', 'mobile')->first();

            $this->suppliers = Supplier::whereHas('type', function ($query) {
                return $query->where('name', 'mobile');
            })->get();

            $this->opportunities = MobileOpportunity::with(['allocations.handset'])
                                                    ->whereHas('status', function ($query) {
                                                        return $query->where('order', '>=', 13);
                                                    })
                                                    ->whereHas('allocations', function ($query) {
                                                        return $query->whereNull('tendered_at')
                                                                     ->whereNotNull('handset_id');
                                                    });
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->opportunities->count() == 0) {
            return false;
        }

        $tender = Tender::create([
            'expires_at'     => $this->expiryDate,
            'tender_type_id' => $this->tenderType->id
        ]);

        $this->opportunities->each(function ($opportunity) use ($tender) {
            $opportunity->allocations->each(function ($allocation) use ($tender) {
                if (!$allocation->tendered_at && $allocation->handset_id && !str_contains($allocation->handset_name, 'Additional Sim Card')) {
                    $tender->mobileTenders()->create([
                        'allocation_id' => $allocation->id
                    ]);

                    $allocation->update([
                        'tendered_at' => Carbon::now()
                    ]);
                }
            });
        });

        $this->suppliers->each(function ($supplier) use ($tender) {
            $date = Carbon::now();

            $invitation = $tender->invitation()->create([
                'supplier_id' => $supplier->id,
                'hash'        => str_random(rand(4, 8)) .
                    $date->format('d') .
                    str_random(rand(4, 8)) .
                    $date->format('m') .
                    str_random(rand(4, 8)) .
                    $date->format('y') .
                    str_random(rand(4, 8)),
            ]);

            $supplier->contacts->each(function ($contact) use ($invitation, $supplier) {
                Mail::to($contact->email)
                    ->send(new MobileTenderInvitationRequest($invitation, $supplier));
            });
        });

    }
}
