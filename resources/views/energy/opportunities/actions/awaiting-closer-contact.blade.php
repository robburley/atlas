<div class="row">
    <div class="col-sm-6">
        <h4>Is this opportunity Qualified?</h4>

        <a href="javascript:" onclick="jQuery('#update-opportunity-qualified').modal('show', {backdrop: 'fade'});"
           class="btn btn-block btn-success btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
            <i class="fa fa-thumbs-o-up"></i>
            <span>Qualified</span>
        </a>
    </div>
</div>

<hr>
<div class="row">
    <div class="col-sm-6">
        {!! Form::open(['action' => ['EnergyOpportunity\EnergyOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}

        <div class="form-group">
            <div class="col-sm-12">
                {!! Form::label('new_callback', 'Set Callback', ['class' => 'control-label']) !!}
                {!! Form::hidden('energy_opportunity_status_id', 6) !!}
                {!! Form::text('new_callback', null, ['class' => 'form-control', 'placeholder' => 'Set a preferred callback time...', 'id' => 'new-callback']) !!}
            </div>
        </div>

        <button type="submit" class="btn btn-success btn-icon btn-icon-standalone pull-right">
            <i class="fa fa-fw fa-upload"></i>
            <span>Update</span>
        </button>
        {!! Form::close() !!}
    </div>
</div>

@section('scripts')
    @parent
    <div class="modal fade" id="update-opportunity-qualified">
        <div class="modal-dialog border-top-success">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Qualify Opportunity</h4>
                </div>
                {!! Form::open(['action' => ['EnergyOpportunity\EnergyOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-sm-12">
                            {!! Form::label('qualified', 'Qualified', ['class' => 'control-label']) !!}
                            {!! Form::select('qualified', FormPopulator::yesNo() , null , ['class' => 'form-control', 'id' => 'qualification-status']) !!}

                            <div id="not-qualified">
                                <div id="blown-statuses"></div>
                                {!! Form::label('not_qualified_reason', 'Not Qualified Reason', ['class' => 'control-label']) !!}

                                {!! Form::text('not_qualified_reason', null , ['class' => 'form-control']) !!}
                            </div>
                            <div id="extra-info"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                        <i class="fa fa-fw fa-upload"></i>
                        <span>Update</span>
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#new-callback').datetimepicker({
            timeFormat: 'HH:mm:ss',
            showSecond: false,
            stepMinute: 5,
            hourMin: 5,
            hourMax: 22,
        });

        var html = '@include('energy.opportunities.actions.partials.blown-statuses')';

        $(function () {
            $('#not-qualified').hide();

            $('#qualification-status').change(function () {
                if($(this).val() == 0) {
                    $('#not-qualified').show();
                    $('#blown-statuses').html(html);
                } else {
                    $('#not-qualified').hide();
                    $('#blown-statuses').empty();
                }
            })
        });
    </script>
@endsection