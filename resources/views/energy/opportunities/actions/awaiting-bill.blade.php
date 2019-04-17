<div class="row">
    <div class="col-sm-6">
        <h4>Upload the customers bill</h4>

        <a href="javascript:" onclick="jQuery('#upload-bill').modal('show', {backdrop: 'fade'});"
           class="btn btn-block btn-info btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
            <i class="fa fa-upload"></i>
            <span>Upload Bill</span>
        </a>
    </div>
</div>

@section('scripts')
    @parent
    @component('interface.components.modal')
        @slot('modalId', 'upload-bill')
        @slot('modelBorderClass', 'border-top-success')
        @slot('modalTitle', 'Upload Energy Bill')
        @slot('modalBody')
            {!! Form::open(['action' => ['Customer\CustomerFileController@store', $customer], 'files' => true, 'role' => 'form', 'class' => 'form-horizontal']) !!}
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::file('file', ['class' => 'form-control']) !!}
                        {!! Form::hidden('customer_file_type_id', 7) !!}
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
        @endslot
    @endcomponent
@endsection