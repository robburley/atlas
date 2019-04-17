<?php

namespace App\Http\Controllers\MobileOpportunity;

use App\Http\Controllers\Controller;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\MobileOpportunity\MobileOpportunityStatus;
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
     * @param MobileOpportunityStatus $status
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = MobileOpportunity::has('reassignable')
            ->with([
                'customer',
                'creator',
                'activeAssigned',
                'inactiveAssigned',
                'mobileBills',
                'appointments',
                'callbacks',
                'incompleteCallbacks',
                'status'
            ])
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
            ['path' => '/mobile/reassignable']
        );

        return view('mobile.opportunities.index', [
            'opportunities' => $data,
            'totalGp'       => number_format($orders->sum('gp'), 2),
            'subTitle'      => 'Reassignable'
        ]);
    }
}
