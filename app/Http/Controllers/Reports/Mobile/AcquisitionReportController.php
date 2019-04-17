<?php

namespace App\Http\Controllers\Reports\Mobile;


use App\Helpers\MobileOpportunityStatusHelper;
use App\Http\Controllers\Controller;
use App\Models\MobileOpportunity\MobileOpportunity;
use App\Models\User\Role;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AcquisitionReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            $start = Carbon::createFromFormat('d/m/Y', $request->get('start'))->startOfDay();
            $end = Carbon::createFromFormat('d/m/Y', $request->get('end'))->endOfDay();
        } catch (\Exception $e) {
            $start = Carbon::now()->subDay()->startOfDay();
            $end = Carbon::now()->subDay()->endOfDay();

            while ($start->isWeekend()) {
                $start->subDay();
                $end->subDay();
            }
        }

        $data = $this->getData($start, $end);

        return view('reports.mobile.blown-appointments', [
            'data'  => $data,
            'start' => $start,
            'end'   => $end,
            'name'  => "Yesterday's Acquisitions"
        ]);
    }

    public function getData($start, $end)
    {
        return MobileOpportunity::isNotAppointment()
                                ->where(function ($query) use ($start, $end) {
                                    $query->billOrRequirements($start, $end);
                                })
                                ->orWhere(function ($query) use ($start, $end) {
                                    $query->whereHas('purchaseOrder', function ($qry) use ($start, $end) {
                                        $qry->whereBetween('customer_files.created_at', [$start, $end]);
                                    });
                                })->get();

    }

}
