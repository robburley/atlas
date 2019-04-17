<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('moderator', 'created_at', 'updated_at');
    }

    public function moderators()
    {
        return $this->belongsToMany(User::class)->withPivot('moderator', 'created_at', 'updated_at')->wherePivot('moderator', 1);
    }
}
