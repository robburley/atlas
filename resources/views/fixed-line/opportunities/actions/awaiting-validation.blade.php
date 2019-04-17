{!! Form::open(['action' => ['FixedLineOpportunity\FixedLineOpportunityController@update', $customer->id, $opportunity->id], 'role' => 'form', 'class' => 'form-horizontal']) !!}

<div class="row">
    <div class="col-md-6">
        @if($opportunity->appointment)
            {!! Form::label('valid', 'Appointment Valid?', ['class' => 'control-label']) !!}
        @else
            {!! Form::label('valid', 'Opportunity Valid?', ['class' => 'control-label']) !!}
        @endif
        {!! Form::select('valid', [null => 'Please Select'] + FormPopulator::yesNo(), null, ['class' => 'form-control', 'id' => 'valid-status']) !!}
        <div id="extra-info"></div>
    </div>

    <div class="col-md-6">
        @if(auth()->user()->hasPermission('awaiting_assignment_fixed_line'))
            {!! Form::label('user_id', 'Assign a Closer', ['class' => 'control-label']) !!}

            {!! Form::select('user_id', [null => 'Please Select'] + FormPopulator::assignableUsers($opportunity, 'fixed_line'), null, ['class' => 'form-control']) !!}
        @endif
    </div>

    <div class="col-md-12 text-right">
        <button type="submit" class="btn btn-success m-t-5">
            <i class="fa fa-fw fa-save"></i> Save
        </button>
    </div>
</div>


{!! Form::close() !!}




@section('scripts')
    @parent
    <script>
        $(function () {
            $('#valid-status').change(function () {
                if ($(this).val() == 0) {
                    var input = '<input type="hidden" value="{{ $fixedLineOpportunityStatusHelper->get('awaiting-bill') }}" name="fixed_line_opportunity_status_id">';
                    input = input + '<input type="hidden" value="1" name="back_to_lead_gen">';

                    $('#extra-info').html(input);
                } else {
                    $('#extra-info').empty();
                }
            })
        });
    </script>
@endsection