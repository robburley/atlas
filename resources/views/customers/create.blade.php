@extends('layout.master')

@section('title')
    Create {{ $company or 'Customer' }} &middot; Atlas
@endsection

@section('content')
    <div class="page-title">
        <div class="title-env">
            <h1 class="title">Create {{ $company or 'Customer' }}</h1>
            <p class="description">Add a new customer to the Win Win database</p>
        </div>
    </div>

    {!! Form::open(['url' => '/customers/create', 'role' => 'form', 'class' => 'form-horizontal']) !!}
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default border-top-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Customer Details</h3>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            {!! Form::label('company_name', 'Company Name', ['class' => 'col-sm-2 control-label']) !!}

                            <div class="col-sm-10">
                                {!! Form::text('company_name', isset($company) ? $company : null, ['class' => 'form-control', 'required', 'autofocus', 'autocomplete' => 'off']) !!}

                                {!! $errors->first('company_name', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            {!! Form::label('telephone_number', 'Telephone Number', ['class' => 'col-sm-2 control-label']) !!}

                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-fw fa-phone"></i>
                                    </span>

                                    {!! Form::text('telephone_number', isset($telephone) ? $telephone : null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}
                                </div>

                                {!! $errors->first('telephone_number', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('website', 'Website', ['class' => 'col-sm-2 control-label']) !!}

                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-fw fa-home"></i>
                                    </span>

                                    {!! Form::text('website', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                                </div>

                                {!! $errors->first('website', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('customers.contacts.form')

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group text-right">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                                <i class="fa fa-fw fa-save"></i>
                                <span>Save</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    {!! Form::close() !!}
@endsection

@section('scripts')

@endsection
