<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;

class ApplicationFile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'application_id',
        'location',
    ];

    protected $touches = ['application'];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
