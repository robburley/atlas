@extends('layout.master')

@section('title')
    Reports &middot; Fulfilment Overview &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-file-text-o"></i>
                Fulfilment Overview
            </h2>
        </div>
    </div>

    <br>

    @if(auth()->user()->isAdmin())
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-wrapper">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="col-sm-2">Status</th>
                                        <th>Number of Deals</th>
                                        <th>Net Income</th>
                                        <th>Board GP</th>
                                        <th>Management GP</th>
                                        <th>Company GP</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($data as $status => $stats)
                                        <tr>
                                            <th>{{ $status }}</th>
                                            <td>{{ $stats['count'] ?? 0 }}</td>
                                            <td>£{{ number_format($stats['income'] ?? 0, 2) }}</td>
                                            <td>£{{ number_format($stats['boardGp'] ?? 0, 2) }}</td>
                                            <td>£{{ number_format($stats['managementGp'] ?? 0, 2) }}</td>
                                            <td>£{{ number_format($stats['companyGp'] ?? 0, 2) }}</td>
                                        </tr>

                                        @if(array_key_exists('secondary', $stats))
                                            @foreach($stats['secondary'] as $status => $stats)
                                                <tr>
                                                    <td style="padding-left:25px;">- {{ $status }}</td>
                                                    <td>{{ $stats['count'] ?? 0 }}</td>
                                                    <td>£{{ number_format($stats['income'] ?? 0, 2) }}</td>
                                                    <td>£{{ number_format($stats['boardGp'] ?? 0, 2) }}</td>
                                                    <td>£{{ number_format($stats['managementGp'] ?? 0, 2) }}</td>
                                                    <td>£{{ number_format($stats['companyGp'] ?? 0, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
