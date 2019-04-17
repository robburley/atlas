<div class="row">
    <div class="col-md-6">
        @if($opportunity->appointment)
            <h4>Has this appointment been sat?</h4>
        @else
            <h4>Is this opportunity Qualified?</h4>
        @endif
        <a href="javascript:"
           onclick="jQuery('#update-opportunity-qualified').modal('show', {backdrop: 'fade'});"
           class="btn btn-block btn-success btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
            <i class="fa fa-thumbs-o-up"></i>

            @if($opportunity->appointment)
                <span>Sat</span>
            @else
                <span>Qualified</span>
            @endif
        </a>
    </div>
    @if(!$opportunity->appointment)
        <div class="col-md-6">
            {!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}

            <div class="form-group">
                <div class="col-sm-12">
                    {!! Form::label('new_callback', 'Set Callback', ['class' => 'control-label']) !!}
                    {!! Form::hidden('mobile_opportunity_status_id', 5) !!}
                    {!! Form::text('new_callback', null, ['class' => 'form-control', 'placeholder' => 'Set a preferred callback time...', 'id' => 'new-callback']) !!}
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-icon btn-icon-standalone pull-right">
                <i class="fa fa-fw fa-upload"></i>
                <span>Update</span>
            </button>
            {!! Form::close() !!}
        </div>
    @endif
</div>


