@extends('layout.master')

@section('title')
    HR Profiles &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-users"></i>
                HR Profiles
            </h2>
        </div>
    </div>

    <div class="row m-t-25">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Job Title</th>
                                    <th>Office</th>
                                    <th>Work Email</th>
                                    <th>Start Date</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($profiles as $profile)
                                    <tr>
                                        <td class="v-mid">
                                            {{ $profile->full_name }}
                                        </td>

                                        <td class="v-mid">
                                            {{ $profile->job_title }}
                                        </td>

                                        <td class="v-mid">
                                            {{ $profile->user->office->name or 'No Office Set' }}
                                        </td>

                                        <td class="v-mid">
                                            {{ $profile->work_email }}
                                        </td>

                                        <td class="v-mid">
                                            {{ $profile->start_date ? $profile->start_date->format('d/m/Y') : 'No Start Date Set' }}
                                        </td>

                                        <td class="v-mid">
                                            <a href="/admin/hr/{{ $profile->id }}"
                                               class="btn btn-xs btn-white btn-icon">
                                                <i class="fa fa-fw fa-search"></i>
                                                <span>View</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">There are currently no profiles.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        {!! $profiles->links() !!}
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
@endsection
