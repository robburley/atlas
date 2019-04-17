<?php

namespace App\Http\Controllers\MobileOpportunity;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\MobileOpportunity\MobileOpportunity;
use Illuminate\Support\Facades\Artisan;

class MobileOpportunityCifController extends Controller
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

    public function store(Customer $customer, MobileOpportunity $opportunity)
    {
        $opportunity->unsignedCif()->delete();
        $opportunity->unsignedCifNonEsign()->delete();

        Artisan::call('atlas:generate-cif-form', [
            'opportunity' => $opportunity->id
        ]);

        alert()->success('CIF Generated');

        return redirect()->back();
    }
}
