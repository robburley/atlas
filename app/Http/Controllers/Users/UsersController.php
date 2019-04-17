<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserRequest;
use App\Models\User\PermissionType;
use App\Models\User\User;

class UsersController extends Controller
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
        return view('users.index', [
            'users' => User::active()->ordered()->filtered()->paginate(25),
            'active' => 1
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexInactive()
    {
        return view('users.index', [
            'users' => User::inactive()->ordered()->filtered()->paginate(25),
            'active' => 0
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create', [
            'permissionTypes' => PermissionType::with('permissions')->orderBy('order', 'asc')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->except('permissions'));

        $request->has('permissions') && $user->permissions()->sync($request->get('permissions'));

        return redirect('/admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'permissionTypes' => PermissionType::with('permissions')->orderBy('order', 'asc')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->except('permissions'));

        $user->permissions()->sync($request->get('permissions') ?? []);

        return redirect('/admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(User $user)
    {
        //
    }

    public function sidebarToggle()
    {
        if($user = auth()->user()){
            $user->update([
                'sidebar' => $user->sidebar <> 1
            ]);
        }
    }
}
