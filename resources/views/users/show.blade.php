@extends('layout.master')

@section('title')
    Users &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-user"></i>
                Users &middot; {{ $user->name }}
            </h2>
        </div>
        <div class="col-sm-8 text-right">
            {!! Form::open(['action' => 'Users\HrProfileController@store', 'method' => 'post', 'class' => 'form form-inline']) !!}

            @if(!$user->hrProfile)
                {!! Form::hidden('user_id', $user->id) !!}
                <button class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
                    <i class="fa fa-users"></i>
                    <span>Create HR Profile</span>
                </button>
            @endif
            <a href="javascript:;" onclick="jQuery('#reassign-calendar').modal('show', {backdrop: 'fade'})"
               class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
                <i class="fa fa-calendar"></i>
                <span>Reassign Calendar</span>
            </a>
            <a href="/admin/users/{{ $user->id }}/edit"
               class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
                <i class="fa fa-pencil"></i>
            </a>
            {!! Form::close() !!}
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Details
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <td>
                                Name
                            </td>
                            <td>
                                {{ $user->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Username
                            </td>
                            <td>
                                {{ $user->username }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Email
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Role
                            </td>
                            <td>
                                {{ $user->role->name or 'No Role'}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Office
                            </td>
                            <td>
                                {{ $user->office->name or 'No Office Set'}}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Stats
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <td>

                            </td>
                            <td>

                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <calendar user_id="{{ $user->id }}"></calendar>
@endsection

@section('scripts')

    @component('interface.components.modal')
        @slot('modalId', 'reassign-calendar')
        @slot('modelBorderClass', 'border-top-success')
        @slot('modalTitle', 'Reassign All Calender Events')
        @slot('modalBody')
            {!! Form::open(['action' => ['Calendar\EventsController@reassign', $user], 'files' => true, 'role' => 'form', 'class' => 'form-horizontal']) !!}
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::select('user_id', FormPopulator::allUsers() , null , ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                    <i class="fa fa-fw fa-upload"></i>
                    <span>Reassign</span>
                </button>
            </div>
            {!! Form::close() !!}
        @endslot
    @endcomponent
@endsection
