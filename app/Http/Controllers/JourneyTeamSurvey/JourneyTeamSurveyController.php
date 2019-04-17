<?php

namespace App\Http\Controllers\JourneyTeamSurvey;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\JourneyTeamSurvey\JourneyTeamSurvey;
use Illuminate\Http\Request;

class JourneyTeamSurveyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Customer $customer)
    {
        return view('journey-team-survey.create', [
            'customer' => $customer,
        ]);
    }

    public function edit(Customer $customer, JourneyTeamSurvey $survey)
    {
        return view('journey-team-survey.create', [
            'customer' => $customer,
            'survey' => $survey
        ]);
    }

    public function image($location)
    {
        return Response()->download(storage_path('app') . '/' . str_replace('~', '/', $location));
    }
}
