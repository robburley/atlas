<?php

namespace App\Http\Controllers\EnergyOpportunity;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\EnergyOpportunity\EnergyOpportunity;
use Maatwebsite\Excel\Facades\Excel;

class TenderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Customer $customer, EnergyOpportunity $energyOpportunity)
    {
        Excel::create(str_slug($customer->company_name) . '-tender', function($excel)  use ($energyOpportunity){

            $excel->sheet('tender', function($sheet)  use ($energyOpportunity){

                $sheet->loadView('energy.opportunities.tender', [
                    'energyOpportunity' => $energyOpportunity
                ]);

            });

        })->download('xls');
    }
}
