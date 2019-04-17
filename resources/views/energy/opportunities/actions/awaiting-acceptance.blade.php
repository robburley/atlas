<div class="row">
    <div class="col-sm-6">
        {!! Form::open(['action' => ['EnergyOpportunity\EnergyOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
        <div class="form-group">
            {!! Form::label('accepted', 'Customer Accepted Proposal?', ['class' => 'control-label']) !!}
            {!! Form::select('accepted', FormPopulator::yesNo() , null , ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-block btn-success btn-icon btn-icon-standalone">
                <i class="fa fa-fw fa-upload"></i>
                <span>Update</span>
            </button>
        </div>

        {!! Form::close() !!}
    </div>
</div>