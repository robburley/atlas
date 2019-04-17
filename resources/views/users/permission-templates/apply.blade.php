@extends('layout.master')

@section('title')
    Permission Templates &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class=" m-t-5">
                <i class="fa fa-fw fa-users"></i>
                Apply Permission Template
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    {!! Form::open(['method'=> 'get','class' => 'form-inline']) !!}
                    <div class="row">
                        <div class="col-sm-4 p-b-10">
                            <div class="form-group">
                                {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}

                                {!! Form::text('name', request()->get('name'), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4 p-b-10">
                            <div class="form-group">
                                {!! Form::label('role_id', 'Role', ['class' => 'control-label']) !!}

                                {!! Form::select('role_id', FormPopulator::roles(), request()->get('role_id') , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4 p-b-10">
                            <div class="form-group">
                                {!! Form::label('office_id', 'Office', ['class' => 'control-label']) !!}

                                {!! Form::select('office_id', FormPopulator::offices(), request()->get('role_id') , ['class' => 'form-control', 'placeholder' => 'Please Select']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 p-b-10">
                            <div class="form-group">
                                {!! Form::label('created_from', 'Created From', ['class' => 'control-label']) !!}

                                {!! Form::text('created_from', request()->get('created_from') ?? null, ['class' => 'form-control datepicker', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4 p-b-10">
                            <div class="form-group">
                                {!! Form::label('created_to', 'Created To', ['class' => 'control-label']) !!}

                                {!! Form::text('created_to', request()->get('created_to') ?? null, ['class' => 'form-control datepicker', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-sm-4 p-b-10">
                            <button type="submit" class="btn btn-success btn-block" style="">Filter</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            {!! Form::open(['action' => ['Users\PermissionTemplateUserController@update', $template], 'method' => 'post', 'id' => 'apply-template-form']) !!}
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="checkAll"> Name
                                    </th>
                                    <th>Role</th>
                                    <th>office</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>
                                            <label>
                                                {!! Form::checkbox('users[]', $user->id, null,  ['id' => 'name']) !!}

                                                {{ $user->name }}
                                            </label>
                                        </td>
                                        <td>
                                            {{ $user->role->name or 'No Role' }}
                                        </td>
                                        <td>
                                            {{ $user->office->name or 'No Office' }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {!! Form::close() !!}


                            <a class="btn btn-success pull-right m-r-5" id="submit-form">
                                Apply Permissions
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function () {
            $("#checkAll").click(function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            $('#submit-form').click(function () {
                swal({
                        title: 'Are you sure?',
                        text: 'This will overwrite all permissions',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: 'Confirm',
                        cancelButtonText: 'Cancel',
                        closeOnConfirm: true,
                        closeOnCancel: true,
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $('#apply-template-form').submit()
                        }
                    })
            })
        })
    </script>
@endsection
