@inject('statusHelper', 'App\Helpers\MobileOpportunityStatusHelper')

@if($opportunity->dealCalculators->first() && ! $opportunity->dealCalculators->first()->hasTariffs())
    <div class="row">
        <div class="col-md-6">
            <h4>Upload the customers proposal</h4>
        </div>

        <div class="col-md-6">
            <a href="javascript:" onclick="jQuery('#upload-proposal').modal('show', {backdrop: 'fade'})"
               class="btn btn-block btn-info btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
                <i class="fa fa-upload"></i>
                <span>Upload Proposal</span>
            </a>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-sm-6">
            {!! Form::open(['action' => ['MobileOpportunity\ProposalController@show', $customer, $opportunity], 'method' => 'post']) !!}
            <div class="form-group">
                {!! Form::label('deal_calc', 'Choose a proposal to send', ['class' => 'control-label']) !!}

                {!! Form::select('deal_calc', $opportunity->dealCalculators()->pluck('name', 'id'), null , ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('contact', 'Choose a contact to send the proposal order to', ['class' => 'control-label']) !!}

                {!! Form::select('contact', $customer->getContactsWithEmail(), null , ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('message', 'Add a personalised message to the proposal', ['class' => 'control-label']) !!}

                {!! Form::textarea('message', null , ['class' => 'form-control']) !!}
            </div>

            <button type="submit" class="btn btn-info btn-icon btn-icon-standalone btn-icon-standalone-right pull-right">
                <i class="fa fa-envelope"></i>
                <span>Send Proposal</span>
            </button>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            {!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}

            <div class="form-group">
                <div class="col-sm-12">
                    {!! Form::hidden('mobile_opportunity_status_id', $statusHelper->get('awaiting-acceptance')) !!}
                </div>
            </div>

            <button type="submit" class="btn btn-success pull-right">
                <span>Continue ></span>
            </button>
            {!! Form::close() !!}
        </div>
    </div>
@endif


@section('scripts')
    @parent
    <div class="modal fade" id="upload-proposal">
        <div class="modal-dialog border-top-success">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Upload Proposal</h4>
                </div>
                {!! Form::open(['action' => ['Customer\CustomerFileController@store', $customer], 'files' => true, 'role' => 'form', 'class' => 'form-horizontal']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-sm-12">
                            {!! Form::file('file', ['class' => 'form-control']) !!}
                            {!! Form::hidden('customer_file_type_id', 3) !!}
                            {!! Form::hidden('related_id', $opportunity->id) !!}
                            {!! Form::hidden('related_type', 'mobileOpportunity') !!}
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                        <i class="fa fa-fw fa-upload"></i>
                        <span>Upload</span>
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection