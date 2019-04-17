<div class="row">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            {!! Form::model($opportunity, ['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}

            <div class="form-group">
                <div class="col-sm-12">
                    {!! Form::label('ep_ref', 'EP Ref', ['class' => 'control-label']) !!}

                    {!! Form::text('ep_ref', null, ['class' => 'form-control']) !!}

                    {!! Form::hidden('mobile_opportunity_status_id', $mobileOpportunityStatusHelper->get('pending-credit-check')) !!}
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-icon btn-icon-standalone pull-right">
                <i class="fa fa-fw fa-upload p-r-20"></i>

                <span>Update</span>
            </button>
            {!! Form::close() !!}
        </div>
    </div>

    @if(!empty($opportunity->ep_ref))
        <div class="row">
            <hr>
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                    <div class="col-md-6">
                        <a href="javascript:;"
                           onclick="jQuery('#credit-check-passed').modal('show', {backdrop: 'fade'})"
                           class="btn btn-success btn-icon btn-icon-standalone btn-block">
                            <i class="fa fa-fw fa-check"></i>

                            <span>Passed</span>
                        </a>
                    </div>

                    <div class="col-md-6">
                        {!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}

                        {!! Form::hidden('mobile_opportunity_status_id', 25) !!}
                        {!! Form::hidden('credit_check_escalated', 1) !!}

                        <button type="submit" class="btn btn-warning btn-icon btn-icon-standalone btn-block">
                            <i class="fa fa-fw fa-close p-r-20"></i>

                            <span>Escalate</span>
                        </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@section('scripts')
    @parent

    @component('interface.components.modal')
        @slot('modalId', 'credit-check-passed')
        @slot('modelBorderClass', 'border-top-success')
        @slot('modalTitle', 'Credit Check Information')
        @slot('modalBody')
            {!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::label('bg_ref', 'BG Ref', ['class' => 'control-label']) !!}

                        {!! Form::text('bg_ref', null , ['class' => 'form-control']) !!}

                        {!! Form::hidden('credit_check_passed', 1) !!}
                        {!! Form::hidden('mobile_opportunity_status_id', 12) !!}
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
@endsection
