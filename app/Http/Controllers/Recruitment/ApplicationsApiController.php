<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationFormRequest;
use App\Models\Recruitment\Application;

class ApplicationsApiController extends Controller
{
    /*
     * Endpoint for receiving applications and passing the created object back
     */
    public function store(ApplicationFormRequest $request)
    {
        $application = Application::create($request->all());

        return $application;
    }

}
