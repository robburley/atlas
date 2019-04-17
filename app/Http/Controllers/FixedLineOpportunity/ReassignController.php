<?php

namespace App\Http\Controllers\FixedLineOpportunity;

use App\Http\Controllers\Controller;
use App\Models\FixedLineOpportunity\FixedLineOpportunity;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\MobileOpportunity\MobileOpportunityStatus;
use Illuminate\Http\Request;

class ReassignController extends Controller
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

    public function update(Request $request)
    {
        $reassign = $request->get('reassign');
        $opportunities = $request->get('opportunity');

        if ($reassign && $opportunities) {

            foreach ($opportunities as $key => $opportunity) {
                $currentOpportunity = FixedLineOpportunity::find($opportunity);

                $currentOpportunity && $currentOpportunity->update([
                    'mass_assigned' => 1,
                    'user_id' => $reassign
                ]);
            }

            alert()->success(count($opportunities) . ' Opportunities Reassigned');
        }

        return redirect()->back();
    }
}
