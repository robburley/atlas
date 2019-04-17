<?php

namespace App\Http\Controllers\MobileOpportunity;


use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\ScheduledCallback;
use App\Models\MobileOpportunity\MobileOpportunity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllocationsController extends Controller
{
    /**
     * @param MobileOpportunity $opportunity
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function store(MobileOpportunity $opportunity)
    {
        $this->validate(request(), [
            'allocation.*.name'        => 'required|max:255',
            'allocation.*.type'        => 'required',
            'allocation.*.networkTo'   => 'required',
            'allocation.*.networkFrom' => 'required_if:allocation.*.type,Port',
            'allocation.*.colour'      => 'required_with:allocation.*.handset',
        ], [
            'allocation.*.name.required'           => 'Each line needs a name',
            'allocation.*.type.required'           => 'Each line needs a type',
            'allocation.*.networkTo.required'      => 'Each line needs a network to port to',
            'allocation.*.networkFrom.required_if' => 'If porting, each line needs a network to port from',
            'allocation.*.colour.required_with'    => 'you must select a handset colour',
        ]);

        DB::beginTransaction();

        try {

            if (request()->has('allocation')) {
                $opportunity->allocations()->delete();
            }

            foreach (request()->get('allocation') as $data) {
                $allocation = $opportunity->allocations()->create([
                    'tariff_id'    => $data['tariff_id'],
                    'tariff_name'  => $data['tariff'],
                    'name'         => $data['name'],
                    'colour'       => $data['colour'],
                    'phone_number' => $data['phone_number'],
                    'type'         => $data['type'],
                    'network_from' => $data['networkFrom'],
                    'network_to'   => $data['networkTo'],
                    'handset_id'   => count($data['handset']) > 0
                        ? $data['handset'][0]['id']
                        : null,
                    'handset_name' => count($data['handset']) > 0
                        ? $data['handset'][0]['name']
                        : null,
                ]);

                foreach ($data['vas'] as $vas) {
                    $allocation->vas()->create([
                        'tariff_id'   => $vas['id'],
                        'tariff_name' => $vas['name']
                    ]);
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
        }

        DB::commit();

        return $opportunity->allocations()->get();
    }
}
