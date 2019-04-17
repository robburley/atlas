<?php

namespace App\Helpers;


use App\Models\MobileOpportunity\MobileOpportunity;

class MobileOpportunityStatusUpdate
{
    public $opportunity;
    public $data = null;

    public function __construct(MobileOpportunity $opportunity)
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
            case $this->opportunity->status->order <= $this->getStatusOrder('awaiting-commercials'):

                $this->data = $this->opportunity->passesAwaitingCommercials();

                break;
            case $this->opportunity->status->order <= $this->getStatusOrder('awaiting-proposal'):

                $this->data = $this->opportunity->passesAwaitingProposal();

                break;
            case $this->opportunity->status->order <= $this->getStatusOrder('awaiting-acceptance'):

                $this->data = $this->opportunity->passesAwaitingAcceptance();

                break;
            case $this->opportunity->status->order <= $this->getStatusOrder('awaiting-customer-information'):

                $this->data = $this->opportunity->passesAwaitingCustomerInformation();

                break;
            case $this->opportunity->status->order <= $this->getStatusOrder('awaiting-purchase-order'):

                $this->data = $this->opportunity->passesAwaitingPurchaseOrder();

                break;
            case $this->opportunity->status->order <= $this->getStatusOrder('awaiting-credit-check'):

                $this->data = $this->opportunity->passesAwaitingCreditCheck();

                break;
            default:
                return $this->data;
        }

        return $this->data;
    }

    public function getStatusOrder($slug)
    {
        return (new MobileOpportunityStatusHelper)->getOrder($slug);
    }
}