<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User\PermissionTemplate;
use App\Models\User\PermissionType;
use App\Models\User\User;
use Illuminate\Http\Request;

class PermissionTemplateUserController extends Controller
{
    /**
     * Create a new dashboard controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('isAdmin');
    }



    public function edit(PermissionTemplate $template)
    {
        return view('users.permission-templates.apply', [
            'template' => $template,
            'users' => User::active()->ordered()->filtered()->get()
        ]);
    }

    public function update(Request $request, PermissionTemplate $template)
    {
        foreach($request->get('users') as $user) {
            $current = User::find($user);

            $current && $current->permissions()->sync($template->permissions()->pluck('permissions.id') ?? []);
        }

        alert()->success('Permissions applied to ' . count($request->get('users')) . ' ' . str_plural('user', count($request->get('users'))));

        return redirect('/admin/users/permission-templates');
    }
}
