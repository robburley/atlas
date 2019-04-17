<?php

namespace App\Models\MobileOpportunity\DealCalculator;

use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\MobileOpportunity\TariffType;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class DealCalculator extends Model
{
    protected $table = 'deal_calculators';

    protected $fillable = [
        'user_id',
        'mobile_opportunity_id',
        'active',
        'primary_connections',
        'secondary_connections',
        'contributions',
        'handsets',
        'accessories',
        'credits',
        'overview',
        'name',
        'primary',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function opportunity()
    {
        return $this->belongsTo(MobileOpportunity::class, 'mobile_opportunity_id');
    }

    public function accessories()
    {
        return $this->hasMany(DealCalculatorAccessories::class);
    }

    public function contributions()
    {
        return $this->hasMany(DealCalculatorContributions::class);
    }

    public function credits()
    {
        return $this->hasMany(DealCalculatorCredits::class);
    }

    public function handsets()
    {
        return $this->hasMany(DealCalculatorHandsets::class);
    }

    public function connections()
    {
        return $this->hasMany(DealCalculatorConnections::class);
    }

    public function primaryConnections()
    {
        return $this->hasMany(DealCalculatorConnections::class)
                    ->where('primary', 1);
    }

    public function secondaryConnections()
    {
        return $this->hasMany(DealCalculatorConnections::class)
                    ->where('primary', 0);
    }

    public function overview()
    {
        return $this->hasOne(DealCalculatorOverviews::class);
    }

    public function setPrimaryConnectionsAttribute($data)
    {
        if ($this->exists) {
            $this->primaryConnections->each(function ($connection) {
                $connection->delete();
            });

            foreach ($data as $item) {
                $this->primaryConnections()->create($item);
            }

            return;
        }

        static::created(function ($related) use ($data) {
            $related->setPrimaryConnectionsAttribute($data);
        });
    }

    public function setSecondaryConnectionsAttribute($data)
    {
        if ($this->exists) {
            $this->secondaryConnections->each(function ($connection) {
                $connection->delete();
            });

            foreach ($data as $item) {
                $this->secondaryConnections()->create($item);
            }

            return;
        }

        static::created(function ($related) use ($data) {
            $related->setSecondaryConnectionsAttribute($data);
        });
    }

    public function setContributionsAttribute($data)
    {
        if ($this->exists) {
            $this->contributions->each(function ($item) {
                $item->delete();
            });

            foreach ($data as $item) {
                $this->contributions()->create($item);
            }

            return;
        }

        static::created(function ($related) use ($data) {
            $related->setContributionsAttribute($data);
        });
    }

    public function setHandsetsAttribute($data)
    {
        if ($this->exists) {
            $this->handsets->each(function ($item) {
                $item->delete();
            });

            foreach ($data as $item) {
                $this->handsets()->create($item);
            }

            return;
        }

        static::created(function ($related) use ($data) {
            $related->setHandsetsAttribute($data);
        });
    }

    public function setAccessoriesAttribute($data)
    {
        if ($this->exists) {
            $this->accessories->each(function ($item) {
                $item->delete();
            });

            foreach ($data as $item) {
                $this->accessories()->create($item);
            }

            return;
        }

        static::created(function ($related) use ($data) {
            $related->setAccessoriesAttribute($data);
        });
    }

    public function setCreditsAttribute($data)
    {
        if ($this->exists) {
            $this->credits->each(function ($item) {
                $item->delete();
            });

            foreach ($data as $item) {
                $this->credits()->create($item);
            }

            return;
        }

        static::created(function ($related) use ($data) {
            $related->setCreditsAttribute($data);
        });
    }

    public function setOverviewAttribute($data)
    {
        if ($this->exists) {
            $this->overview && $this->overview->delete();

            $this->overview()->create($data);

            return;
        }

        static::created(function ($related) use ($data) {
            $related->setOverviewAttribute($data);
        });
    }

    public function deactivate()
    {
        return $this->update(['active' => 0]);
    }

    public function getConnectionTypes()
    {
        return $this->primaryConnections->map(function ($connection) {
            return $connection->tariff->type->name;
        })->unique();
    }

    public function getBuyout()
    {
        $buyout = $this->credits->where('name', 'Buyout')->first();

        return $buyout
            ? $buyout->total
            : 0;
    }

    public function getSimCards()
    {
        return $this->accessories->where('name', 'O2 SIM Card')->first();
    }

    public function getDealIncentive()
    {
        return $this->contributions->where('name', 'Customer Contribution')->first()->total ?? 0;
    }

    public function getCashBack()
    {
        return $this->credits->where('name', 'Line Rental Cashback')->first()->total ?? 0;
    }

    public function getCustomerContribution()
    {
        return $this->contributions->where('name', 'Customer Contribution')->first()->total ?? 0;
    }

    public function hasTariffType($type)
    {
        $type = TariffType::where('name', $type)->first();

        if ($type) {
            $connections = $this->primaryConnections()
                                ->whereHas('tariff', function ($query) use ($type) {
                                    return $query->where('tariffs.tariff_type_id', $type->id);
                                })->count();

            if ($connections) {
                return true;
            }
        }

        return false;
    }

    public function hasTariffs()
    {
        return $this->connections()->has('tariff')->count() > 0;
    }

    public function getBcadDiff()
    {
        return $this->primaryConnections->map(function ($con) {
            return $con->tariff
                ? ($con->tariff->price - $con->cost) * $con->connections
                : 0;
        })->sum();
    }

    public function getBcadDiffTotal()
    {
        return $this->getBcadDiff() * $this->connections->first()->term;
    }

    public function getConsultancyFee()
    {
        $connections = $this->connections()
                            ->whereHas('tariff', function ($query) {
                                return $query->whereIn('tariffs.tariff_type_id', [1, 2]);
                            })
                            ->get();

        return $connections->sum('connections') * 250;
    }

    public function countNewConnections()
    {
        return $this->connections()
                    ->where('type', 1)
                    ->whereHas('tariff', function ($query) {
                        $query->whereHas('type', function ($qry) {
                            $qry->where('vas', 0);
                        });
                    })->sum('connections');
    }

    public function countUpgradeConnections()
    {
        return $this->connections()
                    ->whereIn('type', [2, 3])
                    ->whereHas('tariff', function ($query) {
                        $query->whereHas('type', function ($qry) {
                            $qry->where('vas', 0);
                        });
                    })->sum('connections');
    }

    public function getHardwareFund()
    {
        return $this->credits->where('name', 'Hardware Fund')->first();
    }

    public function getUnlockFeeCards()
    {
        return $this->accessories()->where('name', 'Unlock Fee')->first();
    }

    public function getTerm()
    {
        return $this->connections->first()->term ?? '';
    }

    public function getLead()
    {
        return $this->primaryConnections()->whereHas('tariff', function ($query) {
            return $query->where('tariff_code', '<>', 'Secondary');
        })->first();
    }

    public function getSecondaries()
    {
        return $this->primaryConnections()->whereHas('tariff', function ($query) {
            return $query->where('tariff_code', 'Secondary');
        })->get();
    }

    public function getRawGrossTotal()
    {
        return $this->connections->map(function ($connection) {
            $connection->total_price = $connection->connections * $connection->tariff->price;

            return $connection;
        })->sum('total_price');
    }

    public function getRemainingSims()
    {
        $sims = $this->getSimCards()->units ?? 0;

        $handsets = $this->handsetsWithoutAdditionalSim()->sum('units');

        return $sims - $handsets;
    }

    public function handsetsWithoutAdditionalSim()
    {
        return $this->handsets->filter(function ($item) {
            return $item->handset_id != 110;
        });
    }
}
