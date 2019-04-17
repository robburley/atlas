<?php

namespace App\Helpers;


class PermissionHelper
{
    public static function hasPermission($permission)
    {
        return auth()->user()->hasPermission($permission);
    }

    public static function hasAnyPermission(array $permissions)
    {
        return auth()->user()->hasAnyPermission($permissions);
    }

    public static function mobileShowPermissions($opportunity)
    {
        return auth()->user()->hasPermission('create_mobile')
            && $opportunity->status->blown != 1
            && auth()->user()->hasPermission($opportunity->status->permission)
            && (
                ($opportunity->activeAssigned->first() && $opportunity->activeAssigned->first()->id == auth()->user()->id)
                || auth()->user()->hasPermission('show_all_leads_mobile') && !$opportunity->appointment
                || auth()->user()->hasPermission('show_all_appointment_leads_mobile') && $opportunity->appointment
                || ($opportunity->status->id == 1 && $opportunity->creator->id == auth()->user()->id)
                || (auth()->user()->hasPermission('show_all_branch_opportunities_mobile') && $opportunity->creator->office_id == auth()->user()->office_id)
            );
    }

    public static function energyShowPermissions($opportunity)
    {

        /*
         *  has permission to create mobile
         *  status isnt blown
         *
         */
        return auth()->user()->hasPermission('create_energy')
            && $opportunity->status->blown != 1
            && auth()->user()->hasPermission($opportunity->status->permission)
            && (
                ($opportunity->activeAssigned->first() && $opportunity->activeAssigned->first()->id == auth()->user()->id)
                || auth()->user()->hasPermission('show_all_leads_energy')
                || ($opportunity->status->id <= 2 && $opportunity->creator->id == auth()->user()->id)
            );
    }

    public static function fixedLineShowPermissions($opportunity)
    {
        return auth()->user()->hasPermission('create_fixed_line')
            && $opportunity->status->blown != 1
            && auth()->user()->hasPermission($opportunity->status->permission)
            && (
                ($opportunity->activeAssigned->first() && $opportunity->activeAssigned->first()->id == auth()->user()->id)
                || auth()->user()->hasPermission('show_all_leads_fixed_line') && !$opportunity->appointment
                || auth()->user()->hasPermission('show_all_appointment_leads_fixed_line') && $opportunity->appointment
                || ($opportunity->status->id == 1 && $opportunity->creator->id == auth()->user()->id)
            );
    }
}