<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\Application;
use Illuminate\Http\Request;

class ApplicationsController extends Controller
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
        return view('applications.index', [
            'applications' => Application::orderBy('created_at', 'desc')->paginate(50)
        ]);
    }

    public function create()
    {
        return view('applications.create');
    }

    public function store(Request $request)
    {
        Application::create($request->all());

        return redirect('/recruitment/applications');
    }

    public function show(Application $application)
    {
        return view('applications.show', [
            'application' => $application
        ]);
    }

    public function edit(Application $application)
    {
        return view('applications.edit', [
            'application' => $application
        ]);
    }

    public function update(Request $request, Application $application)
    {
        $application->update($request->all());

        return redirect('/recruitment/applications');
    }
}
