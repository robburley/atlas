@if(!$opportunity->allocated)
    @if($opportunity->selectedDealCalculator()->with(['handsets.handset','connections.tariff.type',])->first())
        <mobile-allocation :customer="{{ $customer->id }}"
                           :opportunity="{{ $opportunity->id }}"
                           :deal_calculator="{{ $opportunity->selectedDealCalculator()->with(['handsets.handset','connections.tariff.type',])->first()->toJson() }}"
                           :allocations="{{ $opportunity->allocations()->with(['vas'])->get() }}"
                           :hide_finished="false"
        ></mobile-allocation>
    @else
       <span class="text-danger">Error. Please resubmit deal calculator.</span>
    @endif
@else
    @if($opportunity->letterhead->count() == 0 )
        <div class="row">
            <div class="col-md-6">
                <h4>Upload the customers letterhead</h4>

                <a href="javascript:" onclick="jQuery('#upload-letterhead').modal('show', {backdrop: 'fade'})"
                   class="btn btn-info btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
                    <i class="fa fa-upload"></i>
                    <span>Upload letterhead</span>
                </a>

                {!! $errors->first('file', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
            </div>
        </div>

        <hr>
    @endif

    <div class="row">
        <div class="col-sm-12">
            <h4>Add Additional Sales Information</h4>
        </div>
    </div>

    {!! Form::model($opportunity->salesInformation, ['action' => ['MobileOpportunity\SalesInformationController@store', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}

    @include('mobile.opportunities.actions.partials.customer-information')

    <div class="row">
        <div class="col-sm-12 text-right">
            <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                <i class="fa fa-fw fa-upload"></i>
                <span>Update</span>
            </button>
        </div>
    </div>

    {!! Form::close() !!}
@endif

{!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityResetController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
<div class="row">
    <div class="col-sm-12">
        <button type="submit" class="btn btn-danger">
            <i class="fa fa-fw fa-backward"></i>
            Back to Commercials
        </button>
    </div>
</div>
{!! Form::close() !!}


@section('scripts')
    @parent
    <div class="modal fade" id="upload-letterhead">
        <div class="modal-dialog border-top-success">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Upload Letterhead</h4>
                </div>
                {!! Form::open(['action' => ['Customer\CustomerFileController@store', $customer], 'files' => true, 'role' => 'form', 'class' => 'form-horizontal']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-sm-12">
                            {!! Form::file('file', ['class' => 'form-control']) !!}
                            {!! Form::hidden('customer_file_type_id', 4) !!}
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