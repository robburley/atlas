<?php

namespace App\Models\User;

use App\Models\Recruitment\Application;
use App\Models\Recruitment\Position;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'active'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }


    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
