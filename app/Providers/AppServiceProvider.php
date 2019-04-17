<?php

namespace App\Providers;


use App\Models\Appointments\Appointment;
use App\Models\Customer\CustomerFile;
use App\Models\Customer\CustomerNote;
use App\Models\Customer\WelcomeCall;
use App\Models\EnergyOpportunity\EnergyOpportunity;
use App\Models\FixedLineOpportunity\FixedLineOpportunity;
use App\Models\JourneyTeamSurvey\JourneyTeamSurvey;
use App\Models\JourneyTeamSurvey\Question;
use App\Models\JourneyTeamSurvey\Section;
use App\Models\MobileOpportunity\DealCalculator\DealCalculator;
use App\Models\MobileOpportunity\DealCalculator\DealCalculatorOverviews;
use App\Models\MobileOpportunity\FulfilmentTimeLineItem;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\MobileOpportunity\MobileSalesInformation;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Add the authenticated user's ID to the customer note on create
        CustomerNote::creating(function ($note) {
            if ($note->user_id > 0) {
                return $note;
            }

            if (auth()->user()) {
                return $note->user_id = auth()->user()->id;
            }
        });

        // Add the authenticated user's ID to the mobile opportunity on create
        MobileOpportunity::creating(function ($opportunity) {
            $opportunity->created_by = $opportunity->created_by > 0 ? $opportunity->created_by : auth()->user()->id;
        });

        //Check for status update
        MobileOpportunity::updated(function ($opportunity) {
            $opportunity->checkForUpdates();

            if ($opportunity->isBlown() && $opportunity->cashFlowItem) {
                $opportunity->cashFlowItem->update(['active' => 0]);
            }
        });

        MobileSalesInformation::saved(function ($info) {
            $info->opportunity->checkForUpdates();
        });

        //Check for any status updates once a file is uploaded
        CustomerFile::created(function ($file) {
            $file->has('related') && $file->related->checkForUpdates();
        });

        // Add the authenticated user's ID to the mobile opportunity on create
        EnergyOpportunity::creating(function ($opportunity) {
            $opportunity->created_by = $opportunity->created_by ?? auth()->user()->id;
        });

        //Check for status update
        EnergyOpportunity::updated(function ($opportunity) {
            $opportunity->checkForUpdates();
        });

        Appointment::creating(function ($appointment) {
            $appointment->user_id = auth()->user()->id;
        });

        WelcomeCall::creating(function ($welcomeCall) {
            $welcomeCall->user_id = auth()->user()->id;
        });

        DealCalculator::creating(function ($calc) {
            if (auth()->user()) {
                $calc->user_id = $calc->user_id ?? auth()->user()->id;
            } else {
                $calc->user_id = $calc->user_id ?? 0;
            }
        });

        DealCalculatorOverviews::created(function ($overview) {
            if (count($overview->dealCalculator->opportunity->dealCalculators) == 1) {
                $overview->dealCalculator->opportunity->update([
                    'gp' => $overview->totalProfit
                ]);
            }
        });

        // Add the authenticated user's ID to the mobile opportunity on create
        FixedLineOpportunity::creating(function ($opportunity) {
            $opportunity->created_by = $opportunity->created_by ?? auth()->user()->id;
        });

        //Check for status update
        FixedLineOpportunity::updated(function ($opportunity) {
            $opportunity->checkForUpdates();
        });

        Relation::morphMap([
            'mobileOpportunity'    => MobileOpportunity::class,
            'energyOpportunity'    => EnergyOpportunity::class,
            'fixedLineOpportunity' => fixedLineOpportunity::class,
        ]);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->alias('bugsnag.logger', \Illuminate\Contracts\Logging\Log::class);
        $this->app->alias('bugsnag.logger', \Psr\Log\LoggerInterface::class);
    }
}
