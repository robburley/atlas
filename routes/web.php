<?php

// Dashboard...
$router->get('/', 'Dashboard\DashboardController@show');

//Search Routes
$router->get('/search', 'Search\SearchController@index');//

// Authentication...
$router->get('/login', 'Auth\LoginController@showLoginForm');
$router->post('/login', 'Auth\LoginController@login');
$router->get('/logout', 'Auth\LoginController@logout');

// Customers routes...
$router->get('/customers/create/{company?}/{telephone?}', 'Customer\CustomerController@create');
$router->post('/customers/create', 'Customer\CustomerController@store');
$router->post('/customers/search', 'Customer\CustomerSearchController@create');
$router->get('/customers/{customer}/edit', 'Customer\CustomerController@edit');
$router->get('/customers/{customer}', 'Customer\CustomerController@show');
$router->post('/customers/{customer}', 'Customer\CustomerController@update');

// Customer contacts routes...
$router->get('/customers/{customer}/contacts/create', 'Customer\CustomerContactController@create');
$router->get('/customers/{customer}/contacts/{contact}/edit', 'Customer\CustomerContactController@edit');
$router->post('/customers/{customer}/contacts/{contact}', 'Customer\CustomerContactController@update');
$router->get('/customers/{customer}/contacts', 'Customer\CustomerContactController@index');
$router->post('/customers/{customer}/contacts', 'Customer\CustomerContactController@store');

// Customer contacts routes...
$router->get('/customers/{customer}/sites/create', 'Customer\CustomerSiteController@create');
$router->get('/customers/{customer}/sites/{customer_site}/edit', 'Customer\CustomerSiteController@edit');
$router->post('/customers/{customer}/sites/{customer_site}', 'Customer\CustomerSiteController@update');
$router->get('/customers/{customer}/sites', 'Customer\CustomerSiteController@index');
$router->post('/customers/{customer}/sites', 'Customer\CustomerSiteController@store');

// Customer files routes...
$router->post('/customers/{customer}/files/{related?}', 'Customer\CustomerFileController@store');
$router->get('/customers/{customer}/files/{customer_file}/delete', 'Customer\CustomerFileController@destroy');
$router->get('/customers/{customer}/files/{customer_file}/{render?}', 'Customer\CustomerFileController@show');

// Customer notes routes...
$router->post('/customers/{customer}/notes', 'Customer\CustomerNoteController@store');
$router->post('/customers/{customer}/notes/{customer_note}', 'Customer\CustomerNoteController@update');

// Customer mobile routes...
$router->get('/customers/{customer}/mobile', 'Customer\CustomerMobileController@index');

//Fulfilment
$router->get('/mobile/fulfilment/awaiting-pac-codes', 'MobileOpportunity\Fulfilment\PacCodeController@index');
$router->get('/mobile/fulfilment/awaiting-bcad', 'MobileOpportunity\Fulfilment\BcadController@index');
$router->get('/mobile/fulfilment/pending-bcad', 'MobileOpportunity\Fulfilment\PendingBcadController@index');
$router->get('/mobile/fulfilment/awaiting-sims', 'MobileOpportunity\Fulfilment\SimsController@index');
$router->get('/mobile/fulfilment/awaiting-unlock', 'MobileOpportunity\Fulfilment\UnlocksController@index');
$router->get('/mobile/fulfilment/pending-unlock', 'MobileOpportunity\Fulfilment\PendingUnlocksController@index');
$router->get('/mobile/fulfilment/awaiting-stock', 'MobileOpportunity\Fulfilment\StockController@index');
$router->get('/mobile/fulfilment/awaiting-imei', 'MobileOpportunity\Fulfilment\AwaitingImeiController@index');
$router->get('/mobile/fulfilment/awaiting-port', 'MobileOpportunity\Fulfilment\PortsController@index');
$router->get('/mobile/fulfilment/awaiting-connection', 'MobileOpportunity\Fulfilment\ConnectionsController@index');
$router->get('/mobile/fulfilment/pending-connection', 'MobileOpportunity\Fulfilment\PendingConnectionsController@index');
$router->get('/mobile/fulfilment/connection-error', 'MobileOpportunity\Fulfilment\ConnectionErrorsController@index');
$router->get('/mobile/fulfilment/connection-deferred', 'MobileOpportunity\Fulfilment\ConnectionDeferredController@index');
$router->get('/mobile/fulfilment/connected', 'MobileOpportunity\Fulfilment\ConnectedController@index');
$router->get('/mobile/fulfilment/tenders', 'MobileOpportunity\Fulfilment\TendersController@index');
$router->get('/mobile/fulfilment/awaiting-bond-payment', 'MobileOpportunity\Fulfilment\BondPaymentController@index');
$router->get('/mobile/fulfilment/tenders/{tender}', 'MobileOpportunity\Fulfilment\TendersController@show');

