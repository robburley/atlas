<div class="row">
    @if((auth()->user()->needsAdobeSignAccessToken() || auth()->user()->needsAdobeSignAccessTokenRefresh()) && !$opportunity->adobeSignDocumentPurchaseOrder)
        <div class="col-sm-6 col-sm-offset-3">
            <h4>Login to Adobe Sign</h4>

            <p>To Generate a purchase order, first you will need to log in to Adobe Sign</p>

            <a href="/oauth2/adobe-sign" class="btn btn-info btn-block m-t-5">Log In</a>
        </div>
    @else
        @if(!$opportunity->adobeSignDocumentPurchaseOrder)
            <div class="col-sm-6 col-sm-offset-3">
                {!! Form::open(['action' => ['FixedLineOpportunity\PurchaseOrderController@store', $customer, $opportunity], 'method' => 'post', 'id' => 'purchase-order-form']) !!}

                <div class="form-group">
                    {!! Form::label('contact', 'Choose a contact to send the Purchase order to', ['class' => 'control-label']) !!}
                    {!! Form::select('contact', $customer->getContactsWithEmail(), null , ['class' => 'form-control']) !!}
                </div>

                <button type="submit" class="btn btn-success btn-block" id="send-purchase-order">
                    Send Purchase Order
                </button>
                {!! Form::close() !!}
            </div>
        @else
            <div class="col-sm-6">
                <p>
                    eSignature has been sent to customer, current status:
                    <strong>{{ $opportunity->adobeSignDocumentPurchaseOrder->status  }}</strong>
                </p>
            </div>
        @endif
    @endif
</div>


@section('scripts')
    @parent

    <script>
        $(document).ready(function () {
            $('#purchase-order-form').submit(function () {
                $('#send-purchase-order').prop('disabled', true)
            })
        })
    </script>
@endsection