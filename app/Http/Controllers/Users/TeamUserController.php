<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User\Team;
use App\Models\User\User;
use Illuminate\Http\Request;

class TeamUserController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Team $team
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Team $team)
    {

        $team->users()->attach([$request->user_id => ['moderator' => $request->moderator]]);

        return redirect('/admin/teams/' . $team->id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Team|User $team
     * @param User $user
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Team $team, User $user)
    {
        $team->users()->detach([$user->id]);

        return redirect('/admin/teams/' . $team->id . '/edit');
    }
}
