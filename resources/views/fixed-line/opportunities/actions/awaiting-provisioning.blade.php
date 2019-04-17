<div class="row">
    @if($opportunity->unsignedPurchaseOrder->count() > 0 && $opportunity->purchaseOrder->count() == 0)
        @if((auth()->user()->needsAdobeSignAccessToken() || auth()->user()->needsAdobeSignAccessTokenRefresh()))
            <div class="col-sm-6 col-sm-offset-3">
                <h4>Login to Adobe Sign</h4>

                <p>To download a purchase order, first you will need to log in to Adobe Sign</p>

                <a href="/oauth2/adobe-sign" class="btn btn-info btn-block m-t-5">Log In</a>
            </div>

        @else
            <div class="col-sm-6 col-sm-offset-3">
                {!! Form::open(['action' => ['FixedLineOpportunity\PurchaseOrderController@update', $customer, $opportunity], 'method' => 'post']) !!}

                {!! Form::label('document', 'Before you proceed you must download the purchase order', ['class' => 'control-label']) !!}

                <button type="submit" class="btn btn-success btn-block">
                    Download Purchase Order
                </button>
                {!! Form::close() !!}
            </div>
        @endif
    @else
        {!! Form::open(['action' => ['FixedLineOpportunity\FixedLineOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
        <div class="col-md-6 col-md-offset-3">
            <div class="form-group">
                {!! Form::label('provisioned', 'Provisioning complete?', ['class' => 'control-label']) !!}

                {!! Form::select('provisioned',FormPopulator::yesNo() , null , ['class' => 'form-control', 'id' => 'credit-check-status']) !!}

            </div>

            <div id="extra-info"></div>

            <div id="credit-check-failed">
                <div class="form-group">
                    {!! Form::label('provisioned_failed_reason', 'Provisioning failed reason', ['class' => 'control-label']) !!}
                    {!! Form::text('provisioned_failed_reason', null , ['class' => 'form-control']) !!}
                </div>


                <div class="form-group">
                    {!! Form::label('new_callback', 'Set Callback', ['class' => 'control-label']) !!}
                    {!! Form::text('new_callback', null, ['class' => 'form-control datetimepicker', 'placeholder' => 'Set a preferred callback time...', 'id' => 'blown-callback']) !!}
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group text-right">
                <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                    <i class="fa fa-fw fa-upload"></i>
                    <span>Update</span>
                </button>
            </div>

        </div>
        {!! Form::close() !!}
    @endif
</div>

@section('scripts')
    @parent
    <script>
        $(function () {
            $('#credit-check-failed').hide();

            $('#credit-check-status').change(function () {
                if ($(this).val() == 0) {
                    var input = '<input type="hidden" value="{{ $fixedLineOpportunityStatusHelper->get('failed-provisioning') }}" name="fixed_line_opportunity_status_id">';

                    $('#extra-info').html(input);

                    $('#credit-check-failed').show();
                    $('#provisioned_failed_reason').prop('required', true);
                    $('#blown-callback').prop('required', true);
                } else {
                    $('#extra-info').empty();
                    $('#credit-check-failed').hide();
                    $('#provisioned_failed_reason').prop('required', false);
                    $('#blown-callback').prop('required', false);
                }
            })
        });
    </script>
@endsection