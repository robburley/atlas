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
                    {!! Form::hidden('related_type', 'mobileOpportunity') !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    {!! Form::select('customer_file_type_id', FormPopulator::mobileFileTypes() , null , ['class' => 'form-control']) !!}
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
    @slot('modelBorderClass', 'border-top-warning')
    @slot('modalTitle', 'Reassign Closer')
    @slot('modalBody')
        {!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
        <div class="modal-body">
            <div class="form-group">
                <div class="col-sm-12">
                    {!! Form::label('user_id', 'Assign a Closer', ['class' => 'control-label']) !!}

                    {!! Form::select('user_id', FormPopulator::assignableUsers($opportunity), null, ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}

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
    @slot('modalTitle', 'Recover Edit GP')
    @slot('modalBody')
        {!! Form::model($opportunity, ['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
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
        {!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
        <div class="modal-body">
            <div class="form-group">
                <div class="col-sm-12">
                    {!! Form::label('mobile_opportunity_status_id', 'Blown Status', ['class' => 'control-label']) !!}

                    {!! Form::select('mobile_opportunity_status_id', FormPopulator::mobileBlownStatuses(), null, ['class' => 'form-control', 'placeholder' => 'Please Select', 'required' => 'required']) !!}

                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    {!! Form::label('new_callback', 'Set Callback', ['class' => 'control-label']) !!}

                    {!! Form::text('new_callback', null, ['class' => 'form-control datetimepicker', 'placeholder' => 'Please Select a callback time', 'required' => 'required']) !!}

                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    {!! Form::label('blown_reason', 'Blown Reason', ['class' => 'control-label']) !!}

                    {!! Form::textarea('blown_reason', null, ['class' => 'form-control', 'placeholder' => 'Describe why the opportunity has blown.', 'required' => 'required']) !!}

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
    @slot('modelBorderClass', 'border-top-success')
    @slot('modalTitle', 'Recover Lead')
    @slot('modalBody')
        {!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
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
        {!! Form::open(['action' => ['MobileOpportunity\CallbackController@store', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
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
    @slot('modalId', 'set-vetted')
    @slot('modelBorderClass', 'border-top-warning')
    @slot('modalTitle', 'Vet Opportunity')
    @slot('modalBody')
        {!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}

        <div class="modal-footer">
            {!! Form::hidden('review_date', \Carbon\Carbon::now()->format('d/m/Y')) !!}
            <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                <i class="fa fa-fw fa-check"></i>
                <span>Confirm</span>
            </button>
        </div>
        {!! Form::close() !!}
    @endslot
@endcomponent

@component('interface.components.modal')
    @slot('modalId', 'welcome-call')
    @slot('modelBorderClass', 'border-top-success modal-wide')
    @slot('modalTitle', 'Welcome Call')
    @slot('modalBody')
        {!! Form::model($opportunity->welcomeCall, ['action' => ['MobileOpportunity\WelcomeCallsController@store', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}

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


@if($opportunity->appointment)
    @component('interface.components.modal')
        @slot('modalId', 'update-appointment-time')
        @slot('modelBorderClass', 'border-top-success')
        @slot('modalTitle', 'Update Appointment')
        @slot('modalBody')
            {!! Form::open(['action' => ['Appointments\AppointmentsController@update', $opportunity->appointments->first()], 'role' => 'form', 'class' => 'form-horizontal']) !!}
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12">
                        {!! Form::label('time', 'Update Appointment Date and time', ['class' => 'control-label']) !!}

                        {!! Form::text('time', $opportunity->appointments->first() && $opportunity->appointments->first()->time ? $opportunity->appointments->first()->time->format('d/m/Y H:i:s') : null, ['class' => 'form-control', 'id' => 'appointment-time']) !!}

                        {!! $errors->first('time', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        {!! Form::label('contact_id', 'Contact', ['class' => 'control-label']) !!}

                        {!! Form::select('contact_id', $opportunity->customer->getContacts() , null , ['class' => 'form-control']) !!}

                        {!! $errors->first('contact_id', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        {!! Form::label('site_id', 'Site', ['class' => 'control-label']) !!}

                        {!! Form::select('site_id', $opportunity->customer->getSites() , null , ['class' => 'form-control']) !!}

                        {!! $errors->first('site_id', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}

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
@endif

@if($opportunity->salesInformation)
    @component('interface.components.modal')
        @slot('modalId', 'edit-information')
        @slot('modelBorderClass', 'border-top-success modal-wide')
        @slot('modalTitle', 'Update Customer Information')
        @slot('modalBody')
            {!! Form::model($opportunity->salesInformation, ['action' => ['MobileOpportunity\SalesInformationController@store', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
            <div class="modal-body">

                @include('mobile.opportunities.actions.partials.customer-information')

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
@endif

@if($opportunity->allocations)
    @component('interface.components.modal')
        @slot('modalId', 'edit-allocations')
        @slot('modelBorderClass', 'border-top-success modal-x-wide')
        @slot('modalTitle', 'Update Allocations')
        @slot('modalBody')
            @if($opportunity->selectedDealCalculator()->first())
                <mobile-allocation :customer="{{ $customer->id }}"
                                   :opportunity="{{ $opportunity->id }}"
                                   :deal_calculator="{{ $opportunity->selectedDealCalculator()->with(['handsets.handset','connections.tariff.type',])->first()->toJson() }}"
                                   :allocations="{{ $opportunity->allocations()->with(['vas'])->get() }}"
                                   :hide_finished="true"
                ></mobile-allocation>
            @endif
        @endslot
    @endcomponent
@endif
