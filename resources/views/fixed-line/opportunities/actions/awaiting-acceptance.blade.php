{!! Form::open(['action' => ['FixedLineOpportunity\FixedLineOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="form-group">
            {!! Form::label('accepted', 'Customer Accepted Proposal?', ['class' => 'control-label']) !!}

            {!! Form::select('accepted', FormPopulator::yesNo() , 0 , ['class' => 'form-control', 'id' => 'accepted-select']) !!}
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
</div>
{!! Form::close() !!}