// Mobile Opportunity queues  opportunities
$router->post('/mobile/reassign-opportunities', 'MobileOpportunity\ReassignController@update');
$router->get('/mobile/pipeline', 'MobileOpportunity\SalesPipelineController@index');
$router->get('/mobile/reassignable', 'MobileOpportunity\ReassignableController@index');
$router->get('/mobile/recoverable', 'MobileOpportunity\RecoverableController@index');
$router->get('/mobile/vettable', 'MobileOpportunity\VettableController@index');
$router->get('/mobile/qualified-leads', 'MobileOpportunity\QualifiedController@index');
$router->get('/mobile/team-awaiting-bill', 'MobileOpportunity\TeamAwaitingBillController@index');
$router->get('/mobile/awaiting-correction', 'MobileOpportunity\CorrectionsController@index');
$router->get('/mobile/connection-log', 'MobileOpportunity\ConnectionLogController@index');
$router->get('/mobile/{mobile_opportunity_status}', 'MobileOpportunity\MobileOpportunityController@index');

// Customer mobile opportunities routes...
$router->get('/customers/{customer}/mobile/opportunities/create', 'MobileOpportunity\MobileOpportunityController@create');
$router->get('/customers/{customer}/mobile/opportunities/{mobileOpportunity}', 'MobileOpportunity\MobileOpportunityController@show');
$router->post('/customers/{customer}/mobile/opportunities', 'MobileOpportunity\MobileOpportunityController@store');
$router->get('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/edit', 'MobileOpportunity\MobileOpportunityController@edit');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}', 'MobileOpportunity\MobileOpportunityController@update');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/callbacks/create', 'MobileOpportunity\CallbackController@store');
$router->get('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/callbacks/{callback}/edit', 'MobileOpportunity\CallbackController@edit');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/callbacks/{callback}/update', 'MobileOpportunity\CallbackController@update');
$router->get('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/callbacks/{callback}/destroy', 'MobileOpportunity\CallbackController@destroy');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/sales-information/create', 'MobileOpportunity\SalesInformationController@store');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/welcome-call/create', 'MobileOpportunity\WelcomeCallsController@store');
$router->get('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/deal-calculator', 'MobileOpportunity\DealCalculatorController@index');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/deal-calculator/create', 'MobileOpportunity\DealCalculatorController@store');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/deal-calculator/{deal_calculator}', 'MobileOpportunity\DealCalculatorController@update');
$router->get('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/deal-calculator/{deal_calculator}/set-active', 'MobileOpportunity\DealCalculatorController@setActive');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/deal-calculator/{deal_calculator}/delete', 'MobileOpportunity\DealCalculatorController@destroy');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/proposal/', 'MobileOpportunity\ProposalController@show');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/purchase-order/', 'MobileOpportunity\PurchaseOrderController@store');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/download-purchase-order/', 'MobileOpportunity\PurchaseOrderController@update');
$router->delete('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/purchase-order/delete', 'MobileOpportunity\PurchaseOrderController@destroy');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/sales-sheet/', 'MobileOpportunity\SalesSheetController@store');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/send-back-to-commercials/', 'MobileOpportunity\MobileOpportunityResetController@update');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/bond-agreement/', 'MobileOpportunity\BondAgreementController@store');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/bond-agreement/download', 'MobileOpportunity\BondAgreementController@update');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/generate-cif-form', 'MobileOpportunity\MobileOpportunityCifController@store');

