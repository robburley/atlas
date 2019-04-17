<?php

namespace App\Helpers;

use App\Models\EnergyOpportunity\EnergyOpportunity;
use App\Models\EnergyOpportunity\EnergyOpportunityStatus;
use App\Models\Faq\Question;
use App\Models\FixedLineOpportunity\FixedLineOpportunity;
use App\Models\FixedLineOpportunity\FixedLineOpportunityStatus;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\MobileOpportunity\MobileOpportunityStatus;
use Carbon\Carbon;

class NavPopulator
{
    public static function getMobileStatusFigure($status)
    {
        $status = MobileOpportunityStatus::where('slug', $status)->first();

        return $status ? $status->mobileOpportunities->count() : 0;
    }

    public static function getReassignableOrders()
    {
        return MobileOpportunity::has('reassignable')->reassignableFilters()->count();
    }

    public static function getRecoverableOrders()
    {
        return MobileOpportunity::whereHas('status', function ($query) {
            $query->where('blown', 1)
                  ->where('unrecoverable', 0);
        })
                                ->where(function ($query) {
                                    $query->whereNull('review_date')
                                          ->orWhere('review_date', '<=', Carbon::now()->endOfDay());
                                })->count();
    }

    public static function getVettableOrders()
    {
        return MobileOpportunity::whereHas('status', function ($query) {
            $query->where('blown', 1)
                  ->where('unrecoverable', 0);
        })
                                ->where(function ($query) {
                                    $query->whereNull('review_date')
                                          ->orWhere('review_date', '<=', Carbon::now()->endOfDay());
                                })
                                ->whereNull('review_date')
                                ->count();
    }

    public static function getEnergyStatusFigure($status)
    {
        $status = EnergyOpportunityStatus::where('slug', $status)->first();

        return $status ? $status->energyOpportunities->count() : 0;
    }

    public static function getEnergyReassignableOrders()
    {
        return EnergyOpportunity::has('reassignable')->reassignableFilters()->count();
    }

    public static function getEnergyRecoverableOrders()
    {
        return EnergyOpportunity::whereHas('status', function ($query) {
            $query->where('blown', 1)
                  ->where('unrecoverable', 0);
        })->count();
    }

    public static function getQuestionsAsked()
    {
        return Question::count();
    }

    public static function getFixedLineStatusFigure($status)
    {
        $status = FixedLineOpportunityStatus::where('slug', $status)->first();

        return $status ? $status->fixedLineOpportunities->count() : 0;
    }

    public static function getFixedLineRecoverableOrders()
    {
        return FixedLineOpportunity::whereHas('status', function ($query) {
            $query->where('blown', 1)
                  ->where('unrecoverable', 0);
        })
                                   ->count();
    }

    public static function getPacCodeStatusFigure()
    {
        return MobileOpportunity::awaitingPacCode()->count();
    }

    public static function getAwaitingSimsStatusFigure()
    {
        return MobileOpportunity::awaitingSims()->count();
    }

    public static function getAwaitingUnlockStatusFigure()
    {
        return MobileOpportunity::awaitingUnlocks()->count();
    }

    public static function getPendingUnlockStatusFigure()
    {
        return MobileOpportunity::pendingUnlock()->count();
    }

    public static function getAwaitingPortStatusFigure()
    {
        return MobileOpportunity::awaitingPort()->count();
    }

    public static function getAwaitingStockStatusFigure()
    {
        return MobileOpportunity::awaitingStock()->count();
    }

    public static function getAwaitingImeiStatusFigure()
    {
        return MobileOpportunity::awaitingImei()->count();
    }

    public static function getAwaitingBcadStatusFigure()
    {
        return MobileOpportunity::awaitingBcad()->count();
    }

    public static function getPendingBcadStatusFigure()
    {
        return MobileOpportunity::pendingBcad()->count();
    }

    public static function getAwaitingConnectionStatusFigure()
    {
        return MobileOpportunity::awaitingConnection()->count();
    }

    public static function getPendingConnectionStatusFigure()
    {
        return MobileOpportunity::pendingConnection()->count();
    }

    public static function getConnectionDeferredStatusFigure()
    {
        return MobileOpportunity::connectionDeferred()->count();
    }

    public static function getConnectionErrorStatusFigure()
    {
        return MobileOpportunity::connectionError()->count();
    }

    public static function getConnectedStatusFigure()
    {
        return MobileOpportunity::connected()->count();
    }

    public static function getCorrectionStatusFigure()
    {
        return MobileOpportunity::viewPermissions()
                                ->where(function ($q) {
                                    $q->where('mobile_opportunity_status_id', 24)
                                        ->orWhere(function ($qry) {
                                            $qry->where('mobile_opportunity_status_id', '<=', 10)
                                            ->has('unactionedCorrections');
                                        });
                                })
                                ->count();
    }

    public static function getAwaitingBondPaymentFigure()
    {
        return MobileOpportunity::awaitingBondPayment()->count();
    }
}
