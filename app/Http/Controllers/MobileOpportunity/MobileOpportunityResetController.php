<?php

namespace App\Http\Controllers\MobileOpportunity;


use App\Helpers\MobileOpportunityStatusHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\MobileOpportunity\MobileOpportunityRequest;
use App\Models\Customer\Customer;
use App\Models\MobileOpportunity\MobileNetwork;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\MobileOpportunity\MobileOpportunityStatus;
use Illuminate\Support\Facades\Gate;

class MobileOpportunityResetController extends Controller
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

    public function update(Customer $customer, MobileOpportunity $opportunity)
    {
        $opportunity->update([
            'mobile_opportunity_status_id' => (new MobileOpportunityStatusHelper)->get('awaiting-commercials'),
            'accepted'                     => null,
            'allocated'                    => 0,
            'dealt_at'                     => null,
        ]);

        $opportunity->deleteFilesExceptBill();

        $opportunity->adobeSignDocumentPurchaseOrder()->delete();

        alert()->success('Opportunity Reset');

        return redirect()->back();
    }
}
