<?php

namespace App\Helpers;

use App\Models\MobileOpportunity\MobileOpportunityStatus;

class MobileOpportunityStatusHelper
{
    public $statuses;

    public function __construct()
    {
        $this->statuses = MobileOpportunityStatus::get(['id', 'slug', 'order']);
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