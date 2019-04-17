<?php

namespace App\Listeners;


use App\Events\CreditCheckPassed;
use App\Models\MobileOpportunity\MobileOpportunityPseudoStatus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateConnectionRequirements
{
    public $statuses;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->statuses = MobileOpportunityPseudoStatus::whereIn('type', [1, 2])->get();
    }

    /**
     * Handle the event.
     *
     * @param  CreditCheckPassed $event
     * @return void
     */
    public function handle(CreditCheckPassed $event)
    {
        $allocations = $event->opportunity->allocations;

        $newConnections = $allocations->where('type', 'New connection');

        $ports = $allocations->where('type', 'Port');

        $upgrades = $allocations->where('type', 'Upgrade');

        $this->generatePortRequirements($ports);

        $this->generateStandardRequirements($upgrades);

        if ($newConnections->count() > 1) {
            $this->generateStandardRequirements($newConnections);
        }

        dd('asd');
    }

    public function generatePortRequirements($allocations)
    {
        $allocations->each(function ($allocation) {
            $this->statuses->each(function ($status) use ($allocation) {

            });
        });
    }

    public function generateStandardRequirements($allocations)
    {
        $allocations->each(function ($allocation) {
            $this->statuses->where('type', 1)->each(function ($status) use ($allocation) {
                $allocation->connectionRequirements()->create([
                    'mobile_opportunity_pseudo_status_id' => $status->id
                ]);
            });
        });
    }
}
