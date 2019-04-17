<?php

namespace App\Http\Controllers\Appointments;

use App\Http\Controllers\Controller;
use App\Models\Appointments\Appointment;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
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

    public function update(Appointment $appointment, Request $request)
    {
        $appointment->update($request->all());

        return redirect()->back();
    }

}
