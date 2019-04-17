@extends('customers.layout')

@section('title')
    Energy Opportunity &middot; {{ $customer->company_name }} &middot; Atlas
@endsection

@section('styles')
    <style>
        .ui-datepicker {
            z-index: 9999 !important;
        }
    </style>
@endsection

@section('page-title')
    {{ $customer->company_name }}
@endsection

@section('page-description')
    Energy opportunity
@endsection

@section('subcontent')
    <div class="row">
        <div class="col-sm-4">
            <h3 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-energy"></i>
                {{ $opportunity->activeAssigned->first() ? $opportunity->activeAssigned->first()->name : '' }}

                @if($opportunity->qualified == 1)
                    <i class="fa fa-fw fa-thumbs-up text-success" data-toggle="tooltip" data-placement="top"
                       title="{{ $opportunity->qualified_at ? $opportunity->qualified_at->format('d/m/Y H:i') : 'NA' }}"></i>
                @elseif(!is_null($opportunity->qualified) && $opportunity->qualified == 0)
                    <i class="fa fa-fw fa-thumbs-down text-danger" data-toggle="tooltip" data-placement="top"
                       title="{{ $opportunity->qualified_at ? $opportunity->qualified_at->format('d/m/Y H:i') : 'NA' }}"></i>
                @endif

            </h3>
        </div>
        <div class="col-sm-8 text-right m-b-20">
            @if($opportunity->status->blown == 1 && $opportunity->status->unrecoverable == 0 && auth()->user()->hasPermission('recoverable_energy'))
                <a href="javascript:;" onclick="jQuery('#save-lead').modal('show', {backdrop: 'fade'});"
                   class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
                    <i class="fa fa-refresh"></i>
                    <span>Recover</span>
                </a>
            @endif

            @if($opportunity->status->id != 6 && $opportunity->status->id != 5)
                <a href="javascript:;" onclick="jQuery('#blow-lead').modal('show', {backdrop: 'fade'});"
                   class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
                    <i class="fa fa-times"></i>
                    <span>Blown</span>
                </a>
            @endif

            @if(auth()->user()->hasPermission('awaiting_assignment_energy') && $opportunity->status->id <= 10 && count($opportunity->activeAssigned) > 0 )
                <a href="javascript:;" onclick="jQuery('#reassign-lead').modal('show', {backdrop: 'fade'});"
                   class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
                    <i class="fa fa-user"></i>
                    <span>Reassign</span>
                </a>
            @endif


            @if( auth()->user()->hasPermission('welcome_call_energy'))
                <a href="javascript:;" onclick="jQuery('#welcome-call').modal('show', {backdrop: 'fade'});"
                   class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
                    <i class="fa fa-phone"></i>
                    <span>Welcome Call</span>
                </a>
            @endif

            @if($opportunity->status->id != 4)
                <a href="javascript:;" onclick="jQuery('#set-callback').modal('show', {backdrop: 'fade'});"
                   class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
                    <i class="fa fa-phone"></i>
                    <span>Set Callback</span>
                </a>
            @endif

            {{--@if(auth()->user()->hasPermission('edit_energy') && $opportunity->status->id > 6 &&$opportunity->status->id < 11)--}}
            {{--<a href="javascript:;" onclick="jQuery('#edit-gp').modal('show', {backdrop: 'fade'});"--}}
            {{--class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">--}}
            {{--<i class="fa fa-gbp"></i>--}}
            {{--<span>Edit GP</span>--}}
            {{--</a>--}}
            {{--@endif--}}

            @if(auth()->user()->hasPermission('edit_energy') && ($opportunity->status->id != 11 && $opportunity->status->id != 12) )
                <a href="/customers/{{ $customer->id }}/energy/opportunities/{{ $opportunity->id }}/edit"
                   class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
                    <i class="fa fa-pencil"></i>
                    <span>Edit</span>
                </a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <div class="panel panel-default m-h-475">
                <div class="panel-heading">
                    <h3 class="panel-title">Status</h3>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            @foreach($statuses as $status => $name)
                                {!! $opportunity->getStatusText($status, $name) !!}
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default m-h-475">
                <div class="panel-heading">
                    <h3 class="panel-title">Actions</h3>

                    @if($opportunity->energy_opportunity_status_id > 7)
                        <a href="javascript:" onclick="jQuery('#add-meter').modal('show', {backdrop: 'fade'});"
                           class="btn btn-xs btn-success btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0 pull-right">
                            <i class="fa fa-upload"></i>
                            <span>Add New Meter</span>
                        </a>

                        <a href="javascript:" onclick="jQuery('#add-existing-meter').modal('show', {backdrop: 'fade'});"
                           class="btn btn-xs btn-success btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0 pull-right m-r-10">
                            <i class="fa fa-upload"></i>
                            <span>Add Existing Meter</span>
                        </a>
                    @endif
                    {{--@if(count($opportunity->meters) > 0)--}}
                    {{--<a href="/customers/{{ $customer->id }}/energy/opportunities/{{ $opportunity->id }}/tender" class="btn btn-xs btn-success pull-right m-r-10" target="_blank">--}}
                    {{--Generate Tender--}}
                    {{--</a>--}}
                    {{--@endif--}}
                </div>

                <div class="panel-body">
                    @if(PermissionHelper::energyShowPermissions($opportunity))
                        @include('energy.opportunities.actions.' . $opportunity->status->slug)
                    @elseif($opportunity->status->blown == 1)
                        @include('energy.opportunities.actions.blown')
                    @else
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>
                                    This opportunity is currently
                                    <span class="text-{{ $opportunity->status->colour }}">{{ $opportunity->status->name  }} </span>
                                    Please check back soon for an update
                                </h4>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default m-h-192">
                <div class="panel-heading">
                    <h3 class="panel-title">Point Of Contact</h3>
                </div>
                <div class="panel-body text-center">
                    @foreach($opportunity->customer->contacts()->where('decision_maker', 1)->get() as $contact)
                        {{  $contact->title  . ' ' . $contact->forename  . ' ' . $contact->surname }}<br>
                        {{  $contact->energy_number }}<br>
                        {{  $contact->email_address }}<br>
                        <hr>
                    @endforeach
                </div>
            </div>
            <div class="panel panel-default m-h-280">
                <div class="panel-heading">
                    <h3 class="panel-title">Files</h3>
                    @if(auth()->user()->hasPermission('upload_files_energy') && $opportunity->status->id <= 11 )
                        <a href="javascript:" onclick="jQuery('#upload-file').modal('show', {backdrop: 'fade'});"
                           class="btn btn-xs btn-success pull-right">
                            <span>Upload File</span>
                        </a>
                    @endif
                </div>
                <div class="panel-body text-center">
                    @foreach($opportunity->files as $file)
                        <a href=" {{ action('Customer\CustomerFileController@show', [$customer, $file])  }}"
                           class="btn btn-info">
                            {{ $file->type->name }}
                        </a>
                        @if(auth()->user()->hasPermission('delete_files_energy'))
                            <a href=" {{ action('Customer\CustomerFileController@destroy', [$customer, $file])  }}"
                               class="btn btn-danger">
                                X
                            </a>
                        @endif

                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-6">
                    <div class="xe-widget xe-counter xe-counter-info">
                        <div class="xe-icon">
                            <i class="fa fa-home"></i>
                        </div>

                        <div class="xe-label">
                            <strong class="num">{{ $opportunity->number_of_sites }}</strong>
                            <span>Number of Sites</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="xe-widget xe-counter xe-counter-success">
                        <div class="xe-icon">
                            <i class="fa fa-gbp"></i>
                        </div>

                        <div class="xe-label">
                            <strong class="num">&pound;{{ $opportunity->monthly_spend }}</strong>
                            <span>Monthly spend</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Info</h3>
                        </div>

                        <div class="panel-body">
                            <p>
                                looking for prices: {{ $opportunity->looking_for_prices }} <br>
                                direct or broker: {{ $opportunity->direct_or_broker }} <br>
                                typical contact length: {{ $opportunity->typical_contact_length }} <br>
                                supplier to avoid: {{ $opportunity->supplier_to_avoid }} <br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row">


                @if($opportunity->energy_procurement)
                    <div class="col-sm-6">
                        <div class="xe-widget xe-counter xe-counter-primary">
                            <div class="xe-icon">
                                <i class="fa fa-flash"></i>
                            </div>

                            <div class="xe-label">
                                <span>Energy Procurement</span>
                            </div>
                        </div>
                    </div>
                @endif

                @if($opportunity->price_comparison_spend)
                    <div class="col-sm-6">
                        <div class="xe-widget xe-counter xe-counter-success">
                            <div class="xe-icon">
                                <i class="fa fa-flash"></i>
                            </div>

                            <div class="xe-label">
                                <span>Price Comparison</span>
                            </div>
                        </div>
                    </div>
                @endif

                @if($opportunity->kva_mapping_report)
                    <div class="col-sm-6">
                        <div class="xe-widget xe-counter xe-counter-info">
                            <div class="xe-icon">
                                <i class="fa fa-flash"></i>
                            </div>

                            <div class="xe-label">
                                <span>KVA Mapping Report</span>
                            </div>
                        </div>
                    </div>
                @endif

                @if($opportunity->contract_validation)
                    <div class="col-sm-6">
                        <div class="xe-widget xe-counter xe-counter-warning">
                            <div class="xe-icon">
                                <i class="fa fa-flash"></i>
                            </div>

                            <div class="xe-label">
                                <span>Contract Validation</span>
                            </div>
                        </div>
                    </div>
                @endif


                <div class="col-sm-6">
                    <div class="xe-widget xe-counter xe-counter-danger">
                        <div class="xe-icon">
                            <i class="fa fa-flash"></i>
                        </div>

                        <div class="xe-label">
                            <span>Energy Audit</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default m-h-215">
                <div class="panel-heading">
                    <h3 class="panel-title">Callbacks</h3>
                </div>

                <div class="panel-body">
                    @foreach($opportunity->callbacks()->orderBy('time', 'desc')->get() as $callback)
                        <p>
                            @if($callback->isComplete())
                                <s>
                                    @endif
                                    {{ $callback->assignedUser->name or 'A User' }}
                                    - {{ $callback->time->format('d/m/Y H:i') }}
                                    @if($callback->isComplete())
                                </s>
                            @else
                                <span class="pull-right">
                                <a href="/customers/{{ $callback->opportunity->customer->id }}/energy/opportunities/{{ $callback->opportunity->id }}/callbacks/{{ $callback->id }}/edit">
                                    <i class="fa fa-clock-o text-info" title="Rearrange"></i>
                                </a>
                                <a href="/customers/{{ $callback->opportunity->customer->id }}/energy/opportunities/{{ $callback->opportunity->id }}/callbacks/{{ $callback->id }}/destroy">
                                    <i class="fa fa-check text-success" title="Complete"></i>
                                </a>
                            </span>
                            @endif
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default m-h-215">
                <div class="panel-heading">
                    <h3 class="panel-title">Notes</h3>
                </div>

                <div class="panel-body">
                    {{ $opportunity->notes }}
                </div>
            </div>
        </div>
        @if($welcomeCall = $opportunity->welcomeCall)
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Welcome Call</h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <strong>User: </strong>
                                {{ $welcomeCall->user->name or 'None Set' }}
                            </div>
                            <div class="col-sm-4">
                                <strong>Created: </strong>
                                {{ $welcomeCall->created_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="col-sm-4">
                                <strong>Updated: </strong>
                                {{ $welcomeCall->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <strong>Phone Number: </strong>
                                {{ $welcomeCall->telephone }}
                            </div>
                            <div class="col-sm-8">
                                <strong>Notes: </strong>
                                {{ $welcomeCall->notes }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>


    <div class="row">

        <div class="col-sm-12">
            <div class="panel panel-default m-h-215">
                <div class="panel-heading">
                    <h3 class="panel-title">Meters</h3>
                </div>

                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Site</th>
                            <th>Meter Type</th>
                            <th>Meter Number</th>
                            <th>Usage</th>
                            <th>Contract End Date</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($opportunity->meters as $meter)
                            <tr>
                                <td class="v-mid">

                                    {!! Form::open(['action' => ['EnergyOpportunity\EnergyOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
                                    {{ Form::hidden('detach_meter', $meter->id) }}

                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-fw fa-close"></i>
                                    </button>
                                    {!! Form::close() !!}
                                </td>
                                <td class="v-mid">
                                    {{ $meter->site->name }}
                                </td>
                                <td class="v-mid">
                                    {{ $meter->type }}
                                </td>
                                <td class="v-mid">
                                    Top: {{ $meter->top_line }} <br>
                                    Bottom: {{ $meter->bottom_line }}
                                </td>
                                <td class="v-mid">
                                    <i class="fa fa-fw fa-sort-numeric-asc" data-toggle="tooltip" data-placement="top"
                                       title="Quantity"></i> {{ $meter->quantity }} <br>
                                    <i class="fa fa-fw fa-sun-o" data-toggle="tooltip" data-placement="top"
                                       title="Day Rate"></i> {{ $meter->day_rate }} <br>
                                    <i class="fa fa-fw fa-moon-o" data-toggle="tooltip" data-placement="top"
                                       title="Night Rate"></i> {{ $meter->night_rate }} <br>
                                    <i class="fa fa-fw fa-gbp" data-toggle="tooltip" data-placement="top"
                                       title="Standing Charge"></i> {{ $meter->current_standing_charge }} <br>
                                </td>
                                <td class="v-mid">
                                    {{ $meter->contract_end_date->format('d/m/Y') }}
                                </td>
                                <td class="v-mid">
                                    <a href="/customers/{{ $customer->id }}/energy/meters/{{ $meter->id }}/edit"
                                       class="btn btn-xs btn-white btn-icon">
                                        <i class="fa fa-fw fa-edit"></i>
                                        <span>Edit</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Please add a meter</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
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

                        <div class="cbp_tmlabel p-b-0">
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
                                    {!! Form::select('notify_user_id', FormPopulator::users(), null, ['class' => 'form-control select2-search', 'placeholder' => 'Notify a colleague?']) !!}
                                </div>

                                <div class="col-sm-3">
                                    {!! Form::hidden('notable_type', 'energyOpportunity') !!}
                                    {!! Form::hidden('notable_id', $opportunity->id) !!}
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
                    @foreach($opportunity->customerNotes()->orderBy('created_at', 'desc')->get() as $note)
                        <li>
                            <time class="cbp_tmtime" datetime="{{ $note->created_at }}">
                                <span>{{ $note->created_at->format('H:i') }}</span>
                                <span>{{ $note->created_at->format('d/m/Y') }}</span>
                            </time>

                            <div class="cbp_tmicon timeline-bg-{{ $note->type->colour }}">
                                <i class="fa-{{ $note->type->icon }}"></i>
                            </div>

                            <div class="cbp_tmlabel">
                                <h2>{{ $note->user->name }} <span>{{ $note->type->past_tense }}</span></h2>
                                <p>{{ $note->body }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </section>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    @component('interface.components.modal')
        @slot('modalId', 'upload-file')
        @slot('modelBorderClass', 'border-top-success')
        @slot('modalTitle', 'Upload File')
        @slot('modalBody')
            {!! Form::open(['action' => ['Customer\CustomerFileController@store', $customer], 'files' => true, 'role' => 'form', 'class' => 'form-horizontal']) !!}
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::file('file', ['class' => 'form-control']) !!}
                        {!! Form::hidden('related_id', $opportunity->id) !!}
                        {!! Form::hidden('related_type', 'energyOpportunity') !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::select('customer_file_type_id', FormPopulator::energyFileTypes() , null , ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                    <i class="fa fa-fw fa-upload"></i>
                    <span>Upload</span>
                </button>
            </div>
            {!! Form::close() !!}
        @endslot
    @endcomponent

    @component('interface.components.modal')
        @slot('modalId', 'reassign-lead')
        @slot('modelBorderClass', 'border-top-success')
        @slot('modalTitle', 'Reassign Closer')
        @slot('modalBody')
            {!! Form::open(['action' => ['EnergyOpportunity\EnergyOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::label('user_id', 'Assign a Closer', ['class' => 'control-label']) !!}

                        {!! Form::select('user_id', FormPopulator::assignableUsersEnergy(), null, ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}

                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                    <i class="fa fa-fw fa-upload"></i>
                    <span>Update</span>
                </button>
            </div>
            {!! Form::close() !!}
        @endslot
    @endcomponent

    @component('interface.components.modal')
        @slot('modalId', 'edit-gp')
        @slot('modelBorderClass', 'border-top-success')
        @slot('modalTitle', 'Edit GP')
        @slot('modalBody')
            {!! Form::model($opportunity, ['action' => ['EnergyOpportunity\EnergyOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::label('gp', 'Approximate GP', ['class' => 'control-label']) !!}

                        {!! Form::number('gp', null , ['class' => 'form-control', 'step' => '0.01']) !!}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                    <i class="fa fa-fw fa-upload"></i>
                    <span>Update</span>
                </button>
            </div>
            {!! Form::close() !!}
        @endslot
    @endcomponent

    @component('interface.components.modal')
        @slot('modalId', 'blow-lead')
        @slot('modelBorderClass', 'border-top-danger')
        @slot('modalTitle', 'Blow Lead')
        @slot('modalBody')
            {!! Form::open(['action' => ['EnergyOpportunity\EnergyOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::label('energy_opportunity_status_id', 'Blown Status', ['class' => 'control-label']) !!}

                        {!! Form::select('energy_opportunity_status_id', FormPopulator::energyBlownStatuses(), null, ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}

                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn-icon btn-icon-standalone">
                    <i class="fa fa-fw fa-upload"></i>
                    <span>Blow Lead</span>
                </button>
            </div>
            {!! Form::close() !!}
        @endslot
    @endcomponent

    @component('interface.components.modal')
        @slot('modalId', 'save-lead')
        @slot('modelBorderClass', 'border-top-warning')
        @slot('modalTitle', 'Recover Lead')
        @slot('modalBody')
            {!! Form::open(['action' => ['EnergyOpportunity\EnergyOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::hidden('recovered', 1) !!}

                        {!! Form::label('user_id', 'Assign a Closer', ['class' => 'control-label']) !!}

                        {!! Form::select('user_id', FormPopulator::assignableUsersNotNull(), null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                    <i class="fa fa-fw fa-upload"></i>
                    <span>Recover Lead</span>
                </button>
            </div>
            {!! Form::close() !!}
        @endslot
    @endcomponent

    @component('interface.components.modal')
        @slot('modalId', 'set-callback')
        @slot('modelBorderClass', 'border-top-success')
        @slot('modalTitle', 'Set Callback')
        @slot('modalBody')
            {!! Form::open(['action' => ['EnergyOpportunity\CallbackController@store', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::label('time', 'Callback Time', ['class' => 'control-label']) !!}

                        {!! Form::text('time', null, ['class' => 'form-control', 'placeholder' => 'Set a preferred callback time...', 'id' => 'set-callback-time']) !!}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                    <i class="fa fa-fw fa-phone"></i>
                    <span>Set Callback</span>
                </button>
            </div>
            {!! Form::close() !!}
        @endslot
    @endcomponent

    @component('interface.components.modal')
        @slot('modalId', 'add-meter')
        @slot('modelBorderClass', 'border-top-success')
        @slot('modalTitle', 'Add Meter')
        @slot('modalBody')
            {!! Form::open(['action' => ['EnergyOpportunity\EnergyMeterController@store', $customer], 'files' => true, 'role' => 'form', 'class' => 'form-horizontal']) !!}
            <div class="modal-body">
                @include('energy.meters.forms.main')

                @if(isset($opportunity))
                    {!! Form::hidden('opportunity', $opportunity->id) !!}
                @endif
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                    <i class="fa fa-fw fa-upload"></i>
                    <span>Upload</span>
                </button>
            </div>
            {!! Form::close() !!}
        @endslot
    @endcomponent

    @component('interface.components.modal')
        @slot('modalId', 'add-existing-meter')
        @slot('modelBorderClass', 'border-top-success')
        @slot('modalTitle', 'Add Meter')
        @slot('modalBody')

            {!! Form::open(['action' => ['EnergyOpportunity\EnergyOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}

            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('meter', 'Meter', ['class' => 'control-label col-sm-3']) !!}
                    <div class="col-sm-9">
                        {!! Form::select('meter', $customer->energyMeters()->pluck('top_line', 'id'), null, ['class' => 'form-control']) !!}
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                        <i class="fa fa-fw fa-upload"></i>
                        <span>Add</span>
                    </button>
                </div>

            </div>
            {!! Form::close() !!}
        @endslot
    @endcomponent

    @component('interface.components.modal')
        @slot('modalId', 'welcome-call')
        @slot('modelBorderClass', 'border-top-success')
        @slot('modalTitle', 'Welcome Call')
        @slot('modalBody')

            {!! Form::model($opportunity->welcomeCall, ['action' => ['EnergyOpportunity\WelcomeCallsController@store', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}

            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::label('telephone', 'Telephone Number', ['class' => 'control-label']) !!}

                        {!! Form::text('telephone', null, ['class' => 'form-control', 'placeholder' => '01234 567 890']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::label('notes', 'Notes', ['class' => 'control-label']) !!}

                        {!! Form::textarea('notes', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                    <i class="fa fa-fw fa-save"></i>
                    <span>Save</span>
                </button>
            </div>
            {!! Form::close() !!}
        @endslot
    @endcomponent

    <script type="text/javascript">
        $('#set-callback-time').datetimepicker({
            timeFormat: 'HH:mm:ss',
            showSecond: false,
            stepMinute: 5,
            hourMin: 5,
            hourMax: 22,
        });
    </script>
@endsection