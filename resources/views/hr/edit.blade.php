@inject('formPopulator', 'App\Helpers\FormPopulator')

@extends('layout.master')

@section('title')
    HR Profile &middot; Edit &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-user"></i>
                HR Profile &middot; {{ $profile->full_name }}
            </h2>
        </div>
    </div>

    <br>

    {!! Form::model($profile, ['url' => '/admin/hr/' . $profile->id, 'role' => 'form', 'class' => 'form-horizontal', 'method' => 'PATCH']) !!}

    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Personal Details
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        Title
                                    </td>
                                    <td>
                                        {!! Form::select('title', ['Mr' => 'Mr', 'Miss' => 'Miss', 'Mrs' => 'Mrs', 'Other' => 'Other'], null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('username', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        First Name
                                    </td>
                                    <td>
                                        {!! Form::text('first_name', null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('first_name', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Middle Name (s)
                                    </td>
                                    <td>
                                        {!! Form::text('middle_names', null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('middle_names', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Last Name
                                    </td>
                                    <td>
                                        {!! Form::text('last_name', null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('last_name', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Address Line 1
                                    </td>
                                    <td>
                                        {!! Form::text('address_1', null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('address_1', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Address Line 2
                                    </td>
                                    <td>
                                        {!! Form::text('address_2', null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('address_2', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Address Line 3
                                    </td>
                                    <td>
                                        {!! Form::text('address_3', null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('address_3', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Address Line 4
                                    </td>
                                    <td>
                                        {!! Form::text('address_4', null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('address_4', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Address Line 4
                                    </td>
                                    <td>
                                        {!! Form::text('address_4', null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('address_4', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Postcode
                                    </td>
                                    <td>
                                        {!! Form::text('postcode', null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('postcode', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Gender
                                    </td>
                                    <td>
                                        {!! Form::select('gender', ['Male' => 'Male', 'Female' => 'Female'], null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('gender', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Marital Status
                                    </td>
                                    <td>
                                        {!! Form::select('marital_status', ['Married' => 'Married', 'Single' => 'Single', 'Divorced' => 'Divorced', 'Widowed' => 'Widowed'], null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('marital_status', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Date Of Birth
                                    </td>
                                    <td>
                                        {!! Form::text('date_of_birth', null, ['class' => 'form-control dayDatepicker', 'readonly']) !!}

                                        {!! $errors->first('date_of_birth', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Personal Email
                                    </td>
                                    <td>
                                        {!! Form::text('personal_email', null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('personal_email', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Work Email
                                    </td>
                                    <td>
                                        {!! Form::text('work_email', null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('work_email', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Passport Number
                                    </td>
                                    <td>
                                        {!! Form::text('passport_number', null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('passport_number', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Finance Details
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <tr>

                                </tr>
                                <tr>
                                    <td>
                                        National Insurance Number
                                    </td>
                                    <td>
                                        {!! Form::text('national_insurance', null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('national_insurance', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Bank Account Number
                                    </td>
                                    <td>
                                        {!! Form::text('bank_account_number', null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('bank_account_number', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Sort Code
                                    </td>
                                    <td>
                                        {!! Form::text('sort_code', null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('sort_code', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Role Details
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        Start Date
                                    </td>
                                    <td>
                                        {!! Form::text('start_date', null, ['class' => 'form-control datepicker', 'readonly']) !!}

                                        {!! $errors->first('start_date', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Line Manager
                                    </td>
                                    <td>
                                        {!! Form::select('line_manager', $formPopulator->allUsers(), null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('line_manager', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Job Title
                                    </td>
                                    <td>
                                        {!! Form::text('job_title', null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('job_title', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Salary
                                    </td>
                                    <td>
                                        {!! Form::number('salary', null, ['class' => 'form-control', 'min' => '0', 'step' => '0.01']) !!}

                                        {!! $errors->first('salary', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Probation Period (months)
                                    </td>
                                    <td>
                                        {!! Form::number('probation_period', null, ['class' => 'form-control', 'min' => '0', 'step' => 1]) !!}

                                        {!! $errors->first('probation_period', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Employee Number
                                    </td>
                                    <td>
                                        {!! Form::text('employee_number', null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('employee_number', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Hours of Work (per week)
                                    </td>
                                    <td>
                                        {!! Form::number('hours_of_work', null, ['class' => 'form-control', 'min' => '0', 'step' => 1]) !!}

                                        {!! $errors->first('hours_of_work', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Employee Type
                                    </td>
                                    <td>
                                        {!! Form::select('employee_type', ['Staff' => 'Staff', 'Contactor' => 'Contactor'], null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('employee_type', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Business
                                    </td>
                                    <td>
                                        {!! Form::select('company', ['LGH' => 'LGH', 'WinWin' => 'WinWin'], null, ['class' => 'form-control']) !!}

                                        {!! $errors->first('company', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group text-right">
                <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                    <i class="fa fa-fw fa-save"></i>
                    <span>Save</span>
                </button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script>
        $('.dayDatepicker').datepicker({
            format: 'dd/mm/yyyy',
            changeMonth: true,
            changeYear: true,
            maxDate: '-14y',
            yearRange: '1950:2100',
        })
    </script>
@endsection
