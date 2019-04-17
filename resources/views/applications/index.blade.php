@extends('layout.master')

@section('title')
    Applications &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-file"></i>
                Applications
                <a href="/recruitment/applications/create" class="btn btn-success pull-right">
                    New Application
                </a>
            </h2>
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
                                    <th>Applicant</th>
                                    <th>Location</th>
                                    <th>Email address</th>
                                    <th>Phone Number</th>
                                    <th>Created at</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($applications as $application)
                                    <tr>
                                        <td class="v-mid">
                                            {{ $application->applicant_name }}
                                        </td>

                                        <td class="v-mid">
                                            {{ $application->office->name or 'No office' }}
                                        </td>

                                        <td class="v-mid">
                                            {{ $application->email }}
                                        </td>

                                        <td class="v-mid">
                                            Landline: {{ $application->telephone }} <br>
                                            Mobile: {{ $application->mobile }}
                                        </td>

                                        <td class="v-mid">
                                            {{ $application->created_at->format('d/m/Y') }}
                                        </td>

                                        <td class="v-mid">
                                            <a href="/recruitment/applications/{{ $application->id }}"
                                               class="btn btn-xs btn-white btn-icon">
                                                <i class="fa fa-fw fa-search"></i>
                                                <span>View</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">There are currently no applications.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        {!! $applications->appends(['role_id' => request()->get('role_id'), 'created_from' => request()->get('created_from'), 'created_to' => request()->get('created_to')])->links() !!}
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
@endsection
