@extends('customers.layout')

@section('title')
    {{ $customer->company_name }} &middot; Atlas
@endsection

@section('page-title')
    {{ $customer->company_name }}
@endsection

@section('page-description')
    Win Win existing customer
@endsection

@section('subcontent')
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-hover members-table middle-align">
                <thead>
                    <tr>
                        <th>Site</th>
                        <th>Address</th>
                        <th>Head Office</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($customer->sites as $site)
                        <tr>

                            <td class="user-name">
                                {{ $site->name }}
                            </td>

                            <td class="user-name">
                                {{ $site->address1 }},
                                {{ $site->address2 }},
                                {{ $site->address3 }},
                                {{ $site->town }},
                                {{ $site->county }},
                                {{ $site->postcode }},
                            </td>

                            <td class="user-name">
                                {{ $site->head_office ? 'Yes' : 'No' }}
                            </td>

                            <td class="text-right">

                                <a href="/customers/{{ $customer->id }}/sites/{{ $site->id }}/edit" class="btn btn-sm btn-white btn-icon">
                                    <i class="fa fa-fw fa-edit"></i>
                                    <span>Edit</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <a href="/customers/{{ $customer->id }}/sites/create" class="btn btn-success btn-icon btn-icon-standalone pull-right">
        <i class="fa fa-fw fa-plus"></i>
        <span>Add</span>
    </a>

    @foreach ($customer->sites as $site)
        <div class="modal fade" id="site-{{ $site->id }}">
            <div class="modal-dialog border-top-success">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Site Card</h4>
                    </div>

                    <div class="modal-body">
                        <section class="profile-env m-b-0">
                            <div class="user-info-sidebar">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <span class="user-img">
                                            <img src="/assets/images/user-4.png" alt="user-img" class="img-cirlce img-responsive img-thumbnail">
                                        </span>

                                        <span class="user-name">
                                            {{ $site->title }}
                                            {{ $site->forename }}
                                            {{ $site->surname }}
                                        </span>

                                        <span class="user-title">{{ $site->job_title }}</span>
                                    </div>

                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>Landline Number</p>
                                            </div>

                                            <div class="col-sm-6">
                                                <p>{{ $site->landline_number }}</p>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>Mobile Number</p>
                                            </div>

                                            <div class="col-sm-6">
                                                <p>{{ $site->mobile_number }}</p>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>Email Address</p>
                                            </div>

                                            <div class="col-sm-6">
                                                <p>{{ $site->email_address }}</p>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>Description</p>
                                            </div>

                                            <div class="col-sm-6">
                                                <p>{{ $site->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="modal-footer">
                        <a href="/customers/{{ $customer->id }}/sites/{{ $site->id}}/edit" class="btn btn-primary">Edit</a>
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
