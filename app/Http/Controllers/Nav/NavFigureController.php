<?php

namespace App\Http\Controllers\Nav;

use App\Helpers\NavPopulator;
use App\Http\Controllers\Controller;

class NavFigureController extends Controller
{
    public function index()
    {
        $method   = request()->get('method');
        $argument = request()->get('argument');

        return NavPopulator::$method($argument);
    }
}
