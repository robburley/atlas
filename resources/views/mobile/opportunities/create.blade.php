@extends('customers.layout')

@section('title')
    New Mobile Opportunity &middot; {{ $customer->company_name }} &middot; Atlas
@endsection

@section('page-title')
    {{ $customer->company_name }}
@endsection

@section('page-description')
    New mobile opportunity
@endsection

@section('subcontent')
    {!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityController@store', $customer->id], 'role' => 'form', 'class' => 'form-horizontal']) !!}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-top-success">
                <div class="panel-heading">
                    <h3 class="panel-title">New Opportunity Details</h3>
                </div>

                <div class="panel-body">
                    @include('mobile.opportunities.forms.main')
                    @include('mobile.opportunities.forms.appointment-checkbox')
                </div>
            </div>
        </div>
    </div>

    @if(!auth()->user()->hasPermission('create_appointments_mobile'))
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default border-top-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Optional Details</h3>
                    </div>

                    <div class="panel-body">
                        @include('mobile.opportunities.forms.optional')
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div id="appointment-details">
        <div class="row" id="appointment-details">
            <div class="col-sm-12">
                <div class="panel panel-default border-top-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Appointment Details</h3>
                    </div>

                    <div class="panel-body">
                        @include('mobile.opportunities.forms.appointment')
                    </div>
                </div>
            </div>
        </div>

        @include('mobile.opportunities.forms.site')
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group text-right">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                        <i class="fa fa-fw fa-save"></i>
                        <span>Save</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
    @parent

    <script type="text/javascript">
        $('#appointment-time').datetimepicker({
            timeFormat: 'HH:mm:ss',
            showSecond: false,
        })

        $(document).ready(function () {

            $('#appointment-details').hide()

            $('#ht-closer').hide()

            $('select .select2-search').select2()

            $('select .select2').select2({
                minimumResultsForSearch: Infinity,
            })

            $('#appointment').click(function () {
                $('#appointment-details').toggle(this.checked)
            })

            $('#hot_transfer').click(function () {
                $('#ht-closer').toggle(this.checked)
            })
        })
    </script>

@endsection
