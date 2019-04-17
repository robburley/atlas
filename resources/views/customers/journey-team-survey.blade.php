@extends('customers.layout')

@section('title')
    Journey Team Survey &middot; {{ $customer->company_name }} &middot; Atlas
@endsection

@section('page-title')
    {{ $customer->company_name }}
@endsection

@section('page-description')
    Journey Team Survey
@endsection

@section('subcontent')
    <div class="row">
        <div class="col-sm-3">
            @if(auth()->user()->hasPermission('create_mobile'))
                <a href="/customers/{{ $customer->id }}/journey-team-survey/create"
                   class="btn btn-block btn-info btn-icon btn-icon-standalone btn-icon-standalone-right">
                    <i class="fa fa-plus"></i>
                    <span>New Survey</span>
                </a>
            @endif
        </div>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Journey Team Surveys</h3>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Sections Complete</th>
                            <th>Created by</th>
                            <th>Created at</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($customer->journeyTeamSurveys as $survey)
                            <tr>
                                <td class="v-mid">{{ $survey->sectionsComplete() }} / {{ $survey->sectionsCount() }}</td>

                                <td class="v-mid">{{ $survey->creator->name }}</td>

                                <td class="v-mid">{{ $survey->created_at->format('d/m/Y') }}</td>

                                @if(auth()->user()->hasPermission('read_mobile'))
                                    <td class="v-mid text-right">
                                        <a href="/customers/{{ $customer->id }}/journey-team-survey/{{ $survey->id }}"
                                           class="btn btn-xs btn-white btn-icon">
                                            <i class="fa fa-fw fa-edit"></i>
                                            <span>Edit</span>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">There are currently no journey team surveys for this customer.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
