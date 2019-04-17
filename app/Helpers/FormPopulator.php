<?php

namespace App\Helpers;

use App\Models\Customer\CustomerFileType;
use App\Models\Customer\CustomerNoteType;
use App\Models\EnergyOpportunity\EnergyOpportunityStatus;
use App\Models\FixedLineOpportunity\FixedLineOpportunityStatus;
use App\Models\MobileOpportunity\MobileNetwork;
use App\Models\MobileOpportunity\MobileOpportunityStatus;
use App\Models\MobileOpportunity\TariffType;
use App\Models\User\Office;
use App\Models\User\PermissionTemplate;
use App\Models\User\Role;
use App\Models\User\User;
use Carbon\Carbon;

class FormPopulator
{
    public static function title()
    {
        return [
            'Mr'   => 'Mr',
            'Mrs'  => 'Mrs',
            'Miss' => 'Miss',
            'Ms'   => 'Ms',
        ];
    }

    public static function allAssignableUsersMobile()
    {
        return User::active()
                    ->whereHas('permissions', function ($query) {
                        return $query->where('slug', 'apointable_mobile')
                                    ->orWhere('slug', 'assignable_mobile');
                    })
                    ->orderBy('name', 'asc')
                    ->pluck('name', 'id')
                    ->toArray();
    }

    public static function assignableUsers($opportunity = null, $type = 'mobile')
    {
        return User::active()->whereHas('permissions', function ($query) use ($opportunity, $type) {
            if ($opportunity && $opportunity->appointment == 1) {
                $query->where('slug', 'apointable_' . $type);
            } else {
                $query->where('slug', 'assignable_' . $type);
            }
        })->orderBy('name', 'asc')
                   ->pluck('name', 'id')
                   ->toArray();
    }

    public static function assignableUsersEnergy()
    {
        return User::active()->whereHas('permissions', function ($query) {
            $query->where('slug', 'assignable_energy');
        })
                   ->orderBy('name', 'asc')
                   ->pluck('name', 'id')
                   ->toArray();
    }

    public static function allUsers()
    {
        return User::active()
                   ->orderBy('name', 'asc')
                   ->pluck('name', 'id')
                   ->toArray();
    }

    public static function leadGenUsers()
    {
        return User::active()->whereHas('permissions', function ($query) {
            $query->where('slug', 'create_mobile');
        })
                   ->orderBy('name', 'asc')
                   ->pluck('name', 'id')
                   ->toArray();
    }

    public static function assignableUsersNotNull(
        $type = null
    ) {
        return [0 => 'Please Select'] + User::active()->whereHas('permissions', function ($query) {
            $query->where('slug', 'assignable_mobile');
        })->pluck('name', 'id')->toArray();
    }

    public static function yesNo()
    {
        return [
            1 => 'Yes',
            0 => 'No',
        ];
    }

    public static function mobileFileTypes()
    {
        return CustomerFileType::where('type', 'mobile')
                               ->where('manual', 1)
                               ->pluck('name', 'id');
    }

    public static function energyFileTypes()
    {
        return CustomerFileType::where('type', 'energy')
                               ->where('manual', 1)
                               ->pluck('name', 'id');
    }

    public static function fixedLineFileTypes()
    {
        return CustomerFileType::where('type', 'fixed_line')
                               ->where('manual', 1)
                               ->pluck('name', 'id');
    }

    public static function mobileBlownStatuses()
    {
        return MobileOpportunityStatus::where('blown', 1)
                                      ->where('unrecoverable', 0)
                                      ->pluck('name', 'id');
    }

    public static function fixedLineBlownStatuses()
    {
        return FixedLineOpportunityStatus::where('blown', 1)
                                         ->where('unrecoverable', 0)
                                         ->pluck('name', 'id');
    }

    public static function energyBlownStatuses()
    {
        return EnergyOpportunityStatus::where('blown', 1)
                                      ->where('unrecoverable', 0)
                                      ->pluck('name', 'id');
    }

    public static function mobileStatuses()
    {
        return MobileOpportunityStatus::pluck('name', 'id');
    }

    public static function energyStatuses()
    {
        return EnergyOpportunityStatus::pluck('name', 'id');
    }

    public static function directOrDealer()
    {
        return [
            'Direct' => 'Direct',
            'Dealer' => 'Dealer',
        ];
    }

    public static function roamingOrInternational()
    {
        return [
            'Roaming'       => 'Roaming',
            'International' => 'International',
        ];
    }

    public static function roles()
    {
        if (auth()->user()->isAdmin()) {
            return Role::pluck('name', 'id');
        }

        return Role::where('name', '<>', 'Admin')->pluck('name', 'id');
    }

    public static function customerNoteTypes()
    {
        return CustomerNoteType::where('manual', 1)->pluck('name', 'id');
    }

    public static function now()
    {
        return Carbon::now()->format('d/m/Y');
    }

    public static function users()
    {
        return User::where('active', 1)->pluck('name', 'id');
    }

    public static function permissionTemplates()
    {
        return PermissionTemplate::pluck('name', 'id');
    }

    public static function offices()
    {
        return Office::orderBy('name')->pluck('name', 'id');
    }

    public static function officesBySlug()
    {
        return Office::pluck('name', 'slug');
    }

    public static function tariffTypes()
    {
        return TariffType::pluck('name', 'id');
    }

    public static function fixedLineStatuses()
    {
        return FixedLineOpportunityStatus::pluck('name', 'id');
    }

    public static function networks()
    {
        return MobileNetwork::pluck('name', 'id');
    }

    public static function hrFileTypes()
    {
        return [
            'Passport Copy'       => 'Passport Copy',
            'Employment Contract' => 'Employment Contract',
            'NDA'                 => 'NDA',
            'New Start Form'      => 'New Start Form',
            'Misc'                => 'Misc',
        ];
    }

    public static function cashFlowOneOffs()
    {
        return [
            'O2 Rev Share'      => 'O2 Rev Share',
            'Operations Saves'  => 'Operations Saves',
            'Energy'            => 'Energy',
            'Land line'         => 'Land line',
            'Handset Recycling' => 'Handset Recycling',
            'Legal'             => 'Legal',
        ];
    }

    public static function cashFlowStatuses()
    {
        return [
            'All',
            'Declined',
            'Canceled',
            'Lost',
            'Paid',
            'Unpaid'
        ];
    }
}
