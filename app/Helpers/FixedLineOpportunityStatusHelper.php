<?php

namespace App\Helpers;

use App\Models\FixedLineOpportunity\FixedLineOpportunityStatus;

class FixedLineOpportunityStatusHelper
{
    public $statuses;

    public function __construct()
    {
        $this->statuses = FixedLineOpportunityStatus::get(['id', 'slug', 'order']);
    }

    public function get($slug)
    {
        return $this->statuses->where('slug', $slug)->first()->id ?? null;
    }

    public function getOrder($slug)
    {
        return $this->statuses->where('slug', $slug)->first()->order ?? null;
    }
}