<div role="tabpanel" class="tab-pane" id="activity">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-top-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="text-{{ $opportunity->status->colour == 'blue' ? 'info' : $opportunity->status->colour }}">
                            <i class="fa-user"></i> {{ $opportunity->status->name }}
                        </span>
                        | Closer History</h3>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table">
                                <thead>
                                <tr>
                                    <td>Closer Name</td>
                                    <td>Assigned At</td>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($opportunity->assigned as $closer)
                                    <tr>
                                        <td>
                                            @if($closer->pivot->active == 1)
                                                <strong><i class="fa fa-star text-warning"></i>{{ $closer->name }}</strong>
                                            @else
                                                {{ $closer->name }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $closer->pivot->created_at->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <section class="profile-env mailbox-env">
                <ul class="cbp_tmtimeline">
                    <li>
                        <time class="cbp_tmtime">
                            <span class="hidden">{{ FormPopulator::now() }}</span>
                            <span class="large">Now</span>
                        </time>

                        <div class="cbp_tmicon timeline-bg-gray">
                            <i class="fa fa-fw fa-comment-o"></i>
                        </div>

                        <div class="cbp_tmlabel p-b-0">
                            {!! Form::open(['action' => ['Customer\CustomerNoteController@store', $customer->id], 'role' => 'form', 'class' => 'form-horizontal']) !!}
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::textarea('body', null, ['class' => 'form-control input-lg autogrow', 'rows' => 3, 'required', 'autocomplete' => 'off']) !!}
                                    {!! $errors->first('body', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                </div>
                            </div>

                            <div class="row col-margin">
                                <div class="col-sm-3">
                                    {!! Form::select('customer_note_type_id', FormPopulator::customerNoteTypes(), null, ['class' => 'form-control select2', 'placeholder' => 'Choose a note type...']) !!}
                                    {!! $errors->first('customer_note_type_id', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                </div>

                                <div class="col-sm-3">
                                    {!! Form::select('notify_user_id', FormPopulator::users(), null, ['class' => 'form-control select2', 'placeholder' => 'Notify a colleague?']) !!}
                                </div>

                                <div class="col-sm-3">
                                    {!! Form::hidden('notable_type', 'fixedLineOpportunity') !!}
                                    {!! Form::hidden('notable_id', $opportunity->id) !!}
                                </div>

                                <div class="col-sm-3 text-right">
                                    <button type="submit"
                                            class="btn btn-success btn-icon btn-icon-standalone">
                                        <i class="fa fa-fw fa-plus"></i>
                                        <span>Add</span>
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </li>
                    @foreach($opportunity->customerNotes()->orderBy('created_at', 'desc')->get() as $note)
                        <li>
                            <time class="cbp_tmtime" datetime="{{ $note->created_at }}">
                                <span>{{ $note->created_at->format('H:i') }}</span>
                                <span>{{ $note->created_at->format('d/m/Y') }}</span>
                            </time>

                            <div class="cbp_tmicon timeline-bg-{{ $note->type->colour }}">
                                <i class="fa-{{ $note->type->icon }}"></i>
                            </div>

                            <div class="cbp_tmlabel">
                                <h2>{{ $note->user->name ?? 'System'  }} <span>{{ $note->type->past_tense }}</span>
                                </h2>
                                <p>{{ $note->body }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </section>
        </div>
    </div>

</div>