$router->get('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/pac-codes', 'MobileOpportunity\Fulfilment\PacCodeController@create');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/pac-codes', 'MobileOpportunity\Fulfilment\PacCodeController@store');

$router->get('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/bcad', 'MobileOpportunity\Fulfilment\BcadController@create');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/bcad', 'MobileOpportunity\Fulfilment\BcadController@store');

$router->get('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/sims', 'MobileOpportunity\Fulfilment\SimsController@create');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/sims', 'MobileOpportunity\Fulfilment\SimsController@store');

$router->get('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/unlocks', 'MobileOpportunity\Fulfilment\UnlocksController@create');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/unlocks', 'MobileOpportunity\Fulfilment\UnlocksController@store');

$router->get('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/stock', 'MobileOpportunity\Fulfilment\StockController@create');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/stock', 'MobileOpportunity\Fulfilment\StockController@store');

$router->get('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/imei', 'MobileOpportunity\Fulfilment\AwaitingImeiController@create');

$router->get('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/ports', 'MobileOpportunity\Fulfilment\PortsController@create');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/ports', 'MobileOpportunity\Fulfilment\PortsController@store');

$router->get('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/connection', 'MobileOpportunity\Fulfilment\ConnectionsController@create');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/connection', 'MobileOpportunity\Fulfilment\ConnectionsController@store');

$router->get('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/pending-connection', 'MobileOpportunity\Fulfilment\PendingConnectionsController@create');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/pending-connection', 'MobileOpportunity\Fulfilment\PendingConnectionsController@store');

$router->get('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/connection-error', 'MobileOpportunity\Fulfilment\ConnectionErrorsController@create');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/connection-error', 'MobileOpportunity\Fulfilment\ConnectionErrorsController@store');

$router->get('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/connection-deferred', 'MobileOpportunity\Fulfilment\ConnectionDeferredController@create');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/connection-deferred', 'MobileOpportunity\Fulfilment\ConnectionDeferredController@store');

$router->get('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/connected', 'MobileOpportunity\Fulfilment\ConnectedController@create');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/connected', 'MobileOpportunity\Fulfilment\ConnectedController@store');

$router->get('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/bond-payment-reference', 'MobileOpportunity\Fulfilment\BondPaymentController@create');
$router->post('/customers/{customer}/mobile/opportunities/{mobileOpportunity}/bond-payment-reference', 'MobileOpportunity\Fulfilment\BondPaymentController@store');

// Energy Opportunity queues
$router->get('/energy/quotable', 'EnergyOpportunity\QuotableMeterController@index');
$router->get('/energy/pipeline', 'EnergyOpportunity\SalesPipelineController@index');
$router->get('/energy/reassignable', 'EnergyOpportunity\ReassignableController@index');
$router->get('/energy/recoverable', 'EnergyOpportunity\RecoverableController@index');
$router->get('/energy/{energy_opportunity_status}', 'EnergyOpportunity\EnergyOpportunityController@index');

// Energy Opportunity routes...
$router->get('/customers/{customer}/energy', 'Customer\CustomerEnergyController@index');
$router->get('/customers/{customer}/energy/opportunities/create', 'EnergyOpportunity\EnergyOpportunityController@create');
$router->get('/customers/{customer}/energy/opportunities/{energyOpportunity}', 'EnergyOpportunity\EnergyOpportunityController@show');
$router->post('/customers/{customer}/energy/opportunities', 'EnergyOpportunity\EnergyOpportunityController@store');
$router->get('/customers/{customer}/energy/opportunities/{energyOpportunity}/edit', 'EnergyOpportunity\EnergyOpportunityController@edit');
$router->post('/customers/{customer}/energy/opportunities/{energyOpportunity}', 'EnergyOpportunity\EnergyOpportunityController@update');
$router->post('/customers/{customer}/energy/opportunities/{energyOpportunity}/callbacks/create', 'EnergyOpportunity\CallbackController@store');
$router->get('/customers/{customer}/energy/opportunities/{energyOpportunity}/callbacks/{callback}/edit', 'EnergyOpportunity\CallbackController@edit');
$router->post('/customers/{customer}/energy/opportunities/{energyOpportunity}/callbacks/{callback}/update', 'EnergyOpportunity\CallbackController@update');
$router->get('/customers/{customer}/energy/opportunities/{energyOpportunity}/callbacks/{callback}/destroy', 'EnergyOpportunity\CallbackController@destroy');
$router->post('/customers/{customer}/energy/opportunities/{energyOpportunity}/welcome-call/create', 'EnergyOpportunity\WelcomeCallsController@store');

