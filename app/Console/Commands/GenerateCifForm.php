<?php

namespace App\Console\Commands;

use App\Models\Customer\CustomerFileType;
use App\Models\MobileOpportunity\MobileOpportunity;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Console\Command;

class GenerateCifForm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atlas:generate-cif-form {opportunity?}';

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
            $opportunities = MobileOpportunity::where('id', $this->argument('opportunity'))
                                              ->get();
        } else {
            $opportunities = MobileOpportunity::has('purchaseOrder')
                                              ->whereHas('selectedDealCalculator', function ($query) {
                                                  return $query->has('overview')
                                                        ->whereHas('connections', function ($qry) {
                                                            return $qry->has('tariff');
                                                        });
                                              })
                                              ->has('salesInformation')
                                              ->with([
                                                  'customer',
                                                  'creator',
                                                  'selectedDealCalculator.creator',
                                                  'selectedDealCalculator.accessories',
                                                  'selectedDealCalculator.contributions',
                                                  'selectedDealCalculator.credits',
                                                  'selectedDealCalculator.handsets',
                                                  'selectedDealCalculator.primaryConnections',
                                                  'selectedDealCalculator.secondaryConnections',
                                                  'selectedDealCalculator.overview',
                                              ])
                                              ->get();
        }

        $opportunities->each(function ($opportunity) {
            $this->info($opportunity->id);

            try {
                $fileType = CustomerFileType::where('slug', 'unsigned_cif_form_mobile')->first();

                $this->saveFile($opportunity, $opportunity->customer, $opportunity->selectedDealCalculator->first(), $fileType, 'cif');

                $fileType = CustomerFileType::where('slug', 'unsigned_cif_form_non_esign_mobile')->first();

                $this->saveFile($opportunity, $opportunity->customer, $opportunity->selectedDealCalculator->first(), $fileType, 'cif-non-esign');
            } catch (\Exception $e) {
                dump($e->getMessage());
            }
        });
    }

    public function saveFile($opportunity, $customer, $dealCalculator, $fileType, $type)
    {
        $file = $customer->files()->create([
            'related_type'          => 'mobileOpportunity',
            'related_id'            => $opportunity->id,
            'customer_file_type_id' => $fileType->id,
        ]);

        $name = "$fileType->slug-$file->id.pdf";

        $path = "$customer->id/$fileType->slug/$name";

        $file->update([
            'location' => $path
        ]);

        SnappyPdf::loadView('mobile.opportunities.pdf.' . $type, [
            'dealCalculator' => $dealCalculator,
            'customer'       => $customer,
            'opportunity'    => $opportunity,
        ])
                    ->setOption('margin-bottom', 0)
                    ->setOption('margin-top', 0)
                    ->setOption('margin-left', 0)
                    ->setOption('margin-right', 0)
                    ->save(storage_path("app/$path"));
    }
}
