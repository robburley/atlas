<?php

namespace App\Models\FixedLineOpportunity;


use Illuminate\Database\Eloquent\Model;

class Commercials extends Model
{
    protected $table = 'fixed_line_commercials';

    protected $fillable = [
        'lines',
        'tariff',
        'setup_install_charges',
        'broad_band_confirmed',
        'admin_charge_confirmed',
        'fibre_broad_band_price',
        'adsl_broad_band_price',
        'call_bundle_local_national',
        'call_bundle_mobile',
        'custom_local',
        'custom_national',
        'custom_vodafone',
        'custom_o2',
        'custom_ee',
        'custom_three',
        'monthly_line_rental',
        'monthly_features_rental',
        'total_monthly_recurring_charges',
        'total_setup_install_charges',
        'fixed_line_opportunity_id',
        'note',
        'term'
    ];

    public function lines()
    {
        return $this->hasMany(CommercialLine::class, 'fixed_line_commercial_id');
    }

    public function setLinesAttribute(array $lines)
    {
        if ($this->exists) {
            $this->lines->each(function ($line) {
                $line->delete();
            });

            foreach ($lines as $line) {
                $this->lines()->create($line);
            }

            return true;
        }

        static::created(function ($related) use ($lines) {
            return $related->setLinesAttribute($lines);
        });
    }

    function setSetupInstallChargesAttribute($value)
    {
        $this->attributes['setup_install_charges'] = $value * 100;
    }

    function setBroadBandConfirmedAttribute($value)
    {
        $this->attributes['broad_band_confirmed'] = $value * 100;
    }

    function setFibreBroadBandPriceAttribute($value)
    {
        $this->attributes['fibre_broad_band_price'] = $value * 100;
    }

    function setAdslBroadBandPriceAttribute($value)
    {
        $this->attributes['adsl_broad_band_price'] = $value * 100;
    }

    function setCallBundleLocalNationalAttribute($value)
    {
        $this->attributes['call_bundle_local_national'] = $value * 100;
    }

    function setCallBundleMobileAttribute($value)
    {
        $this->attributes['call_bundle_mobile'] = $value * 100;
    }

    function setMonthlyLineRentalAttribute($value)
    {
        $this->attributes['monthly_line_rental'] = $value * 100;
    }

    function setMonthlFeaturesRentalAttribute($value)
    {
        $this->attributes['monthly_features_rental'] = $value * 100;
    }

    function setTotalMonthlyRecurringChargesAttribute($value)
    {
        $this->attributes['total_monthly_recurring_charges'] = $value * 100;
    }

    function setTotalSetupInstallChargesAttribute($value)
    {
        $this->attributes['total_setup_install_charges'] = $value * 100;
    }

    function getSetupInstallChargesAttribute($value)
    {
        return $value / 100;
    }

    function getBroadBandConfirmedAttribute($value)
    {
        return $value / 100;
    }

    function getFibreBroadBandPriceAttribute($value)
    {
        return $value / 100;
    }

    function getAdslBroadBandPriceAttribute($value)
    {
        return $value / 100;
    }

    function getCallBundleLocalNationalAttribute($value)
    {
        return $value / 100;
    }

    function getCallBundleMobileAttribute($value)
    {
        return $value / 100;
    }

    function getMonthlyLineRentalAttribute($value)
    {
        return $value / 100;
    }

    function getMonthlFeaturesRentalAttribute($value)
    {
        return $value / 100;
    }

    function getTotalMonthlyRecurringChargesAttribute($value)
    {
        return $value / 100;
    }

    function getTotalSetupInstallChargesAttribute($value)
    {
        return $value / 100;
    }

    function setCustomLocalAttribute($value)
    {
        $this->attributes['custom_local'] = $value * 1000;
    }

    function getCustomLocalAttribute($value)
    {
        return $value / 1000;
    }

    function setCustomNationalAttribute($value)
    {
        $this->attributes['custom_national'] = $value * 1000;
    }

    function getCustomNationalAttribute($value)
    {
        return $value / 1000;
    }

    function setCustomVodafoneAttribute($value)
    {
        $this->attributes['custom_vodafone'] = $value * 1000;
    }

    function getCustomVodafoneAttribute($value)
    {
        return $value / 1000;
    }

    function setCustomO2Attribute($value)
    {
        $this->attributes['custom_o2'] = $value * 1000;;
    }

    function getCustomO2Attribute($value)
    {
        return $value / 1000;
    }

    function setCustomEeAttribute($value)
    {
        $this->attributes['custom_ee'] = $value * 1000;;
    }

    function getCustomEeAttribute($value)
    {
        return $value / 1000;
    }

    function setCustomThreeAttribute($value)
    {
        $this->attributes['custom_three'] = $value * 1000;
    }

    function getCustomThreeAttribute($value)
    {
        return $value / 1000;
    }

}
