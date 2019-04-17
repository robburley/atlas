@extends('layout.master')

@section('title')
    Permission Templates &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-users"></i>
                Permission Templates
                <a href="/admin/users/permission-templates/create" class="btn btn-success pull-right">
                    New Template
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
                                    <th>Name</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($templates as $template)
                                    <tr>
                                        <td class="v-mid">
                                            {{ $template->name }}
                                        </td>

                                        <td class="v-mid">
                                            <a href="/admin/users/permission-templates/{{ $template->id }}/edit"
                                               class="btn btn-xs btn-white btn-icon">
                                                <i class="fa fa-fw fa-edit"></i>
                                                <span>Edit</span>
                                            </a>
                                            <a href="/admin/users/permission-templates/{{ $template->id }}/apply"
                                               class="btn btn-xs btn-white btn-icon">
                                                <i class="fa fa-fw fa-users"></i>
                                                <span>Apply to users</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">There are currently no templates.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
@endsection
