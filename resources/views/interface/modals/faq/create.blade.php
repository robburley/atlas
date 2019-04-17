@component('interface.components.modal')
    @slot('modalId', 'faq-create')
    @slot('modelBorderClass', 'border-top-warning')
    @slot('modalTitle', 'Ask a question')
    @slot('modalBody')
        {!! Form::open(['url' => '/faq/questions', 'role' => 'form', 'class' => 'form-horizontal']) !!}
        <div class="modal-body">
            <div class="form-group">
                <div class="col-sm-12">
                    {!! Form::textarea('question', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                <i class="fa fa-fw fa-arrow-right"></i>
                <span>Ask</span>
            </button>
        </div>
        {!! Form::close() !!}
    @endslot
@endcomponent
