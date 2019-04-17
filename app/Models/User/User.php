<?php

namespace App\Models\User;

use App\Models\Admin\LogInAttempt;
use App\Models\Admin\PrintScreenLog;
use App\Models\Calender\Event;
use App\Models\Customer\Customer;
use App\Models\Customer\ScheduledCallback;
use App\Models\Faq\Question;
use App\Models\FixedLineOpportunity\FixedLineOpportunity;
use App\Models\JourneyTeamSurvey\JourneyTeamSurvey;
use App\Models\MobileOpportunity\MobileOpportunity;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role_id',
        'active',
        'sidebar',
        'office_id',
        'deactivated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $cachedPermissions;
    public $upcomingEvents;

    /**
     * Get the created customers for the user.
     */
    public function createdCustomers()
    {
        return $this->hasMany(Customer::class, 'created_by');
    }

    public function createdCallbacks()
    {
        return $this->hasMany(ScheduledCallback::class, 'created_by');
    }

    public function assignedCallbacks()
    {
        return $this->hasMany(ScheduledCallback::class, 'user_id');
    }

    public function todayAssignedCallbacks()
    {
        return $this->hasMany(ScheduledCallback::class, 'user_id')
                    ->whereBetween('time', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])
                    ->orderBy('time', 'asc');
    }

    /**
     * Get the created customers for the user.
     */
    public function createdMobileOpportunities()
    {
        return $this->hasMany(MobileOpportunity::class, 'created_by');
    }

    public function mobileAssigned()
    {
        return $this->belongsToMany(MobileOpportunity::class)
                    ->withTimestamps()
                    ->withPivot('user_id', 'mobile_opportunity_id', 'active', 'created_at');
    }

    /**
     * Get the user that the customer is assigned to.
     */
    public function activeMobileAssigned()
    {
        return $this->belongsToMany(MobileOpportunity::class)
                    ->withTimestamps()
                    ->wherePivot('active', 1)
                    ->withPivot('active', 'created_at');
    }

    /**
     * Get the notifications for the user.
     */
    public function notifications()
    {
        return $this->hasMany(UserNotification::class);
    }

    public function getAllNotifications()
    {
        return $this->notifications()
                    ->orderBy('read', 'asc')
                    ->orderBy('created_at', 'asc')
                    ->paginate(50);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function teamsModerator()
    {
        return $this->belongsToMany(Team::class)->withPivot(
            'moderator',
            'created_at',
            'updated_at'
        )->wherePivot('moderator', 1);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    public function hasPermission($slug)
    {
        return empty($slug)
            ? false
            : $this->permissions->where('slug', $slug)->count() > 0 || $this->isAdmin();
    }

    public function hasAnyPermission(array $slugs)
    {
        foreach ($slugs as $slug) {
            if ($this->hasPermission($slug)) {
                return true;
            }
        }

        return false;
    }

    public function isAdmin()
    {
        return $this->role->name == 'Admin';
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('active', 0);
    }

    public function hitMaxCallbacks()
    {
        return $this->assignedCallbacks()->incomplete()->where('time', '<', Carbon::now()->startOfDay())->count() > 10;
    }

    public function moderatesATeam()
    {
        return count($this->teamsModerator) > 0;
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('role_id', 'asc')->orderBy('name', 'asc');
    }

    public function scopeFiltered($query)
    {
        if (request()->has('name')) {
            $query->where('name', 'LIKE', '%' . request()->name . '%');
        }

        if (request()->has('role_id') && request()->role_id > 0) {
            $query->where('role_id', request()->role_id);
        }

        if (request()->has('created_from') && request()->has('created_to')) {
            try {
                $start = Carbon::createFromFormat('d/m/Y', request()->created_from)->startOfDay();
                $end = Carbon::createFromFormat('d/m/Y', request()->created_to)->endOfDay();
            } catch (\Exception $e) {
                $start = Carbon::now()->endOfDay();
                $end = Carbon::now()->startOfDay();
            }

            $query->whereBetween('created_at', [$start, $end]);
        }

        if (request()->has('office_id') && request()->office_id > 0) {
            $query->where('office_id', request()->office_id);
        }

        return $query;
    }

    public function getUpcomingEvents()
    {
        if (!isset($this->upcomingEvents) || empty($this->upcomingEvents)) {
            $this->upcomingEvents = $this->events()
                                         ->whereBetween(
                                             'date_time',
                                             [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()]
                                         )
                                         ->orderBy('date_time', 'asc')
                                         ->get();
        }

        return $this->upcomingEvents;
    }

    public function createdJourneyTeamSurveys()
    {
        return $this->hasMany(JourneyTeamSurvey::class, 'user_id');
    }

    /**
     * Get the created customers for the user.
     */
    public function createdFixedLineOpportunities()
    {
        return $this->hasMany(FixedLineOpportunity::class, 'created_by');
    }

    public function fixedLineAssigned()
    {
        return $this->belongsToMany(FixedLineOpportunity::class)
                    ->withTimestamps()
                    ->withPivot('user_id', 'fixed_line_opportunity_id', 'active', 'created_at');
    }

    public function activeFixedLineAssigned()
    {
        return $this->belongsToMany(FixedLineOpportunity::class)
                    ->withTimestamps()
                    ->wherePivot('active', 1)
                    ->withPivot('active', 'created_at');
    }

    public function adobeSignAccessToken()
    {
        return $this->hasOne(AdobeSignAccessToken::class);
    }

    public function needsAdobeSignAccessTokenRefresh()
    {
        return $this->adobeSignAccessToken && $this->adobeSignAccessToken->expires <= Carbon::now()->addMinutes(70);
    }

    public function needsAdobeSignAccessToken()
    {
        return !$this->adobeSignAccessToken;
    }

    public function isRole($role)
    {
        return $this->role && $this->role->name == $role;
    }

    public function isInRoles(array $roles)
    {
        foreach ($roles as $role) {
            if ($this->role->name == $role) {
                return true;
            }
        }

        return false;
    }

    public function hrProfile()
    {
        return $this->hasOne(HrProfile::class);
    }

    public function setActiveAttribute($value)
    {
        if ($value == 0) {
            $this->attributes['deactivated_at'] = Carbon::now();

            return $this->attributes['active'] = $value;
        }

        $this->attributes['deactivated_at'] = null;

        return $this->attributes['active'] = $value;
    }

    public function printscreens()
    {
        return $this->hasMany(PrintScreenLog::class, 'user_id');
    }

    public function logInAttempts()
    {
        return $this->hasMany(LogInAttempt::class, 'user_id');
    }

    public function successfulLogInAttempts()
    {
        return $this->hasMany(LogInAttempt::class, 'user_id')
                    ->where('outcome', 1)
                    ->latest();
    }
}
