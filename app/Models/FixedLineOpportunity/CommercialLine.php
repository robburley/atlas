<?php

namespace App\Models\FixedLineOpportunity;


use Illuminate\Database\Eloquent\Model;

class CommercialLine extends Model
{
    protected $table = 'fixed_line_commercial_lines';

    protected $fillable = [
        'type',
        'telephone_number',
        'monthly_line_rental',
        'installation_postcode',
        'has1571',
        'call_divert',
        'call_waiting',
        'caller_display',
        'broadband',
    ];

    public function commerical()
    {
        return $this->belongsTo(Commercials::class, 'fixed_line_commercial_id');
    }

    public function setMonthlyLineRentalAttribute($value)
    {
        $this->attributes['monthly_line_rental'] = $value * 100;
    }

    public function getMonthlyLineRentalAttribute($value)
    {
        return $value / 100;
    }
}
