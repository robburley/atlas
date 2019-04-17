@component('interface.components.modal')
    @slot('modalId', 'create-customer')
    @slot('modelBorderClass', 'border-top-success')
    @slot('modalTitle', 'Create Customer')
    @slot('modalBody')
        {!! Form::open(['url' => '/customers/search', 'role' => 'form', 'class' => 'form-horizontal']) !!}
        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('company_name', 'Company Name', ['class' => 'col-sm-4 control-label']) !!}

                <div class="col-sm-8">
                    {!! Form::text('company_name', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off',  'pattern' => '.{3,}']) !!}
                </div>
            </div>

            <div class="form-group-separator"></div>

            <div class="form-group">
                {!! Form::label('telephone_number', 'Telephone Number', ['class' => 'col-sm-4 control-label']) !!}

                <div class="col-sm-8">
                    {!! Form::text('telephone_number', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                <i class="fa fa-fw fa-arrow-right"></i>
                <span>Continue</span>
            </button>
        </div>
        {!! Form::close() !!}

    @endslot
@endcomponent
