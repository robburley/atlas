<div class="row">
    <div class="col-sm-6">
        <h4>Upload the energy tender response</h4>

        <a href="javascript:" onclick="jQuery('#upload-tender-response').modal('show', {backdrop: 'fade'});"
           class="btn btn-block btn-info btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
            <i class="fa fa-upload"></i>
            <span>Upload Tender Response</span>
        </a>


        @if(count($opportunity->energyTenderResponse) > 0)
            {!! Form::open(['action' => ['EnergyOpportunity\EnergyOpportunityController@update', $customer->id, $opportunity->id], 'role' => 'form', 'class' => 'form-horizontal']) !!}

            {!! Form::hidden('energy_opportunity_status_id', 10) !!}
            <div class="row">
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-block btn-success m-t-5">
                        <i class="fa fa-fw fa-save"></i> Continue
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        @endif
    </div>
</div>

@section('scripts')
    @parent
    <div class="modal fade" id="upload-tender-response">
        <div class="modal-dialog border-top-success">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Upload Energy Tender Response</h4>
                </div>
                {!! Form::open(['action' => ['Customer\CustomerFileController@store', $customer], 'files' => true, 'role' => 'form', 'class' => 'form-horizontal']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-sm-12">
                            {!! Form::file('file', ['class' => 'form-control']) !!}
                            {!! Form::hidden('customer_file_type_id', 11) !!}
                            {!! Form::hidden('related_id', $opportunity->id) !!}
                            {!! Form::hidden('related_type', 'energyOpportunity') !!}
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