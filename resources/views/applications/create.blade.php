@extends('layout.master')

@section('title')
    Application &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-user"></i>
                Application &middot; Create
            </h2>
        </div>
    </div>

    <br>

    {!! Form::open(['url' => '/recruitment/applications', 'role' => 'form', 'class' => 'form-horizontal', 'files' => true]) !!}
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="col-sm-6">
                    <h3 class="panel-title">Position Details</h3>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-12">
                    @include('applications.forms.position')
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="col-sm-6">
                    <h3 class="panel-title">Personal Details</h3>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-12">
                    @include('applications.forms.personal')
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="col-sm-6">
                    <h3 class="panel-title">Previous Employment</h3>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-12">
                    @include('applications.forms.employment')
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="col-sm-6">
                    <h3 class="panel-title">Professional Characteristics</h3>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-12">
                    @include('applications.forms.professional')
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group text-right">
                <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                    <i class="fa fa-fw fa-save"></i>
                    <span>Save</span>
                </button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#office_id').change(function () {
                console.log($(this).val());
                getPositions($(this).val());
            });
        });


        function getPositions(office) {
            $.get("/api/positions/" + office, function (data) {
                var positionSelect = $('#position');

                positionSelect.empty().append($('<option>', {
                    value: null,
                    text: 'Please Select'
                }));
                $.each(data, function (key, value) {
                    positionSelect.append($('<option>', {
                        value: key,
                        text: value
                    }));
                });
            });
        }
    </script>
@endsection
