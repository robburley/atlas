@inject('statusHelper', 'App\Helpers\FixedLineOpportunityStatusHelper')

<div class="row">
    <div class="col-sm-3 col-sm-offset-3">
        {!! Form::open(['action' => ['FixedLineOpportunity\ProposalController@show', $customer, $opportunity], 'method' => 'post', 'target' => '_blank']) !!}
        <button type="submit" class="btn btn-success btn-block">
            Download Proposal
        </button>
        {!! Form::close() !!}
    </div>
    <div class="col-sm-3">
        {!! Form::open(['action' => ['FixedLineOpportunity\FixedLineOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
        {!! Form::hidden('fixed_line_opportunity_status_id', $statusHelper->get('awaiting-acceptance')) !!}

        <button type="submit" class="btn btn-success btn-block">
            <span>Continue ></span>
        </button>
        {!! Form::close() !!}
    </div>
</div>


@section('scripts')
    @parent
@endsection