<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$router->post('mobile/opportunities/deal-calc/authorise', 'MobileOpportunity\MobileOpportunityApiController@authorise');

$router->get(
    'mobile/opportunities/deal-calc/get-tariffs/{type}',
    'MobileOpportunity\MobileOpportunityApiController@tariffs'
);

$router->get(
    'mobile/opportunities/deal-calc/get-tariff/{tariff}',
    'MobileOpportunity\MobileOpportunityApiController@tariff'
);

$router->post('recruitment/applications', 'Recruitment\ApplicationsApiController@store');

$router->get('offices', 'Offices\OfficesApiController@index');

$router->get('positions/{office}', 'Recruitment\PositionsApiController@index');

$router->get(
    '/customers/{customer}/journey-team-survey/{journey_team_survey}/',
    'JourneyTeamSurvey\JourneyTeamSurveyApiController@show'
);
$router->post('/customers/{customer}/journey-team-survey/', 'JourneyTeamSurvey\JourneyTeamSurveyApiController@store');
$router->post(
    '/customers/{customer}/journey-team-survey/{journey_team_survey}/',
    'JourneyTeamSurvey\JourneyTeamSurveyApiController@update'
);

$router->get('/tariff-match/customer-handsets', 'MobileOpportunity\TariffMatch\CustomerHandsetController@index');
$router->get(
    '/tariff-match/customer-handset-models',
    'MobileOpportunity\TariffMatch\CustomerHandsetModelController@index'
);
$router->get('/tariff-match/networks', 'MobileOpportunity\TariffMatch\NetworksController@index');

$router->post('/tariff-match/update/{step}', 'MobileOpportunity\TariffMatch\TariffMatchController@store');
$router->get('/tariff-match/get/{mobileOpportunity}', 'MobileOpportunity\TariffMatch\TariffMatchController@show');
$router->any(
    '/tariff-match/generate/{mobileOpportunity}',
    'MobileOpportunity\TariffMatch\TariffMatchGenerateController@store'
);

$router->get('/mobile/handsets', 'MobileOpportunity\PhonesApiController@index');
$router->get('/mobile/handsets/{phone}', 'MobileOpportunity\PhonesApiController@show');

$router->post('/mobile/allocation/{mobileOpportunity}', 'MobileOpportunity\AllocationsController@store');
$router->post('/mobile/quality-control/{mobileOpportunity}', 'MobileOpportunity\QualityControlController@store');

$router->post('/its-like-that', 'Admin\LogPrintScreenController@store');
