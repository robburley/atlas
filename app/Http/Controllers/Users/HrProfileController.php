<?php

namespace App\Http\Controllers\Users;


use App\Http\Controllers\Controller;
use App\Models\User\HrProfile;
use App\Models\User\User;

class HrProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:manage_hr');
    }

    public function index()
    {
        return view('hr.index', [
           'profiles' => HrProfile::orderBy('start_date', 'desc')->paginate(50)
        ]);
    }

    public function store()
    {
        $user = User::find(request()->user_id);

        if($user) {
            $profile = $user->hrProfile()->create([
                'work_email' => $user->email
            ]);

            return redirect("/admin/hr/$profile->id/edit");
        }

        alert()->error('Cannot find User');

        return redirect()->back();
    }

    public function show(HrProfile $profile)
    {
        return view('hr.show', [
            'profile' => $profile
        ]);
    }

    public function edit(HrProfile $profile)
    {
        return view('hr.edit', [
            'profile' => $profile
        ]);
    }

    public function update(HrProfile $profile)
    {
        $this->validate(request(), [
            'title' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        $profile->update(request()->all());

        return redirect("/admin/hr/$profile->id");
    }
}
