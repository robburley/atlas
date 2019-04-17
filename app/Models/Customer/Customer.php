<?php

namespace App\Models\Customer;

use App\Models\EnergyOpportunity\EnergyMeter;
use App\Models\EnergyOpportunity\EnergyOpportunity;
use App\Models\FixedLineOpportunity\FixedLineOpportunity;
use App\Models\JourneyTeamSurvey\JourneyTeamSurvey;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\User\User;
use App\Models\User\UserNotification;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name',
        'telephone_number',
        'website',
    ];

    /**
     * Get the contacts that belong to the customer.
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Get the contacts that belong to the customer.
     */
    public function sites()
    {
        return $this->hasMany(CustomerSite::class);
    }

    /**
     * Get the contacts that belong to the customer.
     */
    public function energyMeters()
    {
        return $this->hasMany(EnergyMeter::class);
    }

    public function decisionMaker()
    {
        return $this->hasOne(Contact::class)
            ->where('decision_maker', 1);
    }

    public function technicalContact()
    {
        return $this->hasOne(Contact::class)
            ->where('technical_contact', 1);
    }

    public function financeContact()
    {
        return $this->hasOne(Contact::class)
            ->where('finance_contact', 1);
    }

    /**
     * Get the user that created the customer.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the files for the customer.
     */
    public function files()
    {
        return $this->hasMany(CustomerFile::class);
    }

    /**
     * Get the mobile opportunities for the customer.
     */
    public function mobileOpportunities()
    {
        return $this->hasMany(MobileOpportunity::class);
    }

    /**
     * Get the energy opportunities for the customer.
     */
    public function energyOpportunities()
    {
        return $this->hasMany(EnergyOpportunity::class);
    }

    /**
     * Get the journey team surveys for the customer.
     */
    public function journeyTeamSurveys()
    {
        return $this->hasMany(JourneyTeamSurvey::class);
    }

    /**
     * Get the notes for the customer.
     */
    public function notes()
    {
        return $this->hasMany(CustomerNote::class)->orderBy('created_at', 'desc');
    }

    public function activeNotes()
    {
        return $this->hasMany(CustomerNote::class)->orderBy('created_at', 'desc')
                                                  ->where('active', 1);
    }

    public function notifications()
    {
        return $this->morphMany(UserNotification::class, 'notable');
    }

    public function scopeLike($query, $field, $value)
    {
        return $query->where($field, 'LIKE', "%$value%");
    }

    public function scopePermissions($query)
    {
        if (auth()->user()->isAdmin() || auth()->user()->hasAnyPermission([
                'show_all_leads_energy',
                'show_all_leads_mobile',
                'show_all_appointment_leads_mobile',
                'show_all_branch_opportunities_mobile',
                'show_all_leads_fixed_line',
                'show_all_appointment_leads_fixed_line'
            ])
        ) {
            return $query;
        }

        return $query->where('created_by', auth()->user()->id)
            ->orWhereHas('mobileOpportunities', function ($qry) {
                $qry->where(function ($q) {
                    $q->where('created_by', auth()->user()->id)
                        ->orWhereHas('assigned', function ($query) {
                            $query->where('user_id', auth()->user()->id);
                        });
                });
            })
            ->orWhereHas('energyOpportunities', function ($qry) {
                $qry->where(function ($q) {
                    $q->where('created_by', auth()->user()->id)
                        ->orWhereHas('assigned', function ($query) {
                            $query->where('user_id', auth()->user()->id);
                        });
                });
            });
    }

    public function getOpenMobileOpportunities()
    {
        return $this->mobileOpportunities()
            ->whereHas('status', function ($query) {
                $query->where('blown', 0)
                    ->where('name', '<>', 'Passed Credit Check');
            })->count();
    }

    public function getOpenEnergyOpportunityValue()
    {
        return 0;
    }

    public function getContacts()
    {
        return $this->contacts->pluck('full_name', 'id')->toArray();
    }

    public function getContactsWithEmail()
    {
        return $this->contacts->pluck('full_name_email', 'id')->toArray();
    }

    public function getSites()
    {
        return $this->sites->pluck('address', 'id')->toArray();
    }

    public function path($page = null)
    {
        return '/customers/' . $this->id . '/' . $page;
    }

    public function pathWithoutSlash($page = null)
    {
        return 'customers/' . $this->id . '/' . $page;
    }

    public function getServicesPaths()
    {
        if (request()->is($this->pathWithoutSlash('mobile') . '*')) {
            return true;
        }

        if (request()->is($this->pathWithoutSlash('energy') . '*')) {
            return true;
        }

        if (request()->is($this->pathWithoutSlash('journey-team-survey') . '*')) {
            return true;
        }

        return false;
    }

    public function otherServices()
    {
        return $this->hasMany(OtherService::class);
    }



    /**
     * Get the mobile opportunities for the customer.
     */
    public function fixedLineOpportunities()
    {
        return $this->hasMany(fixedLineOpportunity::class);
    }

    public function getOpenFixedLineOpportunities()
    {
        return $this->fixedLineOpportunities()
            ->whereHas('status', function ($query) {
                $query->where('blown', 0)
                    ->where('name', '<>', 'Passed Credit Check');
            })->count();
    }
}
