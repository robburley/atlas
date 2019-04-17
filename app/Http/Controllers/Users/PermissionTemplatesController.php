<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User\PermissionTemplate;
use App\Models\User\PermissionType;
use Illuminate\Http\Request;

class PermissionTemplatesController extends Controller
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
        return view('users.permission-templates.index', [
            'templates' => PermissionTemplate::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.permission-templates.create', [
            'permissionTypes' => PermissionType::with('permissions')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $template = PermissionTemplate::create($request->except('permissions'));

        $request->has('permissions') && $template->permissions()->sync($request->get('permissions'));

        return redirect('/admin/users/permission-templates');
    }

    public function show(PermissionTemplate $template)
    {
        return $template->load('permissions');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PermissionTemplate\ $template
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(PermissionTemplate $template)
    {
        return view('users.permission-templates.edit', [
            'template' => $template,
            'permissionTypes' => PermissionType::with('permissions')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param PermissionTemplate\ $template
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, PermissionTemplate $template)
    {
        $template->update($request->except('permissions'));

        $template->permissions()->sync($request->get('permissions') ?? []);

        return redirect('/admin/users/permission-templates');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PermissionTemplate\ $template
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(PermissionTemplate $template)
    {
        //
    }
}
