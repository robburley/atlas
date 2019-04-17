@extends('layout.master')

@section('title')
    Search &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-search "></i>
                Search - {{ $searchTerm }}
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
                            <table class="table table-hover members-table middle-align">
                                <thead>
                                <tr>
                                    <th class="hidden-xs hidden-sm"></th>
                                    <th>Customer</th>
                                    <th>Telephone Number</th>
                                    <th>Created by</th>
                                    <th>Created at</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach ($results as $result)
                                    <tr>
                                        <td class="user-image hidden-xs hidden-sm">
                                            <img src="/assets/images/user-1.png" class="img-circle" alt="user-pic">
                                        </td>

                                        <td class="user-name">
                                            <a href="/customers/{{ $result->id }}" class="name">
                                                {{ $result->company_name }}
                                            </a>
                                        </td>

                                        <td>
                                            {{ $result->telephone_number }}
                                        </td>

                                        <td>
                                            {{ $result->creator->name }}
                                        </td>

                                        <td>
                                            {{ $result->created_at->format('jS F Y') }}
                                        </td>

                                        <td class="text-right">
                                            <a href="/customers/{{ $result->id }}" class="btn btn-sm btn-white btn-icon">
                                                <i class="fa fa-fw fa-search"></i>
                                                <span>View</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $results->appends(['input' => request()->get('input')])->links() }}
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
@endsection
