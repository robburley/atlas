<?php

namespace App\Http\Controllers\MobileOpportunity;

use App\Http\Controllers\Controller;
use App\Http\Requests\MobileOpportunity\PhoneRequest;
use App\Models\MobileOpportunity\Phone;
use Illuminate\Http\Request;

class PhonesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mobile.admin.phones.index', [
            'phones' => Phone::active()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mobile.admin.phones.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PhoneRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PhoneRequest $request)
    {
        Phone::create($request->all());

        alert()->success('Phone Created');

        return redirect('/admin/mobile/phones');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Phone $tariff
     * @return \Illuminate\Http\Response
     */
    public function edit(Phone $tariff)
    {
        return view('mobile.admin.phones.edit', [
            'tariff' => $tariff
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PhoneRequest $request
     * @param  Phone $tariff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Phone $tariff)
    {
        $tariff->update($request->all());

        alert()->success('Phone Updated');

        return redirect('/admin/mobile/phones');
    }

}
