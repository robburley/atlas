<div class="row">
    @if(!$opportunity->adobeSignDocumentBondAgreement || $opportunity->adobeSignDocumentBondAgreement->status == 'SIGNED')
        @if(
            !$opportunity->bondAgreement->first() &&
            $opportunity->unsignedBondAgreement->first() &&
            $opportunity->adobeSignDocumentBondAgreement &&
            $opportunity->adobeSignDocumentBondAgreement->status == 'SIGNED'
        )
            @if((auth()->user()->needsAdobeSignAccessToken() || auth()->user()->needsAdobeSignAccessTokenRefresh()))
                <div class="col-sm-6 col-sm-offset-3">
                    <h4>Login to Adobe Sign</h4>

                    <p>To download a purchase order, first you will need to log in to Adobe Sign</p>

                    <a href="/oauth2/adobe-sign" class="btn btn-info btn-block m-t-5">Log In</a>
                </div>
            @else
                <div class="col-sm-6 col-sm-offset-3">
                    {!! Form::open(['action' => ['MobileOpportunity\BondAgreementController@update', $customer, $opportunity], 'method' => 'post']) !!}

                    {!! Form::label('document', 'Before you proceed you must download the bond agreement', ['class' => 'control-label']) !!}

                    <button type="submit" class="btn btn-success btn-block">
                        Download Bond Agreement
                    </button>
                    {!! Form::close() !!}
                </div>
            @endif
        @else
            {!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
            <div class="col-md-6 col-md-offset-3 text-center">
                <div class="form-group">
                    {!! Form::hidden('mobile_opportunity_status_id', $mobileOpportunityStatusHelper->get('awaiting-fulfilment')) !!}
                    <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                        <i class="fa fa-fw fa-upload"></i>
                        <span>Bond Payment Cleared</span>
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        @endif
    @else
        <div class="col-md-6 col-md-offset-3 text-center m-h-200">
            <h4 class="text-dark">
                Waiting For Customer to sign the bond agreement.
            </h4>
            <p>Check back later</p>
        </div>
    @endif
</div>
