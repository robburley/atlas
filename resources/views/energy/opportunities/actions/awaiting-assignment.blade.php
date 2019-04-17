{!! Form::open(['action' => ['EnergyOpportunity\EnergyOpportunityController@update', $customer->id, $opportunity->id], 'role' => 'form', 'class' => 'form-horizontal']) !!}
<div class="row">
    <div class="col-sm-6">
        {!! Form::label('user_id', 'Assign a Closer', ['class' => 'control-label']) !!}

        {!! Form::select('user_id', FormPopulator::assignableUsersEnergy(), null, ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
    </div>
</div>

<br>

<div class="row">
    <div class="col-sm-6">
        <button type="submit" class="btn btn-block btn-success m-t-5">
            <i class="fa fa-fw fa-save"></i> Save
        </button>
    </div>
</div>
{!! Form::close() !!}
