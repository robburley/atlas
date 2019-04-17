<?php

namespace App\Helpers\Tender\Mobile;


use App\Models\Tenders\Tender;
use Carbon\Carbon;

class ProcessMobileTender
{
    protected $tender;

    public function __construct(Tender $tender)
    {
        $this->tender = $tender;
    }

    public function handle()
    {
        $this->tender->mobileTenders->each(function ($mobileTender) {
            $lowestPrice = $this->getLowestPrice($mobileTender->allocation);

            if ($lowestPrice) {
                $mobileTender = $this->tender->mobileTenders()
                                             ->where('allocation_id', $mobileTender->allocation_id)
                                             ->first();

                $mobileTender->update([
                    'selected_supplier_id' => $lowestPrice->tenderInvitation->supplier_id,
                    'selected_unit_price'  => $lowestPrice->unit_price,
                    'selected_lead_time'   => $lowestPrice->lead_time,
                ]);
            }
        });

        $this->completeTender();

        $this->tenderError();

        $this->tender->update(['completed_at' => Carbon::now()]);
    }

    public function getLowestPrice($allocation)
    {
        return $allocation ?
            $allocation->mobileTenderInvitations()
                       ->where('lead_time', '<=', 7)
                       ->where('unit_price', '>', 0)
                       ->with(['tenderInvitation'])
                       ->get()
                       ->sortBy('unit_price')
                       ->first()
            : null;
    }

    public function tenderError()
    {
        $incompleteTenders = $this->tender->mobileTenders()->whereNull('selected_supplier_id')->get();

        $incompleteTenders->each(function ($incomplete) {
            if ($incomplete->allocation) {
                $incomplete->allocation()->update([
                    'tendered_at'     => null,
                    'tender_complete' => null
                ]);
            }
        });
    }

    public function completeTender()
    {
        $completeTenders = $this->tender->mobileTenders()->whereNotNull('selected_supplier_id')->get();

        $completeTenders->each(function ($complete) {
            $complete->allocation()->update([
                'tender_complete' => Carbon::now()
            ]);
        });
    }
}