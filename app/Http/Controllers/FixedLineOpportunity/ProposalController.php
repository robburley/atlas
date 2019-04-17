<?php

namespace App\Http\Controllers\FixedLineOpportunity;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\FixedLineOpportunity\FixedLineOpportunity;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Customer $customer, FixedLineOpportunity $opportunity, Request $request)
    {
        return SnappyPdf::loadView('fixed-line.opportunities.pdf.proposal', [
            'opportunity' => $opportunity,
            'customer' => $customer,
        ])
            ->setPaper('a4')
            ->setOption('dpi', 96)
            ->setOption('margin-bottom', 0)
            ->setOption('margin-top', 0)
            ->setOption('margin-left', 0)
            ->setOption('margin-right', 0)
            ->inline("proposal-$customer->id-$opportunity->id.pdf");
    }
}
