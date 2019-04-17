<?php

namespace App\Providers;


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view-opportunity', function ($user, $opportunity) {
            return ($user->isAdmin()) ||
                ($user->id == $opportunity->created_by) ||
                ($user->hasPermission('show_all_leads_mobile') && !$opportunity->appointment) ||
                ($user->hasPermission('show_all_appointment_leads_mobile') && $opportunity->appointment) ||
                ($opportunity->activeAssigned()->pluck('users.id')->contains($user->id)) ||
                ($opportunity->creator->teams()->with('moderators')->get()->pluck('moderators')->flatten()->pluck('id')->contains($user->id)) ||
                ($user->hasPermission('show_all_branch_opportunities_mobile') && $opportunity->creator->office_id == $user->office_id);
        });

        Gate::define('view-cashflow', function ($user) {
            return collect([1, 2, 57, 53])->contains($user->id);
        });

        Gate::define('view-profitability', function ($user) {
            return collect([1, 2, 57, 53, 370, 35])->contains($user->id);
        });
    }
}
