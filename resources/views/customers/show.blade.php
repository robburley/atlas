@extends('customers.layout')

@section('title')
{{ $customer->company_name }} &middot; Atlas
@endsection

@section('page-title')
    {{ $customer->company_name }}
@endsection

@section('page-description')
    Win Win existing customer
@endsection

@section('subcontent')
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="xe-widget xe-counter xe-counter-info border-top-info">
                <div class="xe-icon">
                    <i class="fa fa-mobile"></i>
                </div>

                <div class="xe-label">
                    <strong class="num">{{ $customer->mobileOpportunities->count() }}</strong>
                    <span>
                        <a href="/customers/{{ $customer->id }}/mobile" class="btn btn-info btn-block text-left">
                            Mobile
                        </a>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="xe-widget xe-counter xe-counter-warning border-top-warning ">
                <div class="xe-icon">
                    <i class="fa fa-flash"></i>
                </div>

                <div class="xe-label">
                    <strong class="num">
                        {{ $customer->energyOpportunities->count() }}
                    </strong>

                    <span>
                        <a href="/customers/{{ $customer->id }}/energy" class="btn btn-warning btn-block text-left">
                            Energy
                        </a>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="xe-widget xe-counter xe-counter-purple border-top-purple ">
                <div class="xe-icon">
                    <i class="fa fa-file-o"></i>
                </div>

                <div class="xe-label">
                    <strong class="num">
                        {{ $customer->journeyTeamSurveys->count() }}
                    </strong>

                    <span>
                        <a href="/customers/{{ $customer->id }}/journey-team-survey"
                           class="btn btn-purple btn-block text-left">
                            Journey Surveys
                        </a>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="xe-widget xe-counter xe-counter-danger border-top-danger ">
                <div class="xe-icon">
                    <i class="fa fa-phone"></i>
                </div>

                <div class="xe-label">
                    <strong class="num">
                        {{ $customer->fixedLineOpportunities->count() }}
                    </strong>

                    <span>
                        <a href="/customers/{{ $customer->id }}/fixed-line" class="btn btn-danger btn-block text-left">
                            Fixed Line
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default border-top-purple">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Contacts
                    </h3>

                    <a href="/customers/{{ $customer->id }}/contacts/create"
                       class="btn btn-success btn-icon btn-icon-standalone pull-right">
                        <i class="fa fa-fw fa-plus"></i>
                        <span>Add</span>
                    </a>
                </div>
                <div class="panel-body">
                    <table class="table middle-align">
                        <thead>
                        <tr>
                            <th>Contact</th>
                            <th>Site</th>
                            <th>Role</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($customer->contacts as $contact)
                            <tr>
                                <td class="user-name">
                                    <a href="#" class="name">
                                        {{ $contact->title }}
                                        {{ $contact->forename }}
                                        {{ $contact->surname }}
                                    </a>

                                    <span>
                                        {{ $contact->job_title }}
                                    </span>
                                </td>

                                <td>
                                    {{ $contact->site->name or 'None' }}
                                </td>

                                <td>
                                    {!! $contact->decision_maker ? 'Decision Maker, <br>' : null !!}
                                    {!! $contact->finance_contact ? 'Finance Contact, <br>' : null !!}
                                    {!! $contact->technical_contact ? 'Technical Contact' : null !!}
                                </td>

                                <td class="text-right">
                                    <a href="javascript:;"
                                       onclick="jQuery('#contact-{{ $contact->id }}').modal('show', {backdrop: 'static'})"
                                       class="btn btn-sm btn-white btn-icon">
                                        <i class="fa fa-fw fa-search"></i>
                                        <span>View</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default border-top-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Sites
                    </h3>

                    <a href="/customers/{{ $customer->id }}/sites/create"
                       class="btn btn-success btn-icon btn-icon-standalone pull-right">
                        <i class="fa fa-fw fa-plus"></i>
                        <span>Add</span>
                    </a>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Site</th>
                            <th>Address</th>
                            <th>Head Office</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($customer->sites as $site)
                            <tr>

                                <td class="user-name">
                                    {{ $site->name }}
                                </td>

                                <td class="user-name">
                                    {{ $site->address1 }},
                                    {{ $site->address2 }},
                                    {{ $site->address3 }},
                                    {{ $site->town }},
                                    {{ $site->county }},
                                    {{ $site->postcode }},
                                </td>

                                <td class="user-name">
                                    {{ $site->head_office ? 'Yes' : 'No' }}
                                </td>

                                <td class="text-right">

                                    <a href="/customers/{{ $customer->id }}/sites/{{ $site->id }}/edit"
                                       class="btn btn-sm btn-white btn-icon">
                                        <i class="fa fa-fw fa-edit"></i>
                                        <span>Edit</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <section class="profile-env mailbox-env">
                <ul class="cbp_tmtimeline">
                    <li>
                        <time class="cbp_tmtime">
                            <span class="hidden">{{ FormPopulator::now() }}</span>
                            <span class="large">Now</span>
                        </time>

                        <div class="cbp_tmicon timeline-bg-gray">
                            <i class="fa fa-fw fa-comment-o"></i>
                        </div>

                        <div class="cbp_tmlabel p-b-0 ">
                            {!! Form::open(['action' => ['Customer\CustomerNoteController@store', $customer->id], 'role' => 'form', 'class' => 'form-horizontal']) !!}
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::textarea('body', null, ['class' => 'form-control input-lg autogrow', 'rows' => 3, 'required', 'autocomplete' => 'off']) !!}
                                    {!! $errors->first('body', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                </div>
                            </div>

                            <div class="row col-margin">
                                <div class="col-sm-3">
                                    {!! Form::select('customer_note_type_id', FormPopulator::customerNoteTypes(), null, ['class' => 'form-control select2', 'placeholder' => 'Choose a note type...']) !!}
                                    {!! $errors->first('customer_note_type_id', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                </div>

                                <div class="col-sm-3">
                                    {!! Form::select('notify_user_id', FormPopulator::users(), null, ['class' => 'form-control select2', 'placeholder' => 'Notify a colleague?']) !!}
                                </div>

                                <div class="col-sm-3">
                                    {!! Form::hidden('notable_type', 'mobileOpportunity') !!}
                                    {!! Form::select('notable_id', $customer->mobileOpportunities()->pluck('id', 'id'), null, ['class' => 'form-control select2', 'placeholder' => 'Opportunity ID']) !!}
                                </div>

                                <div class="col-sm-3 text-right">
                                    <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                                        <i class="fa fa-fw fa-plus"></i>
                                        <span>Add</span>
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </li>

                    @foreach($customer->activeNotes as $note)
                        <li>
                            <time class="cbp_tmtime" datetime="{{ $note->created_at }}">
                                <span>{{ $note->created_at->format('H:i') }}</span>
                                <span>{{ $note->created_at->format('d/m/Y') }}</span>
                            </time>

                            <div class="cbp_tmicon timeline-bg-{{ $note->type->colour }}">
                                <i class="fa-{{ $note->type->icon }}"></i>
                            </div>

                            <div class="cbp_tmlabel">
                                @if(auth()->user()->isAdmin())
                                    {!! Form::open(['action' => ['Customer\CustomerNoteController@update', $customer, $note], 'method' => 'post']) !!}
                                    {!! Form::hidden('active', 0) !!}

                                    <button type="submit" class="btn btn-danger btn-xs pull-right">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    {!! Form::close() !!}

                                    <a href="javascript:;"
                                       onclick="jQuery('#edit-note-{{ $note->id }}').modal('show', {backdrop: 'fade'})"
                                       class="btn btn-white btn-xs pull-right"
                                    >
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                @endif

                                <h2>{{ $note->user->name ??  'System' }} <span>{{ $note->type->past_tense }}</span></h2>
                                <p>{{ $note->body }}</p>
                            </div>
                        </li>

                        @if(auth()->user()->isAdmin())
                            @component('interface.components.modal')
                                @slot('modalId', 'edit-note-' . $note->id)
                                @slot('modelBorderClass', 'border-top-warning')
                                @slot('modalTitle', 'Edit Note')
                                @slot('modalBody')
                                    {!! Form::open(['action' => ['Customer\CustomerNoteController@update', $customer, $note], 'method' => 'post']) !!}
                                    <div class="row">
                                        <div class="col-sm-12">
                                            {!! Form::textarea('body', $note->body, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success pull-right">
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                @endslot
                            @endcomponent
                        @endif
                    @endforeach
                </ul>
            </section>
        </div>

        <div class="col-md-4">
            @if($customer->otherServices->count() > 0)
                <div class="panel panel-default border-top-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Other Service Info (Field Sales)
                        </h3>
                    </div>

                    <div class="panel-body">
                        @foreach($customer->otherServices as $service)
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4>Mobile</h4>
                                    <p>Status: {{ $service->mobile_status }}</p>
                                    <p>Description: {{ $service->mobile_description }}</p>
                                    <p>Revisit
                                        Date: {{ $service->mobile_rearranged_at ? $service->mobile_rearranged_at->format('d/m/Y H:i') : 'Not Set' }}</p>

                                    <hr>

                                    <h4>Fixed Line</h4>
                                    <p>Status: {{ $service->fixed_line_status }}</p>
                                    <p>Description: {{ $service->fixed_line_description }}</p>
                                    <p>Revisit
                                        Date: {{ $service->fixed_line_rearranged_at ? $service->fixed_line_rearranged_at->format('d/m/Y H:i') : 'Not Set' }}</p>

                                    <hr>

                                    <h4>Mobile</h4>
                                    <p>Status: {{ $service->broadband_status }}</p>
                                    <p>Description: {{ $service->broadband_description }}</p>
                                    <p>Revisit
                                        Date: {{ $service->broadband_rearranged_at ? $service->broadband_rearranged_at->format('d/m/Y H:i') : 'Not Set' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    @foreach ($customer->contacts as $contact)
        <div class="modal fade" id="contact-{{ $contact->id }}">
            <div class="modal-dialog border-top-success">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Contact Card</h4>
                    </div>

                    <div class="modal-body">
                        <section class="profile-env m-b-0">
                            <div class="user-info-sidebar">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <span class="user-img">
                                            <img src="/assets/images/user-4.png" alt="user-img"
                                                 class="img-cirlce img-responsive img-thumbnail">
                                        </span>

                                        <span class="user-name">
                                            {{ $contact->title }}
                                            {{ $contact->forename }}
                                            {{ $contact->surname }}
                                        </span>

                                        <span class="user-title">{{ $contact->job_title }}</span>
                                    </div>

                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>Landline Number</p>
                                            </div>

                                            <div class="col-sm-6">
                                                <p>{{ $contact->landline_number }}</p>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>Mobile Number</p>
                                            </div>

                                            <div class="col-sm-6">
                                                <p>{{ $contact->mobile_number }}</p>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>Email Address</p>
                                            </div>

                                            <div class="col-sm-6">
                                                <p>{{ $contact->email_address }}</p>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>Description</p>
                                            </div>

                                            <div class="col-sm-6">
                                                <p>{{ $contact->description }}</p>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>Site</p>
                                            </div>

                                            <div class="col-sm-6">
                                                <p>{{ $contact->site->name or 'None' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="modal-footer">
                        <a href="/customers/{{ $customer->id }}/contacts/{{ $contact->id}}/edit"
                           class="btn btn-primary">Edit</a>
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    @foreach ($customer->sites as $site)
        <div class="modal fade" id="site-{{ $site->id }}">
            <div class="modal-dialog border-top-success">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Site Card</h4>
                    </div>

                    <div class="modal-body">
                        <section class="profile-env m-b-0">
                            <div class="user-info-sidebar">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <span class="user-img">
                                            <img src="/assets/images/user-4.png" alt="user-img"
                                                 class="img-cirlce img-responsive img-thumbnail">
                                        </span>

                                        <span class="user-name">
                                            {{ $site->title }}
                                            {{ $site->forename }}
                                            {{ $site->surname }}
                                        </span>

                                        <span class="user-title">{{ $site->job_title }}</span>
                                    </div>

                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>Landline Number</p>
                                            </div>

                                            <div class="col-sm-6">
                                                <p>{{ $site->landline_number }}</p>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>Mobile Number</p>
                                            </div>

                                            <div class="col-sm-6">
                                                <p>{{ $site->mobile_number }}</p>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>Email Address</p>
                                            </div>

                                            <div class="col-sm-6">
                                                <p>{{ $site->email_address }}</p>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>Description</p>
                                            </div>

                                            <div class="col-sm-6">
                                                <p>{{ $site->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="modal-footer">
                        <a href="/customers/{{ $customer->id }}/sites/{{ $site->id}}/edit"
                           class="btn btn-primary">Edit</a>
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
