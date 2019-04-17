<?php

namespace App\Models\FixedLineOpportunity\Traits;


use App\Helpers\FixedLineOpportunityStatusHelper;
use App\Models\User\UserNotification;
use Carbon\Carbon;

trait FixedLineOpportunityStatusConditions
{
    public function getStatusId($slug)
    {
        return (new FixedLineOpportunityStatusHelper)->get($slug);
    }

    public function passesAwaitingBills()
    {
        return $this->fixedLineBills->count() > 0 || $this->no_bill == 1
            ? ['fixed_line_opportunity_status_id' => $this->getStatusId('awaiting-validation')]
            : null;
    }

    public function passesAwaitingValidation()
    {
        if ($this->valid == 1) {
            if (count($this->activeAssigned) == 0) {

                return ['fixed_line_opportunity_status_id' => $this->getStatusId('awaiting-assignment')];
            }

            return $this->passesAwaitingAssignment();
        }

        return ['fixed_line_opportunity_status_id' => $this->getStatusId('awaiting-bill')];
    }

    public function passesAwaitingAssignment()
    {
        if (count($this->activeAssigned) > 0) {

            if ($this->lastCallback()->count() > 0 && $this->lastCallback()->first()->time >= Carbon::now()->startOfDay()->addMonth()
            ) {

                return ['fixed_line_opportunity_status_id' => $this->getStatusId('awaiting-callback')];

            }

            return ['fixed_line_opportunity_status_id' => $this->getStatusId('awaiting-closer-contact')];
        }

        return null;
    }

    public function passesAwaitingCloserContact()
    {
        return $this->qualified == 1
            ? ['fixed_line_opportunity_status_id' => $this->getStatusId('awaiting-commercials')]
            : null;
    }

    public function passedAwaitingCallback()
    {
        return $this->qualified == 1
            ? ['fixed_line_opportunity_status_id' => $this->getStatusId('awaiting-commercials')]
            : null;
    }

    public function passedAwaitingAcceptance()
    {
        if ($this->accepted == 1) {
            return ['fixed_line_opportunity_status_id' => $this->getStatusId('awaiting-customer-information')];
        }

        if (!is_null($this->accepted) && $this->accepted == 0) {
            $this->deleteFilesExceptBill();

            return [
                'fixed_line_opportunity_status_id' => $this->getStatusId('awaiting-commercials'),
                'accepted'                         => 3,
            ];
        }
    }

    public function passedAwaitingProvisioning()
    {
        if ($this->provisioned == 1) {

            $assigned = $this->activeAssigned->first()
                ? $this->activeAssigned->first()
                : $this->created_by;

            $notification = UserNotification::where('subject',
                "Fixed Line Opportunity $this->id  successfully passed credit check.")->count();

            $notification == 0 && $this->notifications()->create([
                'subject' => "Fixed Line Opportunity $this->id  successfully passed credit check.",
                'sender_id' => auth()->user()->id,
                'user_id' => $assigned->id,
            ]);

            return ['fixed_line_opportunity_status_id' => $this->getStatusId('provisioned')];
        }
        return null;
    }

}