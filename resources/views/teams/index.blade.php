@extends('layout.master')

@section('title')
    Teams &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-team"></i>
                Teams
                <a href="/admin/teams/create" class="btn btn-success pull-right">
                    New Team
                </a>
            </h2>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Users</th>
                                    <th>Moderators</th>
                                    <th>Created at</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($teams as $team)
                                    <tr>
                                        <td class="v-mid">
                                            {{ $team->name }}
                                        </td>

                                        <td class="v-mid">
                                            {{ count($team->users) }}
                                        </td>

                                        <td class="v-mid">
                                            @if($team->moderators)
                                                {{ $team->moderators->implode(',') }}
                                            @else
                                                No Moderators
                                            @endif
                                        </td>

                                        <td class="v-mid">
                                            {{ $team->created_at->format('d/m/Y') }}
                                        </td>

                                        <td class="v-mid">
                                            <a href="/admin/teams/{{ $team->id }}/edit"
                                               class="btn btn-xs btn-white btn-icon">
                                                <i class="fa fa-fw fa-edit"></i>
                                                <span>Edit</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">There are currently no teams.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        {!! $teams->links() !!}
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
@endsection
