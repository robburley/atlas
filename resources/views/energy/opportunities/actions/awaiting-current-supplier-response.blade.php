@if(count($opportunity->currentSupplierResponse) == 0)
    <div class="row">
        <div class="col-sm-6">
            <h4>Upload the current supplier response</h4>

            <a href="javascript:" onclick="jQuery('#upload-response').modal('show', {backdrop: 'fade'});"
               class="btn btn-block btn-info btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
                <i class="fa fa-upload"></i>
                <span>Upload Response</span>
            </a>
        </div>
    </div>

    <br>
@endif

<div class="row">
    <div class="col-sm-12">
        <a href="javascript:" onclick="jQuery('#add-meter').modal('show', {backdrop: 'fade'});"
           class="btn btn-success btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0 pull-right">
            <i class="fa fa-upload"></i>
            <span>Add New Meter</span>
        </a>

        <a href="javascript:" onclick="jQuery('#add-existing-meter').modal('show', {backdrop: 'fade'});"
           class="btn btn-success btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0 pull-right m-r-10">
            <i class="fa fa-upload"></i>
            <span>Add Existing Meter</span>
        </a>

        @foreach($errors->messages() as $key => $error)
            <p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> {{ $error[0] }}</p>
        @endforeach

        <table class="table">
            <thead>
            <tr>
                <th>Site</th>
                <th>Meter Type</th>
                <th>Meter Number</th>
                <th>Usage</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($opportunity->meters as $meter)
                <tr>
                    <td class="v-mid">{{ $meter->site->name }}</td>
                    <td class="v-mid">{{ $meter->type }}</td>
                    <td class="v-mid">
                        Top: {{ $meter->top_line }} <br>
                        Bottom: {{ $meter->bottom_line }}
                    </td>
                    <td class="v-mid">
                        <i class="fa fa-fw fa-sort-numeric-asc" data-toggle="tooltip" data-placement="top"
                           title="Quantity"></i> {{ $meter->quantity }} <br>
                        <i class="fa fa-fw fa-sun-o" data-toggle="tooltip" data-placement="top"
                           title="Day Rate"></i> {{ $meter->day_rate }} <br>
                        <i class="fa fa-fw fa-moon-o" data-toggle="tooltip" data-placement="top"
                           title="Night Rate"></i> {{ $meter->night_rate }} <br>
                        <i class="fa fa-fw fa-gbp" data-toggle="tooltip" data-placement="top"
                           title="Standing Charge"></i> {{ $meter->current_standing_charge }} <br>
                    </td>
                    <td class="v-mid">
                        {!! Form::open(['action' => ['EnergyOpportunity\EnergyOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
                        {{ Form::hidden('detach_meter', $meter->id) }}

                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-fw fa-close"></i>
                        </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Please add a meter</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        @if(count($opportunity->meters) > 0 && count($opportunity->currentSupplierResponse) > 0)
            {!! Form::open(['action' => ['EnergyOpportunity\EnergyOpportunityController@update', $customer->id, $opportunity->id], 'role' => 'form', 'class' => 'form-horizontal']) !!}

            {!! Form::hidden('energy_opportunity_status_id', 8) !!}
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
    @component('interface.components.modal')
        @slot('modalId', 'upload-response')
        @slot('modelBorderClass', 'border-top-success')
        @slot('modalTitle', 'Upload current supplier response')
        @slot('modalBody')
            {!! Form::open(['action' => ['Customer\CustomerFileController@store', $customer], 'files' => true, 'role' => 'form', 'class' => 'form-horizontal']) !!}
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::file('file', ['class' => 'form-control']) !!}
                        {!! Form::hidden('customer_file_type_id', 9) !!}
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