<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerFile;
use App\Models\Recruitment\Application;
use App\Models\Recruitment\ApplicationFile;
use Illuminate\Support\Facades\Storage;

class ApplicationFileController extends Controller
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
     * Display the specified resource.
     *
     * @param Application $application
     * @param ApplicationFile|CustomerFile $file
     * @return \Illuminate\Http\Response
     * @internal param Customer $customer
     * @internal param int $id
     */
    public function show(Application $application, ApplicationFile $file)
    {
        if(!Storage::exists($file->location)) {
            abort('404');
        }

        return Response()->download(storage_path('app') . '/' . $file->location);
    }


}
