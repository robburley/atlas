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
                        <th class="hidden-xs hidden-sm"></th>
                        <th>Contact</th>
                        <th>Site</th>
                        <th>Description</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($customer->contacts as $contact)
                        <tr>
                            <td class="user-image hidden-xs hidden-sm">
                                <a href="#">
                                    <img src="/assets/images/user-1.png" class="img-circle" alt="user-pic">
                                </a>
                            </td>

                            <td class="user-name">
                                <a href="#" class="name">
                                    {{ $contact->title }}
                                    {{ $contact->forename }}
                                    {{ $contact->surname }}
                                </a>

                                <span>{{ $contact->job_title }}</span>
                            </td>

                            <td>
                                {{ $contact->site->name or 'None' }}
                            </td>

                            <td>
                                {{ $contact->description }}
                            </td>

                            <td>
                                {{ $contact->decision_maker ? 'Decision Maker, ' : null }} {{ $contact->finance_contact ? 'Finance Contact, ' : null }} {{ $contact->technical_contact ? 'Technical Contact' : null }}
                            </td>

                            <td class="text-right">
                                <a href="javascript:;" onclick="jQuery('#contact-{{ $contact->id }}').modal('show', {backdrop: 'static'});" class="btn btn-sm btn-white btn-icon">
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

    <a href="/customers/{{ $customer->id }}/contacts/create" class="btn btn-success btn-icon btn-icon-standalone pull-right">
        <i class="fa fa-fw fa-plus"></i>
        <span>Add</span>
    </a>

    @foreach ($customer->contacts as $contact)
        <div class="modal fade" id="contact-{{ $contact->id }}">
            <div class="modal-dialog border-top-success">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Contact Card</h4>
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
                                            {{ $contact->title }}
                                            {{ $contact->forename }}
                                            {{ $contact->surname }}
                                        </span>

                                        <span class="user-title">{{ $contact->job_title }}</span>
                                    </div>

                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>Landline Number</p>
                                            </div>

                                            <div class="col-sm-6">
                                                <p>{{ $contact->landline_number }}</p>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>Mobile Number</p>
                                            </div>

                                            <div class="col-sm-6">
                                                <p>{{ $contact->mobile_number }}</p>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>Email Address</p>
                                            </div>

                                            <div class="col-sm-6">
                                                <p>{{ $contact->email_address }}</p>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>Description</p>
                                            </div>

                                            <div class="col-sm-6">
                                                <p>{{ $contact->description }}</p>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>Site</p>
                                            </div>

                                            <div class="col-sm-6">
                                                <p>{{ $contact->site->name or 'None' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="modal-footer">
                        <a href="/customers/{{ $customer->id }}/contacts/{{ $contact->id}}/edit" class="btn btn-primary">Edit</a>
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