$router->get('/customers/{customer}/energy/opportunities/{energyOpportunity}/tender', 'EnergyOpportunity\TenderController@show');

$router->get('/customers/{customer}/energy/meters/create', 'EnergyOpportunity\EnergyMeterController@create');
$router->post('/customers/{customer}/energy/meters', 'EnergyOpportunity\EnergyMeterController@store');
$router->get('/customers/{customer}/energy/meters/{energy_meter}/edit', 'EnergyOpportunity\EnergyMeterController@edit');
$router->post('/customers/{customer}/energy/meters/{energy_meter}', 'EnergyOpportunity\EnergyMeterController@update');

//Customer Journey Team Routes
$router->get('/customers/{customer}/journey-team-survey', 'Customer\CustomerJourneyTeamSurveyController@index');
$router->get('/customers/{customer}/journey-team-survey/create', 'JourneyTeamSurvey\JourneyTeamSurveyController@create');
$router->get('/customers/{customer}/journey-team-survey/{journey_team_survey}', 'JourneyTeamSurvey\JourneyTeamSurveyController@edit');
$router->get('/journey-team-survey-files/{location}', 'JourneyTeamSurvey\JourneyTeamSurveyController@image');

// Users routes
$router->get('admin/users/permission-templates', 'Users\PermissionTemplatesController@index')->middleware('isAdmin');
$router->get('admin/users/permission-templates/create', 'Users\PermissionTemplatesController@create')->middleware('isAdmin');
$router->post('admin/users/permission-templates', 'Users\PermissionTemplatesController@store')->middleware('isAdmin');
$router->get('admin/users/permission-templates/{permission_template}/edit', 'Users\PermissionTemplatesController@edit')->middleware('isAdmin');
$router->patch('admin/users/permission-templates/{permission_template}', 'Users\PermissionTemplatesController@update')->middleware('isAdmin');
$router->get('admin/users/permission-templates/{permission_template}', 'Users\PermissionTemplatesController@show')->middleware('permission:create_users_admin');
$router->get('admin/users/permission-templates/{permission_template}/apply', 'Users\PermissionTemplateUserController@edit')->middleware('isAdmin');
$router->post('admin/users/permission-templates/{permission_template}/apply', 'Users\PermissionTemplateUserController@update')->middleware('isAdmin');

// Users routes
$router->get('admin/users', 'Users\UsersController@index')->middleware('permission:create_users_admin');
$router->get('admin/users-inactive', 'Users\UsersController@indexInactive')->middleware('permission:create_users_admin');
$router->get('admin/users/create', 'Users\UsersController@create')->middleware('permission:create_users_admin');
$router->get('admin/users/{user}', 'Users\UsersController@show')->middleware('permission:create_users_admin');
$router->post('admin/users', 'Users\UsersController@store')->middleware('permission:create_users_admin');
$router->get('admin/users/{user}/edit', 'Users\UsersController@edit')->middleware('permission:create_users_admin');
$router->patch('admin/users/{user}', 'Users\UsersController@update')->middleware('permission:create_users_admin');

//Team routes
$router->get('admin/teams', 'Users\TeamsController@index')->middleware('permission:create_teams_admin');
$router->get('admin/teams/create', 'Users\TeamsController@create')->middleware('permission:create_teams_admin');
$router->post('admin/teams', 'Users\TeamsController@store')->middleware('permission:create_teams_admin');
$router->get('admin/teams/{team}/edit', 'Users\TeamsController@edit')->middleware('permission:create_teams_admin');
$router->patch('admin/teams/{team}', 'Users\TeamsController@update')->middleware('permission:create_teams_admin');

