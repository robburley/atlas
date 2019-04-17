<div class="row">
    @if($opportunity->dealCalculators->first() && $opportunity->dealCalculators->first()->hasTariffs())
        @if((auth()->user()->needsAdobeSignAccessToken() || auth()->user()->needsAdobeSignAccessTokenRefresh()) && !$opportunity->adobeSignDocumentPurchaseOrder)
            <div class="col-sm-6 col-sm-offset-3">
                <h4>Login to Adobe Sign</h4>

                <p>To Generate a purchase order, first you will need to log in to Adobe Sign</p>

                <a href="/oauth2/adobe-sign" class="btn btn-info btn-block m-t-5">Log In</a>
            </div>
        @else
            @if(!$opportunity->adobeSignDocumentPurchaseOrder)
                <div class="col-sm-6 col-sm-offset-3">
                    {!! Form::open(['action' => ['MobileOpportunity\PurchaseOrderController@store', $customer, $opportunity], 'method' => 'post', 'id' => 'purchase-order-form']) !!}

                    <div class="form-group">
                        {!! Form::label('contact', 'Choose a contact to send the Purchase order to', ['class' => 'control-label']) !!}

                        {!! Form::select('contact', $customer->getContactsWithEmail(), null , ['class' => 'form-control']) !!}
                    </div>

                    {!! Form::hidden('deal_calc', $opportunity->selectedDealCalculator->first()->id, ['id' => 'id']) !!}

                    <button type="submit" class="btn btn-success btn-block" id="send-purchase-order">
                        Send Purchase Order
                    </button>
                    {!! Form::close() !!}
                </div>
            @else
                <div class="col-sm-6 col-sm-offset-3 m-t-25">
                    <p>eSignature has been sent to customer, current status:
                        <strong>{{ $opportunity->adobeSignDocumentPurchaseOrder->status  }}</strong></p>
                </div>

                <div class="col-sm-6 col-sm-offset-3 m-t-25">
                    {!! Form::open(['action' => ['MobileOpportunity\PurchaseOrderController@destroy', $customer, $opportunity], 'method' => 'DELETE']) !!}

                    <button type="submit" class="btn btn-danger btn-block">
                        Cancel Purchase Order
                    </button>
                    {!! Form::close() !!}
                </div>
            @endif
        @endif

        @if(!$opportunity->adobeSignDocumentPurchaseOrder)
            <div class="col-sm-6 col-sm-offset-3 m-t-25">
                {!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityResetController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
                <button type="submit" class="btn btn-warning btn-block">
                    <i class="fa fa-fw fa-reply"></i> Return to deal calc
                </button>
                {!! Form::close() !!}
            </div>
        @endif
    @else
        <div class="col-md-6">
            <h4>Download Letterhead</h4>
            @if($opportunity->letterhead->first())
                <a href="{{ action('Customer\CustomerFileController@show', [$customer, $opportunity->letterhead->first()])  }}"
                   class="btn btn-block btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0"
                >
                    <i class="fa fa-download"></i>
                    <span>Letterhead</span>
                </a>
            @else
                <p>No Letterhead uploaded</p>
            @endif
        </div>

        <div class="col-md-6">
            <h4>Upload signed purchase order</h4>

            <a href="javascript:" onclick="jQuery('#upload-purchase-order').modal('show', {backdrop: 'fade'})"
               class="btn btn-block btn-info btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
                <i class="fa fa-upload"></i>
                <span>Upload Purchase Order</span>
            </a>
        </div>
    @endif
</div>


@section('scripts')
    @parent
    <div class="modal fade" id="upload-purchase-order">
        <div class="modal-dialog border-top-success">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Upload Purchase Order</h4>
                </div>
                {!! Form::open(['action' => ['Customer\CustomerFileController@store', $customer], 'files' => true, 'role' => 'form', 'class' => 'form-horizontal']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-sm-12">
                            {!! Form::file('file', ['class' => 'form-control']) !!}
                            {!! Form::hidden('customer_file_type_id', 5) !!}
                            {!! Form::hidden('related_id', $opportunity->id) !!}
                            {!! Form::hidden('related_type', 'mobileOpportunity') !!}
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
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#purchase-order-form').submit(function () {
                $('#send-purchase-order').prop('disabled', true)
            })
        })
    </script>
@endsection