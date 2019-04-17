<?php

namespace App\Http\Controllers\MobileOpportunity;

use App\Helpers\MobileOpportunityStatusHelper;
use App\Http\Controllers\Controller;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Http\Controllers\MobileOpportunity\SalesSheetController;

class QualityControlController extends Controller
{
    public function store(MobileOpportunity $opportunity)
    {
        $this->validate(request(), [
            'data.Information.description' => 'required_if:data.Information.complete,false',
            'data.Allocations.description' => 'required_if:data.Allocations.complete,false',
            'data.Deal.description'        => 'required_if:data.Deal.complete,false',
        ], [
            'data.Information.description.required_if' => 'The information corrections description is required',
            'data.Allocations.description.required_if' => 'The allocation corrections description is required',
            'data.Deal.description.required_if'        => 'The deal corrections description is required',
        ]);

        $opportunity->corrections->each(function ($correction) {
            $correction->action();
        });

        $data = collect(request()->get('data'));

        $data->each(function ($row, $index) use ($opportunity) {
            if (!$row['complete']) {
                $opportunity->corrections()->create([
                    'user_id'     => request()->get('user'),
                    'type'        => $index,
                    'description' => $row['description'],
                    'penalty'     => $row['penalty'],
                ]);
            }
        });

        $errors = $data->map(function ($item) {
            return $item['complete'];
        })
                       ->flatten()
                       ->contains(false);

        $newStatus = $errors
            ? (new MobileOpportunityStatusHelper)->get('awaiting-correction')
            : (new MobileOpportunityStatusHelper)->get('awaiting-credit-check');

        $opportunity->update([
            'mobile_opportunity_status_id' => $newStatus
        ]);

        if(count($opportunity->salesSheet) == 0) {
            (new SalesSheetController)->generateSalesSheet($opportunity->customer, $opportunity);
        }

    }
}
