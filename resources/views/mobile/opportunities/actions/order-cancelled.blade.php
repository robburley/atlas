<div class="row">
    <div class="col-md-3 col-md-offset-3">
        {!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}

        {!! Form::hidden('mobile_opportunity_status_id', 12) !!}
        {!! Form::hidden('fulfilment_saved_deal', 1) !!}

        <button class="btn btn-block btn-success btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
            <i class="fa fa-thumbs-o-up"></i>
            <span>Saved</span>
        </button>
        {!! Form::close() !!}
    </div>

    <div class="col-md-3">
        <a href="javascript:;" onclick="jQuery('#blow-lead').modal('show', {backdrop: 'fade'})"
           class="btn btn-block btn-danger btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
            <i class="fa fa-times"></i>
            <span>Blown</span>
        </a>
    </div>
</div>
