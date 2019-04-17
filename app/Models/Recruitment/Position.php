<?php

namespace App\Models\Recruitment;

use App\Models\User\Office;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use Sluggable;

    protected $fillable = [
        'office_id',
        'name',
        'slug',
        'active'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function scopeOrdered($query)
    {
        $query->orderBy('active', 'desc')
            ->orderBy('office_id', 'asc')
            ->orderBy('created_at', 'desc');
    }

    public function scopefiltered($query)
    {
        if (request()->has('office_id')) {
            $query->where('office_id', request()->get('office_id'));
        }

        if (request()->has('created_from') && request()->has('created_to')) {
            $query->whereBetween('created_at', [
                Carbon::createFromFormat('d/m/Y', request()->get('created_from'))->startOfDay(),
                Carbon::createFromFormat('d/m/Y', request()->get('created_to'))->endOfDay()
            ]);
        }
    }
}
