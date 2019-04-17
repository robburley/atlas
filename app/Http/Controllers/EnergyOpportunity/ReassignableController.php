<?php

namespace App\Http\Controllers\EnergyOpportunity;

use App\Http\Controllers\Controller;
use App\Models\EnergyOpportunity\EnergyOpportunity;
use App\Models\EnergyOpportunity\EnergyOpportunityStatus;
use Illuminate\Pagination\LengthAwarePaginator;

class ReassignableController extends Controller
{
    /**
     * Create a new dashboard controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param EnergyOpportunityStatus $status
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = EnergyOpportunity::has('reassignable')
                                   ->with(['reassignable'])
                                   ->reassignableFilters()
                                   ->filters()
                                   ->get()
                                   ->map(function ($opportunity, $key) {
                                       $opportunity->reassignable->map(function ($user, $key) {
                                           $user->assigned_at = $user->pivot->created_at;

                                           return $user;
                                       });

                                       return $opportunity;
                                   })
                                   ->sortBy(function ($opportunity) {
                                       return $opportunity->reassignable->first()->assigned_at;
                                   });

        $data = new LengthAwarePaginator(
            $orders->forPage(request()->get('page'), 50),
            $orders->count(),
            50,
            request()->get('page') ?? 1,
            ['path' => '/energy/reassignable']
        );

        return view('energy.opportunities.index', [
            'opportunities' => $data,
            'subTitle' => 'Reassignable'
        ]);
    }
}
