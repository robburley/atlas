<?php

namespace App\Helpers;


use App\Models\FixedLineOpportunity\FixedLineOpportunity;

class FixedLineOpportunityStatusUpdate
{
    public $opportunity;
    public $data = null;

    public function __construct(FixedLineOpportunity $opportunity)
    {
        $this->opportunity = $opportunity;
    }

    public function getStatus()
    {
        if (!$this->opportunity->status || $this->opportunity->status->blown) {
            return $this->data;
        }

        switch ($this->opportunity) {
            case $this->opportunity->status->order <= $this->getStatusOrder('awaiting-bill'):

                $this->data = $this->opportunity->passesAwaitingBills();

                break;
            case $this->opportunity->status->order <= $this->getStatusOrder('awaiting-validation') :

                $this->data = $this->opportunity->passesAwaitingValidation();

                break;
            case $this->opportunity->status->order <= $this->getStatusOrder('awaiting-assignment'):

                $this->data = $this->opportunity->passesAwaitingAssignment();

                break;
            case $this->opportunity->status->order <= $this->getStatusOrder('awaiting-closer-contact'):

                $this->data = $this->opportunity->passesAwaitingCloserContact();

                break;
            case $this->opportunity->status->order <= $this->getStatusOrder('awaiting-callback'):

                $this->data = $this->opportunity->passedAwaitingCallback();

                break;
            case $this->opportunity->status->order <= $this->getStatusOrder('awaiting-acceptance'):

                $this->data = $this->opportunity->passedAwaitingAcceptance();

                break;
            case $this->opportunity->status->order <= $this->getStatusOrder('awaiting-provisioning'):

                $this->data = $this->opportunity->passedAwaitingProvisioning();

                break;
            default:
                return $this->data;
        }

        return $this->data;
    }

    public function getStatusOrder($slug)
    {
        return (new FixedLineOpportunityStatusHelper)->getOrder($slug);
    }
}