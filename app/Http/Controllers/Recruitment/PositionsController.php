<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\Position;
use Illuminate\Http\Request;

class PositionsController extends Controller
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

    public function index()
    {
        return view('positions.index', [
            'positions' => Position::filtered()->ordered()->paginate(50)
        ]);
    }

    public function create()
    {
        return view('positions.create');
    }

    public function store(Request $request)
    {
        Position::create($request->all());

        return redirect('/recruitment/positions');
    }

    public function show(Position $position)
    {
        return view('positions.show', [
            'position' => $position
        ]);
    }

    public function edit(Position $position)
    {
        return view('positions.edit', [
            'position' => $position
        ]);
    }

    public function update(Request $request, Position $position)
    {
        $position->update($request->all());

        return redirect('/recruitment/positions');
    }
}