$router->post('teams/{team}/users/', 'Users\TeamUserController@store')->middleware('permission:create_teams_admin');
$router->get('teams/{team}/users/{user}/remove', 'Users\TeamUserController@destroy')->middleware('permission:create_teams_admin');

//Notification Routes
$router->get('user/notifications', 'Users\NotificationsController@index');
$router->get('user/notifications/{user_notification}', 'Users\NotificationsController@show');
$router->post('user/notifications/{user_notification}', 'Users\NotificationsController@update');

//Reports -Mobile
$router->get('reports/mobile/closers', 'Reports\Mobile\CloserReportController@index');
$router->get('reports/mobile/qualified-bill', 'Reports\Mobile\QualifiedBillReportController@index');
$router->get('reports/mobile/callbacks', 'Reports\Mobile\CallbackReportController@index');
$router->get('reports/mobile/bills-requirements', 'Reports\Mobile\BillRequirementReportController@index');
$router->get('reports/mobile/appointment-booking', 'Reports\Mobile\AppointmentBookingController@index');
$router->get('reports/mobile/appointments-confirmed', 'Reports\Mobile\AppointmentsConfirmedController@index');
$router->get('reports/mobile/field-sales', 'Reports\Mobile\FieldSalesController@index');
$router->get('reports/mobile/appointments-sat', 'Reports\Mobile\AppointmentsSatController@index');
$router->get('reports/mobile/closer-statistics', 'Reports\Mobile\CloserStatisticsController@index');
$router->get('reports/mobile/closer-statistics/{user}', 'Reports\Mobile\CloserStatisticsController@show');
$router->get('reports/mobile/pitch-close', 'Reports\Mobile\PitchCloseController@index');
$router->get('reports/mobile/agents', 'Reports\Mobile\AgentReportController@index');
$router->get('reports/mobile/blown-appointments', 'Reports\Mobile\BlownAppointmentsReportController@index');
$router->get('reports/mobile/acquisitions', 'Reports\Mobile\AcquisitionReportController@index');
$router->get('reports/mobile/validators', 'Reports\Mobile\ValidatorReportController@index');
$router->get('reports/mobile/fulfilment-overview', 'Reports\Mobile\FulfilmentOverviewController@index');
//Reports - General
$router->get('reports/general/journey-team-survey', 'Reports\General\JourneyTeamController@index');
$router->get('reports/general/calendar-events', 'Reports\General\CalendarEventsController@index');
$router->get('reports/general/branch', 'Reports\General\BranchReportController@index');

//Reports - Fixed Line
$router->get('reports/fixed-line/closers', 'Reports\FixedLine\CloserReportController@index');
$router->get('reports/fixed-line/qualified-bill', 'Reports\FixedLine\QualifiedBillReportController@index');
$router->get('reports/fixed-line/callbacks', 'Reports\FixedLine\CallbackReportController@index');
$router->get('reports/fixed-line/bills-requirements', 'Reports\FixedLine\BillRequirementReportController@index');
$router->get('reports/fixed-line/appointment-booking', 'Reports\FixedLine\AppointmentBookingController@index');
$router->get('reports/fixed-line/field-sales', 'Reports\FixedLine\FieldSalesController@index');
$router->get('reports/fixed-line/appointments-sat', 'Reports\FixedLine\AppointmentsSatController@index');
$router->get('reports/fixed-line/closer-statistics', 'Reports\FixedLine\CloserStatisticsController@index');
$router->get('reports/fixed-line/closer-statistics/{user}', 'Reports\FixedLine\CloserStatisticsController@show');
$router->get('reports/fixed-line/pitch-close', 'Reports\FixedLine\PitchCloseController@index');
$router->get('reports/fixed-line/agents', 'Reports\FixedLine\AgentReportController@index');

