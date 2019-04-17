@section('styles')
    @parent
    <style>
    </style>
@endsection

<div role="tabpanel" class="tab-pane" id="activity">
    <div class="row">
        <div class="col-xs-12">
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
                        <div class="col-xs-12">
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
                                                <strong><i class="fa fa-star text-warning"></i>{{ $closer->name }}
                                                </strong>
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
        <div class="col-xs-12">
            <h4>
                Fulfilment Timeline
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <h4>
                Opportunity
            </h4>

            <ul class="list-group list-group-minimal">
                @foreach($opportunity->fulfilmentTimeLineOpportunity as $item)
                    <li class="list-group-item">
                        <h4 class="list-group-item-heading">
                            {{ $item->action }}
                        </h4>
                        actioned by {{ $item->user->name }},
                        on {{ $item->created_at->format('d/m/Y') }}
                        at {{ $item->created_at->format('H:i') }}

                    </li>
                @endforeach
            </ul>
        </div>
        @foreach($opportunity->getGroupedTimeLine() as $id => $items)
            @if($items->first() &&  $items->first()->allocation)
                <div class="col-sm-4">
                    <h4>
                        {{ $items->first()->allocation->name }}
                    </h4>

                    <ul class="list-group list-group-minimal">
                        @foreach($items as $item)
                            <li class="list-group-item">

                                <h4 class="list-group-item-heading">
                                    {{ $item->action }}
                                </h4>

                                @if($item->user)
                                    actioned by {{ $item->user->name }},
                                    on {{ $item->created_at->format('d/m/Y') }}
                                    at {{ $item->created_at->format('H:i') }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endforeach

    </div>

    <hr style="border-color: #7c38bc;">

    <div class="row">
        <div class="col-xs-12">
            <h4>
                Notes
            </h4>

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
                            <div class="form-group">
                                {!! Form::select('responses', ['none' => 'Choose a predefined response', 'no-answer' => 'No Answer', 'decision-maker-not-available' => 'Decision maker not available'] , null , ['class' => 'form-control',  'id' => 'response-select']) !!}
                            </div>

                            {!! Form::open(['action' => ['Customer\CustomerNoteController@store', $customer->id], 'role' => 'form', 'class' => 'form-horizontal']) !!}
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::textarea('body', null, ['class' => 'form-control input-lg autogrow', 'rows' => 3, 'required', 'autocomplete' => 'off', 'id' => 'response-body']) !!}
                                    {!! $errors->first('body', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                </div>
                            </div>

                            <div class="row col-margin">
                                <div class="col-sm-3">
                                    {!! Form::select('customer_note_type_id', FormPopulator::customerNoteTypes(), null, ['class' => 'form-control select2', 'placeholder' => 'Choose a note type...']) !!}
                                    {!! $errors->first('customer_note_type_id', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                </div>

                                <div class="col-sm-3">
                                    @if(auth()->user()->hasPermission('notify_mobile'))
                                        {!! Form::select('notify_user_id', FormPopulator::users(), null, ['class' => 'form-control select2', 'placeholder' => 'Notify a colleague?']) !!}
                                    @endif
                                </div>

                                <div class="col-sm-6 text-right">
                                    {!! Form::hidden('notable_type', 'mobileOpportunity') !!}
                                    {!! Form::hidden('notable_id', $opportunity->id) !!}

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
                    @foreach($opportunity->activeCustomerNotes()->orderBy('created_at', 'desc')->get() as $note)
                        <li>
                            <time class="cbp_tmtime" datetime="{{ $note->created_at }}">
                                <span>{{ $note->created_at->format('H:i') }}</span>
                                <span>{{ $note->created_at->format('d/m/Y') }}</span>
                            </time>

                            <div class="cbp_tmicon timeline-bg-{{ $note->type->colour }}">
                                <i class="fa-{{ $note->type->icon }}"></i>
                            </div>

                            <div class="cbp_tmlabel">
                                @if(auth()->user()->isAdmin())
                                    {!! Form::open(['action' => ['Customer\CustomerNoteController@update', $customer, $note], 'method' => 'post']) !!}
                                    {!! Form::hidden('active', 0) !!}

                                    <button type="submit" class="btn btn-danger btn-xs pull-right">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    {!! Form::close() !!}

                                    <a href="javascript:;"
                                       onclick="jQuery('#edit-note-{{ $note->id }}').modal('show', {backdrop: 'fade'})"
                                       class="btn btn-white btn-xs pull-right"
                                    >
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                @endif

                                <h2>{{ $note->user->name ?? 'System' }} <span>{{ $note->type->past_tense }}</span>
                                </h2>
                                <p>{{ $note->body }}</p>

                            </div>
                        </li>

                        @if(auth()->user()->isAdmin())
                            @component('interface.components.modal')
                                @slot('modalId', 'edit-note-' . $note->id)
                                @slot('modelBorderClass', 'border-top-warning')
                                @slot('modalTitle', 'Edit Note')
                                @slot('modalBody')
                                    {!! Form::open(['action' => ['Customer\CustomerNoteController@update', $customer, $note], 'method' => 'post']) !!}
                                    <div class="row">
                                        <div class="col-sm-12">
                                            {!! Form::textarea('body', $note->body, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success pull-right">
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                @endslot
                            @endcomponent
                        @endif
                    @endforeach
                </ul>
            </section>
        </div>
    </div>

</div>

@section('scripts')
    @parent
    <script>
        $(document).ready(function () {
            $('#response-select').change(function () {
                let responses = [
                    {'key': 'none', 'response': ''},
                    {'key': 'no-answer', 'response': 'Called the customer, there was no answer'},
                    {'key': 'decision-maker-not-available', 'response': 'Decision maker not available, call again'},
                ]

                $('#response-body').val(_.find(responses, ['key', $(this).val()]).response)
            })
        })
    </script>
@endsection