@extends('layout.master')

@section('title')
    Users &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-user"></i>
                Users &middot; {{ $template->name }}
            </h2>
        </div>
    </div>

    <br>

    {!! Form::model($template, ['url' => '/admin/users/permission-templates/' . $template->id, 'role' => 'form', 'class' => 'form-horizontal', 'method' => 'PATCH']) !!}
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="col-sm-12">
                    <h3 class="panel-title">Permissions</h3>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-12">
                    @include('users.permission-templates.forms.template')
                    @include('users.permission-templates.forms.permissions')
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
