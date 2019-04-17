@extends('layout.master')

@section('title')
    Teams &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-user"></i>
                Teams &middot; Create
            </h2>
        </div>
    </div>

    <br>

    {!! Form::open(['url' => '/admin/teams', 'role' => 'form', 'class' => 'form-horizontal']) !!}
    <div class="row">
        <div class="panel panel-default border-top-success">
            <div class="panel-heading">
                <div class="col-sm-6">
                    <h3 class="panel-title">Details</h3>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    @include('teams.forms.team')
                </div>
                <div class="col-sm-12">
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                            <i class="fa fa-fw fa-save"></i>
                            <span>Save</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
@endsection
