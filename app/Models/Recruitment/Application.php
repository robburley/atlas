<?php

namespace App\Models\Recruitment;

use App\Models\User\Office;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'office_id',
        'position_id',
        'first_name',
        'last_name',
        'telephone',
        'mobile',
        'email',
        'date_of_birth',
        'commitments',
        'children',
        'married',
        'experience',
        'current_role',
        'change_reason',
        'best_job',
        'biggest_achievement',
        'drive',
        'bring_to_business',
        'suitable_reason',
        'best_attributes',
        'development_areas',
        'confidence',
        //for setters
        'location',
        'position',
        'cv',
    ];

    public function getApplicantNameAttribute()
    {
        return ucwords($this->first_name . ' ' . $this->last_name);
    }

    public function files()
    {
        return $this->hasMany(ApplicationFile::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function setCvAttribute($file)
    {
        if ($this->exists) {
            return $this->createFile($file, $this);
        }

        static::created(function ($application) use ($file) {
            $application->createFile($file, $application);
        });
    }

    public function setLocationAttribute($value)
    {
        $office = Office::where('slug', $value)->first();

        $office && $this->attributes['office_id'] = $office->id;
    }

    public function setPositionAttribute($value)
    {
        $position = Position::where('slug', $value)->first();

        $position && $this->attributes['position_id'] = $position->id;
    }

    public function createFile($file, $application)
    {
        $applicationFile = ApplicationFile::create(['application_id' => $application->id]);

        $fileName = 'cv-' . str_slug($application->applicant_name) . '.' . $file->getClientOriginalExtension();

        $file->storeAs(
            'applications', $fileName
        );

        $applicationFile->update([
            'location' => 'applications/' . $fileName
        ]);
    }
}
