<?php


namespace App\Models\MobileOpportunity\Traits;


use App\Helpers\MobileOpportunityStatusHelper;
use App\Models\User\UserNotification;
use Carbon\Carbon;

trait MobileOpportunityStatusConditions
{
    public function getStatusId($slug)
    {
        return (new MobileOpportunityStatusHelper)->get($slug);
    }

    public function passesAwaitingBills()
    {
        return $this->mobileBills->count() > 0 || $this->no_bill == 1
            ? ['mobile_opportunity_status_id' => $this->getStatusId('awaiting-validation')]
            : null;
    }

    public function passesAwaitingValidation()
    {
        if ($this->valid == 1) {
            if (count($this->activeAssigned) == 0) {

                return ['mobile_opportunity_status_id' => $this->getStatusId('awaiting-assignment')];
            }

            return $this->passesAwaitingAssignment();
        }

        return ['mobile_opportunity_status_id' => $this->getStatusId('awaiting-bill')];
    }

    public function passesAwaitingAssignment()
    {
        if (count($this->activeAssigned) > 0) {

            if ($this->lastCallback()->count() > 0 && $this->lastCallback()->first()->time >= Carbon::now()->startOfDay()->addMonth()
            ) {

                return ['mobile_opportunity_status_id' => $this->getStatusId('awaiting-callback')];

            }

            return ['mobile_opportunity_status_id' => $this->getStatusId('awaiting-closer-contact')];
        }

        return null;
    }

    public function passesAwaitingCloserContact()
    {
        return $this->qualified == 1
            ? ['mobile_opportunity_status_id' => $this->getStatusId('awaiting-commercials')]
            : null;
    }

    public function passedAwaitingCallback()
    {
        return $this->qualified == 1
            ? ['mobile_opportunity_status_id' => $this->getStatusId('awaiting-commercials')]
            : null;
    }

    public function passesAwaitingCommercials()
    {
        return ($this->dealCalculator->count() > 0 && $this->gp > 0)
            ? ['mobile_opportunity_status_id' => $this->getStatusId('awaiting-proposal')]
            : null;
    }

    public function passesAwaitingProposal()
    {
        return null;
    }

    public function passesAwaitingAcceptance()
    {
        if ($this->accepted == 1) {
            return ['mobile_opportunity_status_id' => $this->getStatusId('awaiting-customer-information')];
        }

        if (!is_null($this->accepted) && $this->accepted == 0) {
            $this->deleteFilesExceptBill();

            return [
                'mobile_opportunity_status_id' => $this->getStatusId('awaiting-commercials'),
                'accepted' => 3,
            ];
        }
    }

    public function passesAwaitingCustomerInformation()
    {
        return $this->letterhead->count() > 0 && !is_null($this->salesInformation)
            ? ['mobile_opportunity_status_id' => $this->getStatusId('awaiting-purchase-order')]
            : null;
    }

    public function passesAwaitingPurchaseOrder()
    {
        return $this->purchaseOrder->count() > 0
            ? ['mobile_opportunity_status_id' => $this->getStatusId('awaiting-credit-check')]
            : null;
    }

    public function passesAwaitingCreditCheck()
    {
        if ($this->credit_check == 1) {

            $assigned = $this->activeAssigned->first()
                ? $this->activeAssigned->first()
                : $this->created_by;

            $notification = UserNotification::where('subject',
                "Mobile Opportunity $this->id  successfully passed credit check.")->count();

            $notification == 0 && $this->notifications()->create([
                'subject' => "Mobile Opportunity $this->id  successfully passed credit check.",
                'sender_id' => auth()->user()->id,
                'user_id' => $assigned->id,
            ]);

            return ['mobile_opportunity_status_id' => $this->getStatusId('awaiting-fulfilment')];
        }
        return null;
    }
}