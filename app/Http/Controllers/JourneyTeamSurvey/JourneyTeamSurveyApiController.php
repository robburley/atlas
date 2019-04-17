<?php

namespace App\Http\Controllers\JourneyTeamSurvey;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\JourneyTeamSurvey\JourneyTeamSurvey;
use Illuminate\Http\Request;

class JourneyTeamSurveyApiController extends Controller
{
    public function show(Customer $customer, JourneyTeamSurvey $survey)
    {
        return $survey->toJson();
    }

    public function store(Request $request, Customer $customer)
    {
        $filtered = collect($request->except(['user_id']))->filter();

        if (!$filtered->isEmpty()) {
            $survey = $customer->journeyTeamSurveys()->create($request->all());

            $survey = JourneyTeamSurvey::find($survey->id);

            return $survey->toJson();
        }

        return response(['error' => 'empty'], 401);
    }

    public function update(Request $request, Customer $customer, JourneyTeamSurvey $survey)
    {
        $survey->update($request->all());

        return $survey->toJson();
    }
}