//Reports - Finance
$router->get('/reports/finance/cashflow', 'Admin\CashFlowController@index');
$router->post('/reports/finance/cashflow/{cash_flow_item}', 'Admin\CashFlowController@update');
$router->delete('/reports/finance/cashflow/{cash_flow_item}', 'Admin\CashFlowController@destroy');

$router->get('/reports/finance/branch-profitability', 'Reports\Finance\BranchProfitabilityController@index');

//Cashflow
$router->post('/admin/cashflow/item/', 'Admin\CashFlowOneOffController@store');

//Faq Routes
$router->get('faq/questions', 'Faq\QuestionsController@index');
$router->post('faq/questions', 'Faq\QuestionsController@store');

$router->post('appointments/{appointment}', 'Appointments\AppointmentsController@update');

$router->get('toggle-sidebar', 'Users\UsersController@sidebarToggle');

//Application Reports
$router->get('/recruitment/applications', 'Recruitment\ApplicationsController@index');
$router->get('/recruitment/applications/create', 'Recruitment\ApplicationsController@create');
$router->post('/recruitment/applications', 'Recruitment\ApplicationsController@store');
$router->get('/recruitment/applications/{application}/edit', 'Recruitment\ApplicationsController@edit');
$router->get('/recruitment/applications/{application}', 'Recruitment\ApplicationsController@show');
$router->patch('/recruitment/applications/{application}', 'Recruitment\ApplicationsController@update');
$router->get('/recruitment/applications/{application}/files/{application_file}', 'Recruitment\ApplicationFileController@show');

//Position Reports
$router->get('/recruitment/positions', 'Recruitment\PositionsController@index');
$router->get('/recruitment/positions/create', 'Recruitment\PositionsController@create');
$router->post('/recruitment/positions', 'Recruitment\PositionsController@store');
$router->get('/recruitment/positions/{position}/edit', 'Recruitment\PositionsController@edit');
$router->patch('/recruitment/positions/{position}', 'Recruitment\PositionsController@update');

$router->get('calendar', 'Calendar\CalendarController@show');

$router->get('calendar/{user}/events', 'Calendar\EventsController@index');
$router->post('calendar/{user}/events/reassign', 'Calendar\EventsController@reassign');
$router->get('calendar/{user}/events/{event}', 'Calendar\EventsController@show');
$router->post('calendar/{user}/events', 'Calendar\EventsController@store');
$router->post('calendar/{user}/events/{event}', 'Calendar\EventsController@update');
$router->delete('calendar/{user}/events/{event}', 'Calendar\EventsController@destroy');

//Tariff routes
$router->get('/admin/mobile/tariffs', 'MobileOpportunity\TariffsController@index');
$router->get('/admin/mobile/tariffs/create', 'MobileOpportunity\TariffsController@create');
$router->post('/admin/mobile/tariffs', 'MobileOpportunity\TariffsController@store');
$router->post('/admin/mobile/tariffs/{tariff}', 'MobileOpportunity\TariffsController@update');

// Customer mobile routes...
$router->get('/customers/{customer}/fixed-line', 'Customer\CustomerFixedLineController@index');

// Mobile Opportunity queues
$router->post('/fixed-line/reassign-opportunities', 'FixedLineOpportunity\ReassignController@update');
$router->get('/fixed-line/pipeline', 'FixedLineOpportunity\SalesPipelineController@index');
$router->get('/fixed-line/recoverable', 'FixedLineOpportunity\RecoverableController@index');
$router->get('/fixed-line/qualified-leads', 'FixedLineOpportunity\QualifiedController@index');
$router->get('/fixed-line/{fixed_line_opportunity_status}', 'FixedLineOpportunity\FixedLineOpportunityController@index');

