<div class="form-group">
    {!! Form::label('appointment_info[time]', 'Date and time', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        {!! Form::text('appointment_info[time]', null, ['class' => 'form-control', 'id' => 'appointment-time', 'readonly']) !!}

        {!! $errors->first('appointment_info[time]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('appointment_info[contact_id]', 'Contact', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        {!! Form::select('appointment_info[contact_id]', $customer->getContacts(), null , ['class' => 'form-control', 'placeholder' => 'Please Select', 'id' => 'contact_select']) !!}

        {!! $errors->first('appointment_info[contact_id]', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
    <div class="col-sm-12 text-right">

        <a href="javascript:" onclick="jQuery('#add-contact').modal('show', {backdrop: 'fade'});"
           class="btn btn-info btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
            <i class="fa fa-user"></i>
            <span>Add Contact</span>
        </a>
    </div>
</div>


@section('scripts')
    @parent

    <div class="modal fade" id="add-contact">
        <div class="modal-dialog border-top-success">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Add Contact</h4>
                </div>
                {!! Form::open(['url' => '', 'files' => true, 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'add-contact-form']) !!}
                <div class="modal-body">
                    @include('customers.contacts.form')
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

    <script>
        $(document).ready(function () {
            $('#add-contact-form').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ url('/customers/' . $customer->id . '/contacts') }}",
                    headers: {"Accept": "application/json"},
                    data: $('#add-contact-form').serialize(),
                    type: 'POST'
                }).success(function (data) {
                    $('#contact_select').append($('<option>', {
                        value: data.id,
                        text : capitalizeFirstLetter(data.forename) + ' ' + capitalizeFirstLetter(data.surname)
                    }));
                });

                $('#add-contact').modal('toggle');
            });

            function capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }
        });
    </script>
@endsection
