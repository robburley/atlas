<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\Position;
use App\Models\User\Office;

class PositionsApiController extends Controller
{
    /*
     * Get the positions for an office for the web site apply page
     */
    public function index($office)
    {
        $office = Office::where('slug', $office)->first();

        return $office ? Position::where('office_id', $office->id)->orderBy('name', 'asc')->pluck('name', 'slug') : null;
    }
}