// Customer fixed-Line opportunities routes...
$router->get('/customers/{customer}/fixed-line/opportunities/create', 'FixedLineOpportunity\FixedLineOpportunityController@create');
$router->get('/customers/{customer}/fixed-line/opportunities/{fixedLineOpportunity}', 'FixedLineOpportunity\FixedLineOpportunityController@show');
$router->post('/customers/{customer}/fixed-line/opportunities', 'FixedLineOpportunity\FixedLineOpportunityController@store');
$router->get('/customers/{customer}/fixed-line/opportunities/{fixedLineOpportunity}/edit', 'FixedLineOpportunity\FixedLineOpportunityController@edit');
$router->post('/customers/{customer}/fixed-line/opportunities/{fixedLineOpportunity}', 'FixedLineOpportunity\FixedLineOpportunityController@update');
$router->post('/customers/{customer}/fixed-line/opportunities/{fixedLineOpportunity}/callbacks/create', 'FixedLineOpportunity\CallbackController@store');
$router->get('/customers/{customer}/fixed-line/opportunities/{fixedLineOpportunity}/callbacks/{callback}/edit', 'FixedLineOpportunity\CallbackController@edit');
$router->post('/customers/{customer}/fixed-line/opportunities/{fixedLineOpportunity}/callbacks/{callback}/update', 'FixedLineOpportunity\CallbackController@update');
$router->get('/customers/{customer}/fixed-line/opportunities/{fixedLineOpportunity}/callbacks/{callback}/destroy', 'FixedLineOpportunity\CallbackController@destroy');
$router->get('/customers/{customer}/fixed-line/opportunities/{fixedLineOpportunity}/commercials', 'FixedLineOpportunity\CommercialsController@show');
$router->post('/customers/{customer}/fixed-line/opportunities/{fixedLineOpportunity}/commercials', 'FixedLineOpportunity\CommercialsController@store');
$router->post('/customers/{customer}/fixed-line/opportunities/{fixedLineOpportunity}/proposal/', 'FixedLineOpportunity\ProposalController@show');
$router->post('/customers/{customer}/fixed-line/opportunities/{fixedLineOpportunity}/purchase-order/', 'FixedLineOpportunity\PurchaseOrderController@store');
$router->post('/customers/{customer}/fixed-line/opportunities/{fixedLineOpportunity}/download-purchase-order/', 'FixedLineOpportunity\PurchaseOrderController@update');

$router->get('oauth2/adobe-sign', 'Users\AdobeSignController@store');
$router->get('oauth2/adobe-sign/status', 'Users\AdobeSignController@update');
$router->get('oauth2/adobe-sign/update-agreements', 'Users\AdobeSignController@updateAll');

//Phone routes
$router->get('/admin/mobile/phones', 'MobileOpportunity\PhonesController@index');
$router->get('/admin/mobile/phones/create', 'MobileOpportunity\PhonesController@create');
$router->post('/admin/mobile/phones', 'MobileOpportunity\PhonesController@store');
$router->post('/admin/mobile/phones/{tariff}', 'MobileOpportunity\PhonesController@update');

$router->get('/wallboard/nantwich-sales', 'Wallboards\NantwichSalesController@index');
$router->get('/wallboard/sunderland-appointments', 'Wallboards\SunderlandAppointmentsController@index');
$router->get('/wallboard/talk-time', 'Wallboards\TalkTimeController@index');

$router->get('/admin/hr', 'Users\HrProfileController@index');
$router->post('/admin/hr', 'Users\HrProfileController@store');
$router->get('/admin/hr/{hr_profile}', 'Users\HrProfileController@show');
$router->get('/admin/hr/{hr_profile}/edit', 'Users\HrProfileController@edit');
$router->patch('/admin/hr/{hr_profile}', 'Users\HrProfileController@update');

$router->post('/admin/hr/{hr_profile}/files/', 'Users\HrProfileFileController@store');
$router->get('/admin/hr/{hr_profile}/files/{hr_profile_file}/delete', 'Users\HrProfileFileController@destroy');
$router->get('/admin/hr/{hr_profile}/files/{hr_profile_file}/', 'Users\HrProfileFileController@show');

$router->get('/tenders/mobile/{tender_invitation}', 'Tenders\Mobile\TenderInvitationController@show');
$router->post('/tenders/mobile/{tender_invitation}', 'Tenders\Mobile\TenderInvitationController@store');

$router->post('/nav/figures', 'Nav\NavFigureController@index');
// $router->get('test', 'Testing\TestingController@index');
