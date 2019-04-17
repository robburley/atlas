<div class="row">
    <div class="col-md-8 col-md-offset-2">

        {!! Form::model($opportunity, ['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}

        <div class="form-group">
            <div class="col-sm-12">
                {!! Form::label('ep_ref', 'EP Ref', ['class' => 'control-label']) !!}

                {!! Form::text('ep_ref', null, ['class' => 'form-control']) !!}
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
                <div class="col-md-3">
                    <a href="javascript:;" onclick="jQuery('#credit-check-passed').modal('show', {backdrop: 'fade'})"
                       class="btn btn-success btn-icon btn-icon-standalone btn-block">
                        <i class="fa fa-fw fa-check"></i>

                        <span>Passed</span>
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="javascript:;" onclick="jQuery('#bond-agreement-needed').modal('show', {backdrop: 'fade'})"
                       class="btn btn-warning btn-icon btn-icon-standalone btn-block">
                        <i class="fa fa-warning p-r-10"></i>

                        <span>Bond Agreement Needed</span>
                    </a>
                </div>

                <div class="col-md-3">
                    {!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}

                    {!! Form::hidden('mobile_opportunity_status_id', $mobileOpportunityStatusHelper->get('awaiting-proofs')) !!}

                    <button class="btn btn-warning btn-icon btn-icon-standalone btn-block">
                        <i class="fa fa-warning p-r-10"></i>

                        <span>Proofs Needed</span>
                    </button>
                    {!! Form::close() !!}
                </div>

                <div class="col-md-3">
                    <a href="javascript:;" onclick="jQuery('#decline-credit-check').modal('show', {backdrop: 'fade'})"
                       class="btn btn-danger btn-icon btn-icon-standalone btn-block">
                        <i class="fa fa-times"></i>

                        <span>Declined (blown)</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif

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

    @component('interface.components.modal')
        @slot('modalId', 'bond-agreement-needed')
        @slot('modelBorderClass', 'border-top-warning')
        @slot('modalTitle', 'Bond Agreement Needed')
        @slot('modalBody')
            @if((auth()->user()->needsAdobeSignAccessToken() || auth()->user()->needsAdobeSignAccessTokenRefresh()))
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4>Login to Adobe Sign</h4>

                            <p>To Generate a bond agreement, first you will need to log in to Adobe Sign</p>

                            <a href="/oauth2/adobe-sign" class="btn btn-info btn-block m-t-5">Log In</a>
                        </div>
                    </div>
                </div>
            @else
                {!! Form::open(['action' => ['MobileOpportunity\BondAgreementController@store', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-sm-12">
                            {!! Form::label('type', 'Bond Type', ['class' => 'control-label']) !!}

                            {!! Form::select('type', ['Customer pays bond', 'Customer pays bond, refund immediately', 'We provide funds to customer'], null , ['class' => 'form-control', 'id' => 'bond-type-select']) !!}
                        </div>

                        <div class="col-sm-12">
                            {!! Form::label('amount', 'Bond Amount', ['class' => 'control-label']) !!}

                            {!! Form::number('amount', null , ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-sm-12">
                            {!! Form::label('bgRef', 'BG Ref', ['class' => 'control-label']) !!}

                            {!! Form::text('bgRef', null , ['class' => 'form-control']) !!}
                        </div>

                        <div id="bond-email">

                            <div class="col-sm-12">
                                {!! Form::label('contact', 'Choose a contact to send the bond agreement to', ['class' => 'control-label']) !!}

                                {!! Form::select('contact', $customer->getContactsWithEmail(), null , ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                        <i class="fa fa-fw fa-upload"></i>

                        <span>Proccess Bond</span>
                    </button>
                </div>
                {!! Form::close() !!}
            @endif
        @endslot
    @endcomponent

    @component('interface.components.modal')
        @slot('modalId', 'decline-credit-check')
        @slot('modelBorderClass', 'border-top-danger')
        @slot('modalTitle', 'Credit Check Declined')
        @slot('modalBody')
            {!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::hidden('mobile_opportunity_status_id', 13) !!}
                        {!! Form::hidden('new_callback', Carbon\Carbon::now()->addYears(2)->format('d/m/Y H:i:s')) !!}
                        {!! Form::hidden('credit_check_failed', 1) !!}

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

    <script>
        $(document).ready(function () {
            $('#bond-email').hide()

            $('#bond-type-select').change(function () {
                if ($('#bond-type-select').val() == 2) {
                    $('#bond-email').show()
                } else {
                    $('#bond-email').hide()
                }
            })

            $('.set-callback-time').datetimepicker({
                timeFormat: 'HH:mm:ss',
                showSecond: false,
                stepMinute: 5,
                hourMin: 5,
                hourMax: 22,
            });
        })
    </script>
@endsection