<?php

namespace App\Http\Controllers\Reports\FixedLine;

use App\Helpers\FixedLineOpportunityStatusHelper;
use App\Helpers\MobileOpportunityStatusHelper;
use App\Http\Controllers\Controller;
use App\Models\Appointments\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentsSatController extends Controller
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
            $start = Carbon::now()->startOfDay();
            $end = Carbon::now()->endOfDay();
        }

        $appointments = Appointment::whereBetween('time', [$start, $end])
            ->where('appointable_type', 'fixedLineOpportunity')
            ->whereHas('appointable', function($query){
                $query->where('fixed_line_opportunity_status_id', (new FixedLineOpportunityStatusHelper)->get('awaiting-closer-contact'));
            })
            ->with('appointable')
            ->get();

        return view('reports.appointments-sat', [
            'appointments' => $appointments
        ]);
    }

}
