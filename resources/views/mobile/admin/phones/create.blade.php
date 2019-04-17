@extends('layout.master')

@section('title')
    Phones &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-tags"></i>
                Phones &middot; Create
            </h2>
        </div>
    </div>

    <br>

    {!! Form::open(['url' => '/admin/mobile/phones', 'role' => 'form', 'class' => 'form-horizontal']) !!}
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="col-sm-6">
                    <h3 class="panel-title">Details</h3>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    @include('mobile.admin.phones.forms.main')
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
