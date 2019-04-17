@extends('layout.master')

@section('title')
    Create Customer &middot; Atlas
@endsection

@section('content')
    <div class="page-title">
        <div class="title-env">
            <h1 class="title">Create Customer</h1>
            <p class="description">Add a new customer to the Win Win database</p>
        </div>
    </div>

    <div class="alert alert-warning">
        <i class="fa fa-fw fa-warning"></i> <strong>Warning!</strong>

        The customer you wish to add may already exist. Please select an existing customer, or continue to create a new customer.
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Search Results</h3>
        </div>

        <div class="panel-body">
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

    <div class="panel panel-inverted">
        <div class="panel-heading">
            <h3 class="panel-title">Unable to find your customer?</h3>
        </div>

        <div class="panel-body">
            If you are certain that none of the customers above match the customer you wish to add, continue to add a new customer.

            <a href="/customers/create/{{ $company }}/{{ $telephone }}" class="btn btn-success btn-icon btn-icon-standalone pull-right">
                <i class="fa fa-fw fa-arrow-right"></i>
                <span>Continue</span>
            </a>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
