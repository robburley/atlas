<?php

namespace App\Http\Controllers\Offices;

use App\Http\Controllers\Controller;
use App\Models\User\Office;

class OfficesApiController extends Controller
{
    public function index()
    {
        return Office::active()->whereHas('positions')->pluck('name', 'slug');
    }
}
