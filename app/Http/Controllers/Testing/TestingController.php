<?php

namespace App\Http\Controllers\Testing;

use App\Http\Controllers\Controller;
use App\Models\MobileOpportunity\MobileOpportunity;

class TestingController extends Controller
{
    public function index()
    {
        $deals = MobileOpportunity::whereNotNull('dealt_at')
                                  ->whereHas('allocations', function($query){
                                      return $query->where('connection_reference', '<>', 'Fast Tracked');
                                  })
                                  ->with(['allocations'])
                                  ->get();

        $deals = $deals->map(function ($deal) {
            if ($deal->allocations->count() > 0 && $deal->allocations->count() < 2) {
                $deal->lines = 1;
            } elseif ($deal->allocations->count() > 1 && $deal->allocations->count() < 3) {
                $deal->lines = 2;
            } elseif ($deal->allocations->count() > 2 && $deal->allocations->count() < 4) {
                $deal->lines = 3;
            } elseif ($deal->allocations->count() > 3 && $deal->allocations->count() < 5) {
                $deal->lines = 4;
            } elseif ($deal->allocations->count() > 4 && $deal->allocations->count() < 6) {
                $deal->lines = 5;
            } elseif ($deal->allocations->count() > 5 && $deal->allocations->count() < 11) {
                $deal->lines = 6;
            } elseif ($deal->allocations->count() > 10 && $deal->allocations->count() < 21) {
                $deal->lines = 11;
            } elseif ($deal->allocations->count() > 20 && $deal->allocations->count() < 51) {
                $deal->lines = 21;
            } elseif ($deal->allocations->count() > 50 && $deal->allocations->count() < 101) {
                $deal->lines = 51;
            } elseif ($deal->allocations->count() > 100) {
                $deal->lines = 101;
            } else {
                $deal->lines = 0;
            }

            return $deal;
        })->groupBy('lines');

        dd($deals);

        return view('test', compact('deals'));
    }
}
