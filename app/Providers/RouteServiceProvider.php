<?php

namespace App\Providers;


use App\Models\Admin\CashFlowItem;
use App\Models\Customer\CustomerFile;
use App\Models\Customer\CustomerSite;
use App\Models\Customer\ScheduledCallback;
use App\Models\EnergyOpportunity\EnergyMeter;
use App\Models\EnergyOpportunity\EnergyOpportunity;
use App\Models\EnergyOpportunity\EnergyOpportunityStatus;
use App\Models\FixedLineOpportunity\FixedLineOpportunity;
use App\Models\FixedLineOpportunity\FixedLineOpportunityStatus;
use App\Models\JourneyTeamSurvey\JourneyTeamSurvey;
use App\Models\MobileOpportunity\DealCalculator\DealCalculator;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\MobileOpportunity\MobileOpportunityStatus;
use App\Models\Recruitment\ApplicationFile;
use App\Models\Tenders\Tender;
use App\Models\Tenders\TenderInvitation;
use App\Models\User\HrProfile;
use App\Models\User\HrProfileFile;
use App\Models\User\PermissionTemplate;
use App\Models\User\UserNotification;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();

        Route::model('customer_file', CustomerFile::class);
        Route::model('customer_site', CustomerSite::class);
        Route::model('energy_meter', EnergyMeter::class);
        Route::model('mobile_opportunity_status', MobileOpportunityStatus::class);
        Route::model('energy_opportunity_status', EnergyOpportunityStatus::class);
        Route::model('fixed_line_opportunity_status', FixedLineOpportunityStatus::class);
        Route::model('user_notification', UserNotification::class);
        Route::model('callback', ScheduledCallback::class);
        Route::model('mobileOpportunity', MobileOpportunity::class);
        Route::model('energyOpportunity', EnergyOpportunity::class);
        Route::model('fixedLineOpportunity', FixedLineOpportunity::class);
        Route::model('permission_template', PermissionTemplate::class);
        Route::model('application_file', ApplicationFile::class);
        Route::model('deal_calculator', DealCalculator::class);
        Route::model('journey_team_survey', JourneyTeamSurvey::class);
        Route::model('hr_profile', HrProfile::class);
        Route::model('hr_profile_file', HrProfileFile::class);
        Route::model('cash_flow_item', CashFlowItem::class);
        Route::model('tender_invitation', TenderInvitation::class);
        Route::model('tender', Tender::class);
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace'  => $this->namespace,
        ], function ($router) {
            require base_path('routes/web.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace'  => $this->namespace,
            'prefix'     => 'api',
        ], function ($router) {
            require base_path('routes/api.php');
        });
    }
}
