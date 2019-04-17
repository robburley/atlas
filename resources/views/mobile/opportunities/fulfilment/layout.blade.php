@inject('mobileOpportunityStatusHelper', 'App\Helpers\MobileOpportunityStatusHelper')

@extends('customers.layout')

@section('title')
    Mobile Opportunity &middot; {{ $customer->company_name }} &middot; Atlas
@endsection

@section('page-title')
    {{ $customer->company_name }}
@endsection

@section('page-description')
    Mobile opportunity
@endsection

@section('subcontent')
    <div class="row">
        <div class="col-sm-4">
            <h3 class="m-b-0 m-t-5">
                @include('mobile.opportunities.partials.icons')

                {{ $opportunity->activeAssigned->first() ? $opportunity->activeAssigned->first()->name : '' }}
            </h3>
        </div>
        @include('mobile.opportunities.partials.controls')
    </div>

    <div class="row">
        <div class="col-sm-9">
            {{--col-sm-offset-3--}}
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#actions" aria-controls="home" role="tab" data-toggle="tab">
                        Actions
                    </a>
                </li>

                {{--<li role="presentation">--}}
                {{--<a href="#info" aria-controls="profile" role="tab" data-toggle="tab">--}}
                {{--Info--}}
                {{--</a>--}}
                {{--</li>--}}

                <li role="presentation">
                    <a href="#activity" aria-controls="profile" role="tab" data-toggle="tab">
                        Activity
                    </a>
                </li>

                @if($opportunity->activeDealCalculator->count() > 0 && auth()->user()->hasPermission('use_deal_calc_mobile'))
                    <li role="presentation">
                        <a href="#deal-calc" aria-controls="profile" role="tab" data-toggle="tab">
                            Deal Calculator
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="row">
        {{--@include('mobile.opportunities.partials.statuses')--}}
        <div class="col-sm-12">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="actions">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default border-top-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                        <span class="text-{{ $opportunity->status->colour == 'blue' ? 'info' : $opportunity->status->colour }}">
                            <i class="fa-user"></i> {{ $opportunity->status->name }}
                        </span>
                                        | Actions
                                    </h3>
                                </div>

                                <div class="panel-body">
                                    @yield('fulfilment-content')
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('mobile.opportunities.partials.actions-info')
                </div>

                @include('mobile.opportunities.partials.info')
                @include('mobile.opportunities.partials.activity')
                @include('mobile.opportunities.partials.deal-calculators')
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    @parent

    @include('mobile.opportunities.partials.modals')

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

                @if(auth()->user()->isAdmin())
        let editButton = $('#editDealCalcButton');
        let showButton = $('#showDealCalcButton');
        let editDiv = $('#edit-deal-calc');
        let showDiv = $('#show-deal-calc');

        editDiv.hide();
        showButton.hide();

        editButton.click(function (e) {
            e.preventDefault();

            editDiv.slideDown();

            showDiv.slideUp();

            editButton.hide();

            showButton.show();
        });

        showButton.click(function (e) {
            e.preventDefault();

            showDiv.slideDown();

            editDiv.slideUp();

            showButton.hide();

            editButton.show();
        });
        @endif
    </script>

@endsection