@section('scripts')
    @parent

    <div class="modal fade" id="update-opportunity-qualified">
        <div class="modal-dialog  modal-wide border-top-success">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    @if($opportunity->appointment)
                        <h4 class="modal-title">Confirm Appointment</h4>
                    @else
                        <h4 class="modal-title">Qualify Opportunity</h4>
                    @endif
                </div>
                {!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer, $opportunity], 'role' => 'form', 'class' => 'form-horizontal']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-sm-12">


                            <div class="form-group">
                                <div class="col-sm-12">
                                    @if($opportunity->appointment)
                                        {!! Form::label('qualified', 'Confirmed', ['class' => 'control-label']) !!}
                                    @else
                                        {!! Form::label('qualified', 'Qualified', ['class' => 'control-label']) !!}
                                    @endif

                                    {!! Form::select('qualified', FormPopulator::yesNo() , null , ['class' => 'form-control', 'id' => 'qualification-status']) !!}
                                </div>
                            </div>

                            <div id="not-qualified">
                                <div id="blown-statuses"></div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        {!! Form::label('not_qualified_reason', 'Not Qualified Reason', ['class' => 'control-label']) !!}

                                        {!! Form::textarea('not_qualified_reason', null , ['class' => 'form-control', 'id' => 'blown_not_qualified_reason', 'rows' => 3]) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        {!! Form::label('new_callback', 'Set Callback', ['class' => 'control-label']) !!}
                                        {!! Form::text('new_callback', null, ['class' => 'form-control datetimepicker', 'placeholder' => 'Set a preferred callback time...', 'id' => 'blown-callback']) !!}
                                    </div>
                                </div>
                            </div>
                            <div id="extra-info"></div>

                            @if($opportunity->appointment)
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4>Mobile</h4>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                {!! Form::label('other_services[mobile][status]', 'Status', ['class' => 'control-label']) !!}

                                                {!! Form::select('other_services[mobile][status]', ['Sold' => 'Sold', 'Rearrange' => 'Rearrange', 'Blown' => 'Blown'] , null , ['class' => 'form-control', 'id' => 'mobile_status_select']) !!}
                                            </div>
                                        </div>
                                        <div id="mobile-info" class="hidden">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    {!! Form::label('other_services[mobile][description]', 'Description', ['class' => 'control-label']) !!}

                                                    {!! Form::textarea('other_services[mobile][description]', null , ['class' => 'form-control', 'id' => 'mobile_description', 'rows' => 3]) !!}
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    {!! Form::label('other_services[mobile][rearranged_at]', 'Revist Date Time', ['class' => 'control-label']) !!}

                                                    {!! Form::text('other_services[mobile][rearranged_at]', null, ['class' => 'form-control datetimepicker', 'placeholder' => 'Set a revisit time...',  'id' => 'mobile_rearranged_at']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4>Fixed Line</h4>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                {!! Form::label('other_services[fixed_line][status]', 'Status', ['class' => 'control-label']) !!}

                                                {!! Form::select('other_services[fixed_line][status]', ['Sold' => 'Sold', 'Rearrange' => 'Rearrange', 'Blown' => 'Blown'] , null , ['class' => 'form-control', 'id' => 'fixed_line_status_select']) !!}
                                            </div>
                                        </div>
                                        <div id="fixed-line-info" class="hidden">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    {!! Form::label('other_services[fixed_line][description]', 'Description', ['class' => 'control-label']) !!}

                                                    {!! Form::textarea('other_services[fixed_line][description]', null , ['class' => 'form-control', 'id' => 'fixed_line_description', 'rows' => 3]) !!}
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    {!! Form::label('other_services[fixed_line][rearranged_at]', 'Revist Date Time', ['class' => 'control-label']) !!}

                                                    {!! Form::text('other_services[fixed_line][rearranged_at]', null, ['class' => 'form-control datetimepicker', 'placeholder' => 'Set a revisit time...', 'id' => 'fixed_line_rearranged_at']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4>Broadband</h4>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                {!! Form::label('other_services[broadband][status]', 'Status', ['class' => 'control-label']) !!}

                                                {!! Form::select('other_services[broadband][status]', ['Sold' => 'Sold', 'Rearrange' => 'Rearrange', 'Blown' => 'Blown'] , null , ['class' => 'form-control', 'id' => 'broadband_status_select']) !!}
                                            </div>
                                        </div>
                                        <div id="broadband-info" class="hidden">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    {!! Form::label('other_services[broadband][description]', 'Description', ['class' => 'control-label']) !!}

                                                    {!! Form::textarea('other_services[broadband][description]', null , ['class' => 'form-control', 'id' => 'broadband_description', 'rows' => 3]) !!}
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    {!! Form::label('other_services[broadband][rearranged_at]', 'Revist Date Time', ['class' => 'control-label']) !!}

                                                    {!! Form::text('other_services[broadband][rearranged_at]', null, ['class' => 'form-control datetimepicker', 'placeholder' => 'Set a revisit time...', 'id' => 'broadband_rearranged_at']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
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

        $('#appointment-time').datetimepicker({
            timeFormat: 'HH:mm:ss',
            showSecond: false,
            stepMinute: 5,
            hourMin: 5,
            hourMax: 22,
        });

        var html = '@include('mobile.opportunities.actions.partials.blown-statuses')';

        $(function () {
            $('#not-qualified').hide();

            $('#qualification-status').change(function () {
                if ($(this).val() == 0) {
                    $('#not-qualified').show();
                    $('#blown-statuses').html(html);
                    $('#blown-callback').prop('required', true);
                    $('#blown_not_qualified_reason').prop('required', true);
                } else {
                    $('#not-qualified').hide();
                    $('#blown-statuses').empty();
                    $('#blown-callback').prop('required', false);
                    $('#blown_not_qualified_reason').prop('required', false);
                }
            });

            $('#mobile_status_select').change(function () {
                if ($(this).val() === 'Sold') {
                    $('#mobile-info').addClass('hidden');
                    $('#mobile_description').prop('required', false);
                    $('#mobile_rearranged_at').prop('required', false);
                } else {
                    $('#mobile-info').removeClass('hidden');
                    $('#mobile_description').prop('required', true);
                    $('#mobile_rearranged_at').prop('required', true);
                }
            });

            $('#fixed_line_status_select').change(function () {
                if ($(this).val() === 'Sold') {
                    $('#fixed-line-info').addClass('hidden');
                    $('#fixed_line_description').prop('required', false);
                    $('#fixed_line_rearranged_at').prop('required', false);
                } else {
                    $('#fixed-line-info').removeClass('hidden');
                    $('#fixed_line_description').prop('required', true);
                    $('#fixed_line_rearranged_at').prop('required', true);
                }
            });

            $('#broadband_status_select').change(function () {
                if ($(this).val() === 'Sold') {
                    $('#broadband-info').addClass('hidden');
                    $('#broadband_description').prop('required', false);
                    $('#broadband_rearranged_at').prop('required', false);
                } else {
                    $('#broadband-info').removeClass('hidden');
                    $('#broadband_description').prop('required', true);
                    $('#broadband_rearranged_at').prop('required', true);
                }
            });


        });
    </script>
@endsection