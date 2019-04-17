@extends('layout.master')

@section('title')
    Users &middot; Atlas
@endsection

@section('content')
    <div class="page-title">
        <div class="title-env">
            <p class="description">
                <i class="fa fa-fw fa-file"></i> Application for
            </p>
            <h2 class="title">
                {{ $application->applicant_name }}
            </h2>
        </div>
        <div class="breadcrumb-env text-right">
            <a href="/recruitment/applications/{{ $application->id }}/edit"
               class="breadcrumb btn btn-icon {{ request()->is('/recruitment/applications/{{ $application->id/edit') ? 'btn-black' : 'btn-white' }}">
                <i class="fa fa-edit"></i>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Position Details</h3>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table">
                                <tr>
                                    <td>
                                        <strong>Location:</strong>
                                    </td>
                                    <td>
                                        {{ $application->office ? $application->office->name : 'No Office Supplied' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Position:</strong>
                                    </td>
                                    <td>
                                        {{ $application->position ? $application->position->name : 'No Position Supplied' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Personal Details</h3>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table">
                                <tr>
                                    <td>
                                        <strong>Full Name:</strong>
                                    </td>
                                    <td>
                                        {{ $application->applicant_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Email Address:</strong>
                                    </td>
                                    <td>
                                        {{ $application->email }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Landline Number:</strong>
                                    </td>
                                    <td>
                                        {{ $application->telephone }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Mobile Number:</strong>
                                    </td>
                                    <td>
                                        {{ $application->mobile }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Date of Birth:</strong>
                                    </td>
                                    <td>
                                        {{ $application->date_of_birth }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Children:</strong>
                                    </td>
                                    <td>
                                        {{ $application->children ? 'Yes' : 'No' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Married:</strong>
                                    </td>
                                    <td>
                                        {{ $application->married ? 'Yes' : 'No' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Commitments:</strong>
                                    </td>
                                    <td>
                                        {{ $application->commitments }}
                                    </td>
                                </tr>
                                @if($application->files()->first())
                                    <tr>
                                        <td>
                                            <strong>CV</strong>
                                        </td>
                                        <td>
                                            <a href="/recruitment/applications/{{ $application->id }}/files/{{ $application->files()->first()->id }}"
                                               class="btn  btn-success">Download CV</a>
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Previous Employment</h3>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table">
                                <tr>
                                    <td>
                                        <strong>Experience:</strong>
                                    </td>
                                    <td>
                                        {{ $application->experience }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Current Job Role:</strong>
                                    </td>
                                    <td>
                                        {{ $application->current_role }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Reason for change:</strong>
                                    </td>
                                    <td>
                                        {{ $application->change_reason }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Best Job:</strong>
                                    </td>
                                    <td>
                                        {{ $application->best_job }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Biggest Achievement:</strong>
                                    </td>
                                    <td>
                                        {{ $application->biggest_achievement }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Professional Characteristics</h3>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table">
                                <tr>
                                    <td>
                                        <strong>Drive:</strong>
                                    </td>
                                    <td>
                                        {{ $application->drive }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Bring to Business:</strong>
                                    </td>
                                    <td>
                                        {{ $application->bring_to_business }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Reason Suitable:</strong>
                                    </td>
                                    <td>
                                        {{ $application->suitable_reason }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Best Attributes:</strong>
                                    </td>
                                    <td>
                                        {{ $application->best_attributes }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Areas of Development:</strong>
                                    </td>
                                    <td>
                                        {{ $application->development_areas }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Confidence Level:</strong>
                                    </td>
                                    <td>
                                        {{ $application->confidence}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

@endsection

@section('scripts')
@endsection
