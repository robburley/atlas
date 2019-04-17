<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Admin\CashFlowItem;
use App\Models\Admin\CashFlowOneOff;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class CashFlowOneOffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store()
    {
        $this->validate(request(), [
            'value' => 'required|min:1',
            'date' => 'required|date_format:d/m/Y',
            'type' => 'required'
        ]);

        CashFlowOneOff::create(request()->all());

        alert()->success('One off item added.');

        return redirect()->back();
    }
}