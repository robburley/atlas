{!! Form::open(['action' => ['EnergyOpportunity\EnergyOpportunityController@update', $customer->id, $opportunity->id], 'role' => 'form', 'class' => 'form-horizontal']) !!}
<div class="row">
    <div class="col-sm-6">
        {!! Form::label('valid', 'Opportunity Valid?', ['class' => 'control-label']) !!}
        {!! Form::select('valid', [null => 'Please Select'] + FormPopulator::yesNo(), null, ['class' => 'form-control', 'id' => 'valid-status']) !!}
        <div id="extra-info"></div>
    </div>
</div>
@if(auth()->user()->hasPermission('awaiting_assignment_energy'))
    <br>

    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('user_id', 'Assign a Closer', ['class' => 'control-label']) !!}

            {!! Form::select('user_id', [null => 'Please Select'] + FormPopulator::assignableUsersEnergy(), null, ['class' => 'form-control']) !!}
        </div>
    </div>
@endif
<br>

<div class="row">
    <div class="col-sm-6">
        <button type="submit" class="btn btn-block btn-success m-t-5">
            <i class="fa fa-fw fa-save"></i> Save
        </button>
    </div>
</div>
{!! Form::close() !!}

@section('scripts')
    @parent
    <script>
        $(function() {
            $('#valid-status').change(function(){
                if($(this).val() == 0) {
                    var input = '<input type="hidden" value="1" name="energy_opportunity_status_id">';

                    $('#extra-info').html(input);
                } else {
                    $('#extra-info').empty();
                }
            })
        });
    </script>
@endsection