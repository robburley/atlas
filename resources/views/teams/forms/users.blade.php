<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="col-sm-12">
                <h3 class="panel-title">
                    Users

                    <a href="javascript:" onclick="jQuery('#add-user').modal('show', {backdrop: 'fade'});"
                       class="btn btn-success btn-icon btn-icon-standalone btn-icon-standalone-right pull-right">
                        <i class="fa fa-user"></i>
                        <span>Add User</span>
                    </a>
                </h3>
            </div>
        </div>
        <div class="panel-body">

            <div class="table-wrapper">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Moderator</th>
                            <th>Added at</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($team->users as $user)
                            <tr>
                                <td class="v-mid">
                                    {{ $user->name }}
                                </td>

                                <td class="v-mid">
                                    {{ $user->pivot->moderator ? 'Yes' : 'No' }}
                                </td>

                                <td class="v-mid">
                                    {{ $user->pivot->created_at->format('d/m/Y') }}
                                </td>

                                <td class="v-mid">
                                    <a href="/teams/{{ $team->id }}/users/{{ $user->id }}/remove"
                                       class="btn btn-xs btn-danger btn-icon">
                                        <i class="fa fa-fw fa-remove"></i>
                                        <span>Remove</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    There are currently no users in this team.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@section('scripts')
    @parent
    @component('interface.components.modal')
        @slot('modalId', 'add-user')
        @slot('modelBorderClass', 'border-top-success')
        @slot('modalTitle', 'Add user to team')
        @slot('modalBody')
            {!! Form::open(['action' => ['Users\TeamUserController@store', $team], 'files' => true, 'role' => 'form', 'class' => 'form-horizontal']) !!}
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::label('user_id', 'User', ['class' => 'control-label']) !!}
                        {!! Form::select('user_id', FormPopulator::leadGenUsers() , null , ['class' => 'form-control', 'id' => 'qualification-status']) !!}

                        {!! Form::label('moderator', 'Moderator', ['class' => 'control-label']) !!}
                        {!! Form::select('moderator', FormPopulator::yesNo() , 0, ['class' => 'form-control', 'id' => 'qualification-status']) !!}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                    <i class="fa fa-fw fa-upload"></i>
                    <span>Add</span>
                </button>
            </div>
            {!! Form::close() !!}
        @endslot
    @endcomponent
@endsection
