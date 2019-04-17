@inject('formPopulator', 'App\Helpers\FormPopulator')

@extends('layout.master')

@section('title')
    HR Profile &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-users"></i>
                HR Profile &middot; {{ $profile->full_name }}
            </h2>
        </div>
        <div class="col-sm-8 text-right">

            <a href="javascript:;" onclick="jQuery('#upload-file').modal('show', {backdrop: 'fade'})"
               class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
                <i class="fa fa-file"></i>
                <span>Upload File</span>
            </a>

            <a href="/admin/hr/{{ $profile->id }}/edit"
               class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
                <i class="fa fa-pencil"></i>
            </a>
        </div>
    </div>

    <br>

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
                                        Name
                                    </td>
                                    <td>
                                        {{ $profile->full_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Address
                                    </td>
                                    <td>
                                        {{ $profile->address }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Gender
                                    </td>
                                    <td>
                                        {{ $profile->gender }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Marital Status
                                    </td>
                                    <td>
                                        {{ $profile->marital_status }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Date Of Birth
                                    </td>
                                    <td>
                                        {{ $profile->date_of_birth ? $profile->date_of_birth->format('d/m/Y') : 'No date of birth set' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Personal Email
                                    </td>
                                    <td>
                                        {{ $profile->personal_email }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Work Email
                                    </td>
                                    <td>
                                        {{ $profile->work_email }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Passport Number
                                    </td>
                                    <td>
                                        {{ $profile->passport_number }}
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
                                        {{ $profile->national_insurance }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Bank Account Number
                                    </td>
                                    <td>
                                        {{ $profile->bank_account_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Sort Code
                                    </td>
                                    <td>
                                        {{ $profile->sort_code }}
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
                                    <td>Start Date</td>
                                    <td>{{ $profile->start_date ? $profile->start_date->format('d/m/Y') : 'No start date set' }}</td>
                                </tr>
                                <tr>
                                    <td>Line Manager</td>
                                    <td>{{ $profile->lineManager->name or 'No Line Manager'}}</td>
                                </tr>
                                <tr>
                                    <td>Job Title</td>
                                    <td>{{ $profile->job_title }}</td>
                                </tr>
                                <tr>
                                    <td>salary</td>
                                    <td>{{ $profile->salary }}</td>
                                </tr>
                                <tr>
                                    <td>Probation Period</td>
                                    <td>{{ $profile->probation_period }}</td>
                                </tr>
                                <tr>
                                    <td>Employee Number</td>
                                    <td>{{ $profile->employee_number }}</td>
                                </tr>
                                <tr>
                                    <td>Hours of Work</td>
                                    <td>{{ $profile->hours_of_work }}</td>
                                </tr>
                                <tr>
                                    <td>Employee Type</td>
                                    <td>{{ $profile->employee_type }}</td>
                                </tr>
                                <tr>
                                    <td>Office</td>
                                    <td>{{ $profile->user->office->name or 'No Office Set' }}</td>
                                </tr>
                                <tr>
                                    <td>Company</td>
                                    <td>{{ $profile->company }}</td>
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
                            Files
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Type
                                    </th>
                                    <th>
                                    </th>
                                </tr>
                                @foreach($profile->files as $file)
                                    <tr>
                                        <td>
                                            {{ $file->name }}
                                        </td>
                                        <td>
                                            {{ $file->type }}
                                        </td>
                                        <td>
                                            <a href="/admin/hr/{{ $profile->id }}/files/{{ $file->id }}/" class="btn btn-success">
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>
    <br>

@endsection

@section('scripts')

    @component('interface.components.modal')
        @slot('modalId', 'upload-file')
        @slot('modelBorderClass', 'border-top-success')
        @slot('modalTitle', 'Upload File')
        @slot('modalBody')
            {!! Form::open(['action' => ['Users\HrProfileFileController@store', $profile], 'files' => true, 'role' => 'form', 'class' => 'form-horizontal']) !!}
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::file('file', ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::select('type', $formPopulator->hrFileTypes() , null , ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                    <i class="fa fa-fw fa-upload"></i>
                    <span>Upload</span>
                </button>
            </div>
            {!! Form::close() !!}
        @endslot
    @endcomponent

@endsection
