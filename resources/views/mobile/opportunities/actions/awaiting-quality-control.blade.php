@if($opportunity->unsignedPurchaseOrder->count() > 0 && $opportunity->purchaseOrder->count() == 0)
    @if((auth()->user()->needsAdobeSignAccessToken() || auth()->user()->needsAdobeSignAccessTokenRefresh()))
        <div class="col-sm-6 col-sm-offset-3">
            <h4>Login to Adobe Sign</h4>

            <p>To download a purchase order, first you will need to log in to Adobe Sign</p>

            <a href="/oauth2/adobe-sign" class="btn btn-info btn-block m-t-5">Log In</a>
        </div>
    @else
        <div class="col-sm-6 col-sm-offset-3">
            {!! Form::open(['action' => ['MobileOpportunity\PurchaseOrderController@update', $customer, $opportunity], 'method' => 'post']) !!}

            {!! Form::label('document', 'Before you proceed you must download the purchase order', ['class' => 'control-label']) !!}

            <button type="submit" class="btn btn-success btn-block">
                Download Purchase Order
            </button>
            {!! Form::close() !!}
        </div>
    @endif
@else
    <mobile-quality-control :opportunity="{{ $opportunity->id }}"
                            :user="{{ auth()->user()->id }}"></mobile-quality-control>
@endif