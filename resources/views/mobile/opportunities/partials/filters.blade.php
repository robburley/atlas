
    <div class="row">
        @if(auth()->user()->hasPermission('show_all_branch_opportunities_mobile') || auth()->user()->hasPermission('show_all_leads_mobile') || auth()->user()->hasPermission('show_all_appointment_leads_mobile') || (isset($subTitle) && ($subTitle == 'My Qualified Leads' || $subTitle == 'Team Awaiting Bill')))
            <div class="col-sm-10">
                <div class="panel panel-default border-top-purple">
                    <div class="panel-body">
                        {!! Form::open(['method'=> 'get','class' => 'form']) !!}
                        <div class="row">
                            @if((isset($status)  && $status->order < 4) || !isset($status))
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {!! Form::label('created', 'Created By', ['class' => 'control-label']) !!}
                                        {!! Form::select('created', FormPopulator::leadGenUsers(), request()->get('created') , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                                    </div>
                                </div>
                            @endif

                            @if((isset($status) && $status->order > 3) || !isset($status))
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {!! Form::label('assigned', 'Assigned To', ['class' => 'control-label']) !!}
                                        {!! Form::select('assigned', FormPopulator::allAssignableUsersMobile(), request()->get('assigned') , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                                    </div>
                                </div>
                            @endif

                            @if(auth()->user()->hasPermission('show_all_leads_mobile') || auth()->user()->hasPermission('show_all_appointment_leads_mobile'))
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {!! Form::label('office', 'Lead Generator Office', ['class' => 'control-label']) !!}

                                        {!! Form::select('office', [null => 'All'] + FormPopulator::offices()->toArray(), request()->get('office') , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {!! Form::label('assigned_office', 'Closer Office', ['class' => 'control-label']) !!}

                                        {!! Form::select('assigned_office', [null => 'All'] + FormPopulator::offices()->toArray(), request()->get('office') , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                                    </div>
                                </div>
                            @endif 

                            @if(!isset($status))
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {!! Form::label('no_bill', 'Bills and Requirements', ['class' => 'control-label']) !!}

                                        {!! Form::select('no_bill', [0 => 'Bills', 1 => 'Requirements'], request()->get('no_bill') , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                                    </div>
                                </div>
                            @endif

                            @if(auth()->user()->hasPermission('show_all_leads_mobile') && auth()->user()->hasPermission('show_all_appointment_leads_mobile'))
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {!! Form::label('appointment', 'Lead Type', ['class' => 'control-label']) !!}

                                        {!! Form::select('appointment', [null => 'Both', 0 => 'Non Appointment', 1 => 'Appointment'], request()->get('appointment') , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                                    </div>
                                </div>
                            @endif
                        </div>  

                        <div class="row">
                            <div class="col-sm-8">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('created_from', 'Created From', ['class' => 'control-label']) !!}

                                    {!! Form::text('created_from', request()->get('created_from') , ['class' => 'form-control datepicker', 'readonly']) !!}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('created_to', 'Created To', ['class' => 'control-label']) !!}

                                    {!! Form::text('created_to', request()->get('created_to') , ['class' => 'form-control datepicker', 'readonly']) !!}
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('appointment_from', 'Appointment From', ['class' => 'control-label']) !!}

                                    {!! Form::text('appointment_from', request()->get('appointment_from') , ['class' => 'form-control datepicker', 'readonly']) !!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('appointment_to', 'Appointment To', ['class' => 'control-label']) !!}

                                    {!! Form::text('appointment_to', request()->get('appointment_to') , ['class' => 'form-control datepicker', 'readonly']) !!}
                                </div>
                            </div>
                        </div>

                        @if((isset($status) && $status->won == 1) || (isset($subTitle) && $subTitle == 'Pipeline'))
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('dealt_from', 'Dealt From', ['class' => 'control-label']) !!}

                                        {!! Form::text('dealt_from', request()->get('dealt_from') , ['class' => 'form-control datepicker', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('dealt_to', 'Dealt To', ['class' => 'control-label']) !!}

                                        {!! Form::text('dealt_to', request()->get('dealt_to') , ['class' => 'form-control datepicker', 'readonly']) !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                            </div>
                            
                            <div class="col-sm-4">
                                @if(!isset($status))
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                {!! Form::label('mobile_opportunity_status_id', 'Status', ['class' => 'control-label']) !!}

                                                <select multiple="multiple" name="mobile_opportunity_status_id[]" class="form-control">
                                                    @foreach(FormPopulator::mobileStatuses() as $key => $value)
                                                        <option value="{{$key}}" @if(collect(request()->get('mobile_opportunity_status_id'))->contains($key)) selected @endif>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                {!! Form::label('blown', 'Blown', ['class' => 'control-label']) !!}

                                                {!! Form::checkbox('blown', 1, request()->get('blown')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                {!! Form::label('partially_connected', 'Partially Connected', ['class' => 'control-label']) !!}

                                                {!! Form::checkbox('partially_connected', 1, request()->get('partially_connected')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                {!! Form::label('connected', 'Fully Connected', ['class' => 'control-label']) !!}

                                                {!! Form::checkbox('connected', 1, request()->get('connected')) !!}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success pull-right" style="">Filter</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        @endif


        @if(isset($total) || $opportunities->count() > 0)
            <div class="col-sm-2">
                <div class="panel panel-default border-top-success">
                    <div class="panel-body text-center">
                        <h4>
                            Total Leads:
                            <br>

                            {{ isset($total) ? $total : $opportunities->total()  }}
                        </h4>
                    </div>
                </div>

                @if(auth()->user()->isAdmin())
                    <div class="panel panel-default border-top-success">
                        <div class="panel-body text-center">
                            <h4>
                                Total GP:
                                <br>

                                £{{ isset($totalGp) ? $totalGp : number_format($opportunities->sum('gp'), 2)  }}
                            </h4>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>