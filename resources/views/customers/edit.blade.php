@extends('customers.layout')

@section('title')
    Edit {{ $customer->company_name }} &middot; Atlas
@endsection

@section('page-title')
    Edit {{ $customer->company_name }}
@endsection

@section('page-description')
    Edit customer details
@endsection

@section('subcontent')
    {!! Form::model($customer, ['action' => ['Customer\CustomerController@update', $customer->id], 'role' => 'form', 'class' => 'form-horizontal']) !!}
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
    <script type="text/javascript">
        $(document).ready(function() {
            $("select .select2-search").select2();

            $("select .select2").select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>


@endsection
