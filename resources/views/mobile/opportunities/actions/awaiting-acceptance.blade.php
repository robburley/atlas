{!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="form-group">
            {!! Form::label('accepted', 'Customer Accepted Proposal?', ['class' => 'control-label']) !!}

            {!! Form::select('accepted', FormPopulator::yesNo() , 0 , ['class' => 'form-control', 'id' => 'accepted-select']) !!}
        </div>
    </div>
    <div class="col-md-6 col-md-offset-3" id="deal-calc-select">
        <div class="form-group">
            {!! Form::label('accepted_proposal', 'Which Proposal has been accepted?', ['class' => 'control-label']) !!}

            {!! Form::select('accepted_proposal', $opportunity->dealCalculators()->pluck('name', 'id') , null, ['class' => 'form-control', 'placeholder' => 'Please Select', 'id' => 'prop-select']) !!}
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

@section('scripts')
    @parent
    <script>
        $(document).ready(function () {
            $('#deal-calc-select').hide();
            @if($opportunity->dealCalculators()->count() > 0)
                $('#accepted-select').on('change', function () {
                    if ($(this).val() == 1) {
                        $('#deal-calc-select').slideDown();
                        $('#prop-select').prop('required', true);
                    } else {
                        $('#deal-calc-select').slideUp();
                        $('#prop-select').prop('required', false);
                    }
                });
            @endif
        });
    </script>
@endsection