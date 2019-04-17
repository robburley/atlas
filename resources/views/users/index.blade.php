@extends('layout.master')

@section('title')
    Users &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-user"></i>
                Users
                <a href="/admin/users/create" class="btn btn-success pull-right">
                    New User
                </a>
                <a href="/admin/users{{ $active ? '-inactive' : '' }}"
                   class="btn btn-{{ $active ? 'danger' : 'success' }} pull-right" style="margin-right:10px;">
                    {{ $active ? 'Inactive' : 'Active' }}
                </a>
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    {!! Form::open(['method'=> 'get','class' => 'form-inline']) !!}
                    <div class="row">
                        <div class="col-sm-4 p-b-10">
                            <div class="form-group">
                                {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}

                                {!! Form::text('name', request()->get('name'), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4 p-b-10">
                            <div class="form-group">
                                {!! Form::label('role_id', 'Role', ['class' => 'control-label']) !!}

                                {!! Form::select('role_id', FormPopulator::roles(), request()->get('role_id') , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 p-b-10">
                            <div class="form-group">
                                {!! Form::label('created_from', 'Created From', ['class' => 'control-label']) !!}

                                {!! Form::text('created_from', request()->get('created_from') ?? null, ['class' => 'form-control datepicker', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4 p-b-10">
                            <div class="form-group">
                                {!! Form::label('created_to', 'Created To', ['class' => 'control-label']) !!}

                                {!! Form::text('created_to', request()->get('created_to') ?? null, ['class' => 'form-control datepicker', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-sm-4 p-b-10">
                            <button type="submit" class="btn btn-success btn-block" style="">Filter</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email address</th>
                                    <th>Role</th>
                                    <th>Office</th>
                                    <th>Created at</th>
                                    <th>Last Log In</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="v-mid">
                                            @if($user->isAdmin())
                                                <i class="fa fa-star"></i>
                                            @endif

                                            {{ $user->name }}

                                            @if(auth()->user()->hasPermission('manage_hr'))
                                                @if(!$user->hrProfile)
                                                    <i class="fa fa-exclamation-circle text-danger"
                                                       title="has no HR Profile"></i>
                                                @endif
                                            @endif
                                        </td>

                                        <td class="v-mid">
                                            {{ $user->username }}
                                        </td>

                                        <td class="v-mid">
                                            {{ $user->email }}
                                        </td>

                                        <td class="v-mid">
                                            {{ $user->role->name or 'No Role' }}
                                        </td>

                                        <td class="v-mid">
                                            {{ $user->office->name or 'No Office' }}
                                        </td>

                                        <td class="v-mid">
                                            {{ $user->created_at->format('d/m/Y') }}
                                        </td>

                                        <td class="v-mid">
                                            @if($attempt = $user->successfulLogInAttempts()->first())
                                                {{ $attempt->created_at ? $attempt->created_at->format('d/m/Y H:i') : 'No Log in logged' }}
                                            @endif
                                        </td>

                                        <td class="v-mid">
                                            <a href="/admin/users/{{ $user->id }}"
                                               class="btn btn-xs btn-white btn-icon">
                                                <i class="fa fa-fw fa-search"></i>
                                                <span>View</span>
                                            </a>
                                            {{--<a href="/admin/users/{{ $user->id }}/edit"--}}
                                            {{--class="btn btn-xs btn-white btn-icon">--}}
                                            {{--<i class="fa fa-fw fa-edit"></i>--}}
                                            {{--<span>Edit</span>--}}
                                            {{--</a>--}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">There are currently no users.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        {!! $users->appends(['role_id' => request()->get('role_id'), 'created_from' => request()->get('created_from'), 'created_to' => request()->get('created_to')])->links() !!}
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
@endsection
