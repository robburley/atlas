<div class="row">
    <div class="col-sm-6 col-sm-offset-4">
        <h4 class="text-dark text-right">
            This will reset the opportunity back to deal calcualtor, <br>
            requiring a new Purchase Order to be sent to the customer
        </h4>
    </div>
    <div class="col-sm-3 col-sm-offset-7">
        {!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityResetController@update', $customer, $opportunity], 'method' => 'post']) !!}
        <button class="btn btn-block btn-danger btn-icon btn-icon-standalone btn-icon-standalone-right btn-single text-left">
            <i class="fa-save"></i>

            <span>Reset opportunity to Deal Calculator</span>
        </button>
        {!! Form::close() !!}
    </div>
</div>