<?php

namespace App\Models\Customer;


use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ScheduledCallback extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'opportunity_id',
        'opportunity_type',
        'user_id',
        'created_by',
        'time',
        'completed_at',
        'completed_by',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'time',
        'completed_at',
    ];

    /**
     * Get the user who created the note.
     */
    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who is assigned to this callback.
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function opportunity()
    {
        return $this->morphTo();
    }

    /**
     * @param $value
     */
    public function setTimeAttribute($value)
    {
        if ($value) {
            $this->attributes['time'] = $value instanceof Carbon
                ? $value
                : Carbon::createFromFormat('d/m/Y H:i:s', $value);
        }
    }

    /**
     * @param $query
     */
    public function scopeToday($query)
    {
        $query->where('time', '<', Carbon::now()->endOfDay());
    }

    /**
     * @param $query
     */
    public function scopeIncomplete($query)
    {
        $query->whereNull('completed_at');
    }

    public function scopeMine($query)
    {
        $query->where('user_id', auth()->user()->id);
    }

    public function scopeUpToThisWeek($query)
    {
        $query->where('time', '<', Carbon::now()->endOfWeek());
    }

    public function isComplete()
    {
        return !is_null($this->completed_at);
    }

    public function getType()
    {
        switch ($this) {
            case ($this->opportunity_type == 'mobileOpportunity'):
                return 'mobile/opportunities';
                break;
            case ($this->opportunity_type == 'energyOpportunity'):
                return 'energy/opportunities';
                break;
        }
    }
}
