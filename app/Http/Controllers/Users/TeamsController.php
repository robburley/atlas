<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\TeamRequest;
use App\Models\User\Team;
use App\Models\User\User;

class TeamsController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('teams.index', [
            'teams' => Team::paginate(25)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamRequest $request)
    {
        Team::create($request->all());

        return redirect('/admin/teams');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Team $team
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Team $team)
    {
        return view('teams.edit', [
            'team' => $team,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $team
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(TeamRequest $request, Team $team)
    {
        $team->update($request->all());

        return redirect('/admin/teams');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $team
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Team $team)
    {
        //
    }
}
