@inject('fixedLineOpportunityStatusHelper', 'App\Helpers\FixedLineOpportunityStatusHelper')


@extends('customers.layout')

@section('title')
    Fixed Line Opportunity &middot; {{ $customer->company_name }} &middot; Atlas
@endsection

@section('page-title')
    {{ $customer->company_name }}
@endsection

@section('page-description')
    Fixed Line opportunity
@endsection

@section('subcontent')
    <div class="row">
        <div class="col-sm-4">
            <h3 class="m-b-0 m-t-5">
                @include('fixed-line.opportunities.partials.icons')

                {{ $opportunity->activeAssigned->first() ? $opportunity->activeAssigned->first()->name : '' }}
            </h3>
        </div>
        @include('fixed-line.opportunities.partials.controls')
    </div>

    <div class="row">
        <div class="col-sm-12">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#actions" aria-controls="home" role="tab" data-toggle="tab">
                        Actions
                    </a>
                </li>

                <li role="presentation">
                    <a href="#info" aria-controls="profile" role="tab" data-toggle="tab">
                        Info
                    </a>
                </li>

                <li role="presentation">
                    <a href="#activity" aria-controls="profile" role="tab" data-toggle="tab">
                        Activity
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="tab-content">
                @include('fixed-line.opportunities.partials.actions')
                @include('fixed-line.opportunities.partials.info')
                @include('fixed-line.opportunities.partials.activity')
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    @include('fixed-line.opportunities.partials.modals')

    <script type="text/javascript">
        $('#set-callback-time').datetimepicker({
            timeFormat: 'HH:mm:ss',
            showSecond: false,
            stepMinute: 5,
            hourMin: 5,
            hourMax: 22,
        });

        $('#appointment-time').datetimepicker({
            timeFormat: 'HH:mm:ss',
            showSecond: false,
            stepMinute: 5,
            hourMin: 5,
            hourMax: 22,
        });

        $(".monthDatepicker").datepicker({
            dateFormat: 'mm/yy',
            changeMonth: true,
            changeYear: true,
            maxDate: "+0",
            yearRange: "1900:2100"
        });

        $(".dayDatepicker").datepicker({
            format: 'dd/mm/yyyy',
            changeMonth: true,
            changeYear: true,
            maxDate: "-18y",
            yearRange: "1900:2100"
        });
    </script>

@endsection