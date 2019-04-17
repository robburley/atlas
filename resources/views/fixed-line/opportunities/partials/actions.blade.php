<div role="tabpanel" class="tab-pane active" id="actions">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-top-success">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="text-{{ $opportunity->status->colour == 'blue' ? 'info' : $opportunity->status->colour }}">
                            <i class="fa-user"></i> {{ $opportunity->status->name }}
                        </span>
                        | Actions
                    </h3>
                </div>

                <div class="panel-body">
                    @if(PermissionHelper::fixedLineShowPermissions($opportunity))
                        @include('fixed-line.opportunities.actions.' . $opportunity->status->slug)
                    @elseif($opportunity->status->blown == 1)
                        @include('fixed-line.opportunities.actions.blown')
                    @else
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>
                                    This opportunity is currently
                                    <span class="text-{{ $opportunity->status->colour }}">{{ $opportunity->status->name  }} </span>
                                    Please check back soon for an update
                                </h4>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default border-top-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        @if(!$opportunity->appointment)
                            Point Of Contact
                        @else
                            Appointment Details
                        @endif
                    </h3>
                    @if($opportunity->appointment)
                        <a href="javascript:;"
                           onclick="jQuery('#update-appointment-time').modal('show', {backdrop: 'fade'})"
                           class="btn btn-success btn-xs pull-right">
                            Update Appointment
                        </a>
                    @endif
                </div>

                <div class="panel-body text-center">
                    @if(!$opportunity->appointment)
                        @foreach($opportunity->customer->contacts()->where('decision_maker', 1)->get() as $contact)
                            {{  $contact->title  . ' ' . $contact->forename  . ' ' . $contact->surname }}
                            <br>
                            {{  $contact->mobile_number or $contact->landline_number }}<br>
                            {{  $contact->email_address }}<br>
                            <hr>
                        @endforeach
                    @else
                        @foreach($opportunity->appointments as $appointment)
                            <strong>Date and Time:</strong>
                            {{ $appointment->time ? $appointment->time->format('d/m/Y H:i') : 'Not Set' }}
                            <br>

                            <strong>Contact:</strong>
                            {{ $appointment->contact ? $appointment->contact->full_name : 'Not Set' }}
                            <br>

                            <strong>Address:</strong>
                            {{ $appointment->site ? $appointment->site->address : 'Not Set' }}
                            <br>

                            @if($appointment->contact)
                                @if($appointment->contact->landline_number)
                                    <strong>Landline Number</strong>
                                    {{ $appointment->contact->landline_number }}
                                    <br>
                                @endif
                                @if($appointment->contact->mobile_number)
                                    <strong>Mobile Number</strong>
                                    {{  $appointment->contact->mobile_number }}
                                    <br>
                                @endif
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default border-top-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">Files</h3>

                    @if(auth()->user()->hasPermission('upload_files_fixed_line') && $opportunity->status->id <= $fixedLineOpportunityStatusHelper->get('awaiting-provisioning') )
                        <a href="javascript:"
                           onclick="jQuery('#upload-file').modal('show', {backdrop: 'fade'})"
                           class="btn btn-xs btn-success pull-right"
                        >
                            <span>Upload File</span>
                        </a>
                    @endif
                </div>

                <div class="panel-body text-center">
                    @foreach($opportunity->files as $file)
                        @if(! $file->type->permission || auth()->user()->hasPermission($file->type->permission->slug))
                            @if((! collect([5, 13])->contains($file->type->id) && auth()->user()->role_id == 5) || auth()->user()->role_id != 5)
                                <div class="row">
                                    <div class="btn-group btn-block" role="group" aria-label="...">
                                        <a href=" {{ action('Customer\CustomerFileController@show', [$customer, $file])  }}"
                                           class="btn btn-white" style="width:90%;">
                                            <span>{{ $file->type->name }}</span>
                                        </a>

                                        @if(auth()->user()->hasPermission('delete_files_fixed_line'))
                                            <a href=" {{ action('Customer\CustomerFileController@destroy', [$customer, $file])  }}"
                                               class="btn btn-danger" style="width:10%;">
                                                <i class="fa fa-close"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @if($opportunity->commercials)
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default border-top-purple">
                    <div class="panel-heading">
                        <h3 class="panel-title">Proposal</h3>
                    </div>

                    <div class="panel-body">

                        {!! Form::open(['action' => ['FixedLineOpportunity\ProposalController@show', $customer, $opportunity], 'method' => 'post', 'target' => '_blank']) !!}
                        <button type="submit" class="btn btn-success btn-block">
                            Download Proposal
                        </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="@if($opportunity->welcomeCall) col-sm-6 @else col-sm-12 @endif">
            <div class="panel panel-default border-top-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">Callbacks</h3>
                </div>

                <div class="panel-body">
                    @php
                        $count = $opportunity->callbacks()->orderBy('time', 'desc')->count();

                        $callbacks =  $opportunity->callbacks()->orderBy('time', 'desc')->get()->chunk($count > 1 ?  $count / 2 : 1) ;
                    @endphp

                    <div class="row">
                        @foreach($callbacks as $chunk)
                            <div class="col-sm-6">
                                @foreach($chunk as $callback)
                                    <p>
                                        @if($callback->isComplete())
                                            <s>
                                                @endif
                                                {{ $callback->assignedUser->name or 'A User' }}
                                                - {{ $callback->time->format('d/m/Y H:i') }}
                                                @if($callback->isComplete())
                                            </s>
                                        @else
                                            <span class="pull-right">
                                            <a href="/customers/{{ $callback->opportunity->customer->id }}/fixed-line/opportunities/{{ $callback->opportunity->id }}/callbacks/{{ $callback->id }}/edit">
                                                <i class="fa fa-clock-o text-info"
                                                   title="Rearrange"></i>
                                            </a>

                                            <a href="/customers/{{ $callback->opportunity->customer->id }}/fixed-line/opportunities/{{ $callback->opportunity->id }}/callbacks/{{ $callback->id }}/destroy">
                                                <i class="fa fa-check text-success"
                                                   title="Complete"></i>
                                            </a>
                                        </span>
                                        @endif
                                    </p>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        @if($welcomeCall = $opportunity->welcomeCall)
            <div class="col-sm-6">
                <div class="panel panel-default border-top-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Welcome Call</h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <strong>User: </strong>
                                {{ $welcomeCall->user->name or 'None Set' }}
                            </div>
                            <div class="col-sm-4">
                                <strong>Created: </strong>
                                {{ $welcomeCall->created_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="col-sm-4">
                                <strong>Updated: </strong>
                                {{ $welcomeCall->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <strong>Phone Number: </strong>
                                {{ $welcomeCall->telephone }}
                            </div>
                            <div class="col-sm-8">
                                <strong>Notes: </strong>
                                {{ $welcomeCall->notes }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>