<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-6">
        <a href="javascript:" onclick="jQuery('#upload-bill').modal('show', {backdrop: 'fade'})"
           class="btn btn-block btn-info btn-icon btn-icon-standalone btn-icon-standalone-right">
            <i class="fa fa-upload"></i>
            <span>Upload a Proof</span>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-6">
        {!! Form::model($opportunity, ['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}

        {!! Form::hidden('mobile_opportunity_status_id', $mobileOpportunityStatusHelper->get('pending-proofs')) !!}

        <button class="btn btn-success btn-icon btn-icon-standalone btn-icon-standalone-left m-b-0 pull-right">
            <i class="fa fa-check"></i>
            <span>continue</span>
        </button>

        {{ Form::close() }}
    </div>
</div>


@section('scripts')
    @parent
    <div class="modal fade" id="upload-bill">
        <div class="modal-dialog border-top-success">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Upload a Proof</h4>
                </div>
                {!! Form::open(['action' => ['Customer\CustomerFileController@store', $customer], 'files' => true, 'role' => 'form', 'class' => 'form-horizontal']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-sm-12">
                            {!! Form::file('file', ['class' => 'form-control']) !!}
                            {!! Form::hidden('customer_file_type_id', 19) !!}
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