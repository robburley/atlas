<div class="row">
    <div class="col-sm-6">
        <h4>Upload the customers quote</h4>

        <a href="javascript:" onclick="jQuery('#upload-quote').modal('show', {backdrop: 'fade'});"
           class="btn btn-block btn-info btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
            <i class="fa fa-upload"></i>
            <span>Upload Quote</span>
        </a>
    </div>
</div>

@section('scripts')
    @parent
    <div class="modal fade" id="upload-quote">
        <div class="modal-dialog border-top-success">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Upload Energy Quote</h4>
                </div>
                {!! Form::open(['action' => ['Customer\CustomerFileController@store', $customer], 'files' => true, 'role' => 'form', 'class' => 'form-horizontal']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-sm-12">
                            {!! Form::file('file', ['class' => 'form-control']) !!}
                            {!! Form::hidden('customer_file_type_id', 12) !!}
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