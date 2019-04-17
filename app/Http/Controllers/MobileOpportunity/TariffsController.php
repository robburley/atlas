<?php

namespace App\Http\Controllers\MobileOpportunity;

use App\Http\Controllers\Controller;
use App\Http\Requests\MobileOpportunity\TariffRequest;
use App\Models\MobileOpportunity\Tariff;
use App\Models\MobileOpportunity\TariffType;
use Illuminate\Http\Request;

class TariffsController extends Controller
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
        return view('mobile.admin.tariffs.index', [
            'tariffs' => Tariff::active()
                ->searchName()
                ->searchType()
                ->with('type')
                ->orderBy('tariff_type_id', 'asc')
                ->orderBy('tariff_code', 'asc')
                ->orderBy('price', 'asc')
                ->get(),
            'types' => TariffType::pluck('name', 'id')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mobile.admin.tariffs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TariffRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TariffRequest $request)
    {
        Tariff::create($request->all());

        alert()->success('Tariff Created');

        return redirect('/admin/mobile/tariffs');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Tariff $tariff
     * @return \Illuminate\Http\Response
     */
    public function edit(Tariff $tariff)
    {
        return view('mobile.admin.tariffs.edit', [
            'tariff' => $tariff
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TariffRequest $request
     * @param  Tariff $tariff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tariff $tariff)
    {
        $tariff->update($request->all());

        alert()->success('Tariff Updated');

        return redirect('/admin/mobile/tariffs');
    }

}
