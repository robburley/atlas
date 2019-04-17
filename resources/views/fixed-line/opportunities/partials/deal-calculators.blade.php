@if($opportunity->activeDealCalculator->count() > 0 && auth()->user()->hasPermission('awaiting_commercials_fixed_line'))
    <div role="tabpanel" class="tab-pane" id="deal-calc">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default border-top-purple">
                    <div class="panel-heading">
                        @if(auth()->user()->hasPermission('edit_deal_calc_fixed_line'))
                            <a class="btn btn-info pull-right" id="editDealCalcButton"> Edit</a>
                            <a class="btn btn-info pull-right" id="showDealCalcButton"> Show</a>
                        @endif
                    </div>

                    <div class="panel-body">
                        @if(auth()->user()->hasPermission('edit_deal_calc_fixed_line'))
                            <div id="edit-deal-calc">
                                <deal-calc :customer="{{ $customer->id }}"
                                           :opportunity="{{ $opportunity->id }}"
                                ></deal-calc>
                            </div>
                        @endif
                        <div id="show-deal-calc">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="text-dark v-mid">
                                        Deal Calculators
                                    </h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table">
                                        <tr>
                                            <th>
                                                Name
                                            </th>
                                            <th>
                                                Details
                                            </th>
                                            <th></th>
                                        </tr>
                                        @foreach($opportunity->activeDealCalculator as $dealCalculator)
                                            <tr>
                                                <td>
                                                    {{ $dealCalculator->name }}
                                                </td>
                                                <td>
                                                    Created by {{ $dealCalculator->creator->name }}
                                                    on {{ $dealCalculator->created_at->format('d/m/Y')}}
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary btn-inline" role="button"
                                                       data-toggle="collapse"
                                                       href="#deal-calc-{{ $dealCalculator->id }}"
                                                       aria-expanded="false"
                                                       aria-controls="collapseExample">
                                                        show / hide
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>

                            @foreach($opportunity->activeDealCalculator as $dealCalculator)
                                <div class="collapse" id="deal-calc-{{ $dealCalculator->id }}">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4 class="text-dark">
                                                {{ $dealCalculator->name }}
                                            </h4>
                                        </div>
                                    </div>

                                    {{--Primary--}}
                                    @if($dealCalculator->primaryConnections->count() > 0)
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="text-dark">Primary Connections</h4>
                                                <table class="table table-responsive border-top-success">
                                                    <thead>
                                                    <tr>
                                                        <th>Type</th>
                                                        <th class="col-xs-3">Tariff</th>
                                                        <th>Contract Term</th>
                                                        <th>Connections</th>
                                                        <th>GP</th>
                                                        <th>Commission</th>
                                                        <th>Cost</th>
                                                        <th>Total</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($dealCalculator->primaryConnections as $primaryConnection)
                                                        <tr>
                                                            <td class="v-mid">{{ $primaryConnection->getType() }}</td>
                                                            @if($primaryConnection->tariff)
                                                                <td class="v-mid">{{ $primaryConnection->tariff->getName() }}</td>
                                                            @else
                                                                <td class="v-mid">{{ $primaryConnection->tariff_name }}</td>
                                                            @endif
                                                            <td class="v-mid "> {{ $primaryConnection->term }}</td>
                                                            <td class="v-mid">{{ $primaryConnection->connections }}</td>
                                                            <td class="v-mid">
                                                                £{{ $primaryConnection->gp }}</td>
                                                            <td class="v-mid">
                                                                £{{ $primaryConnection->commission }}</td>
                                                            <td class="v-mid">
                                                                £{{ $primaryConnection->cost }}</td>
                                                            <td class="v-mid">
                                                                £{{ $primaryConnection->total }}</td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <hr>
                                    @endif

                                    {{--Secondary--}}
                                    @if($dealCalculator->secondaryConnections->count() > 0)
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="text-dark">Secondary Connections</h4>
                                                <table class="table table-responsive border-top-warning">
                                                    <thead>
                                                    <tr>
                                                        <th>Type</th>
                                                        <th class="col-xs-3">Tariff</th>
                                                        <th>Contract Term</th>
                                                        <th>Connections</th>
                                                        <th>GP</th>
                                                        <th>Commission</th>
                                                        <th>Cost</th>
                                                        <th>Total</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($dealCalculator->secondaryConnections as $secondaryConnection)
                                                        <tr>
                                                            <td class="v-mid">{{ $secondaryConnection->getType() }}</td>
                                                            @if($secondaryConnection->tariff)
                                                                <td class="v-mid">{{ $secondaryConnection->tariff->getName() }}</td>
                                                            @else
                                                                <td class="v-mid">{{ $secondaryConnection->tariff_name }}</td>
                                                            @endif
                                                            <td class="v-mid "> {{ $secondaryConnection->term }}</td>
                                                            <td class="v-mid">{{ $secondaryConnection->connections }}</td>
                                                            <td class="v-mid">
                                                                £{{ $secondaryConnection->gp }}</td>
                                                            <td class="v-mid">
                                                                £{{ $secondaryConnection->commission }}</td>
                                                            <td class="v-mid">
                                                                £{{ $secondaryConnection->cost }}</td>
                                                            <td class="v-mid">
                                                                £{{ $secondaryConnection->total }}</td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <hr>
                                    @endif

                                    {{--Contributions--}}
                                    @if($dealCalculator->contributions->count() > 0)
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="text-dark">Customer Contributions</h4>
                                                <table class="table table-responsive border-top-danger">
                                                    <thead>
                                                    <tr>
                                                        <th>Tariff</th>
                                                        <th>Value</th>
                                                        <th>Units</th>
                                                        <th>Commission</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($dealCalculator->contributions  as $contributions)
                                                        <tr>
                                                            <td class="v-mid">{{ $contributions->name }}</td>
                                                            <td class="v-mid">{{ $contributions->value }}</td>
                                                            <td class="v-mid "> {{ $contributions->units }}</td>
                                                            <td class="v-mid">
                                                                £{{ $contributions->total }}</td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <hr>
                                    @endif

                                    {{--Handsets--}}
                                    @if($dealCalculator->handsets->count() > 0)
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="text-dark">Handset Costs</h4>
                                                <table class="table table-responsive border-top-info">
                                                    <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Value</th>
                                                        <th>Units</th>
                                                        <th>Commission</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($dealCalculator->handsets  as $handsets)
                                                        <tr>
                                                            <td class="v-mid">{{ $handsets->name }}</td>
                                                            <td class="v-mid">{{ $handsets->value }}</td>
                                                            <td class="v-mid "> {{ $handsets->units }}</td>
                                                            <td class="v-mid">
                                                                £{{ $handsets->total }}</td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <hr>
                                    @endif

                                    {{--Accessories--}}
                                    @if($dealCalculator->accessories->count() > 0)
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="text-dark">Accessory Costs</h4>
                                                <table class="table table-responsive border-top-purple">
                                                    <thead>
                                                    <tr>
                                                        <th>Manufacturer & Model</th>
                                                        <th>Value</th>
                                                        <th>Units</th>
                                                        <th>Total</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($dealCalculator->accessories  as $accessory)
                                                        <tr>
                                                            <td class="v-mid">{{ $accessory->name }}</td>
                                                            <td class="v-mid">{{ $accessory->value }}</td>
                                                            <td class="v-mid "> {{ $accessory->units }}</td>
                                                            <td class="v-mid">
                                                                £{{ $accessory->total }}</td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <hr>
                                    @endif

                                    {{--Credits--}}
                                    @if($dealCalculator->credits->count() > 0)
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="text-dark">Credits & Buyout</h4>
                                                <table class="table table-responsive border-top-warning">
                                                    <thead>
                                                    <tr>
                                                        <th>Manufacturer & Model</th>
                                                        <th>Value</th>
                                                        <th>Units</th>
                                                        <th>Total</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($dealCalculator->credits  as $credit)
                                                        <tr>
                                                            <td class="v-mid">{{ $credit->name }}</td>
                                                            <td class="v-mid">{{ $credit->value }}</td>
                                                            <td class="v-mid"> {{ $credit->units }}</td>
                                                            <td class="v-mid">£{{ $credit->total }}</td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <hr>
                                    @endif


                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4 class="text-dark">Overview</h4>
                                        </div>
                                        @if($dealCalculator->overview)
                                            <div class="col-sm-6">
                                                <table class="table border-top-success">
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-dark text-bold">Months Free?</td>
                                                        <td>
                                                            {{ $dealCalculator->overview->monthsFree }}
                                                            months
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-dark text-bold">Gross Line Rental
                                                        </td>
                                                        <td>
                                                            £{{ $dealCalculator->overview->lineRental }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-dark text-bold">BCAD Value</td>
                                                        <td>
                                                            £{{ $dealCalculator->overview->bcad}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-dark text-bold">Total Cashback</td>
                                                        <td>
                                                            £{{ $dealCalculator->overview->cashBack }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-dark text-bold">Total Monthly
                                                            Discount
                                                        </td>
                                                        <td>
                                                            £{{ $dealCalculator->overview->monthlyDiscount}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-dark text-bold">NET MONTHLY LINE
                                                            RENTAL
                                                        </td>
                                                        <td>
                                                            £{{ $dealCalculator->overview->monthlyLineRental }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-dark text-bold">Discount Margin
                                                            (%)
                                                        </td>
                                                        <td>
                                                            {{ $dealCalculator->overview->discountMargin }}%
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-sm-6">
                                                <table class="table border-top-success">
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-dark text-bold">Discounted Monthly
                                                            Cost
                                                            to
                                                            Customer
                                                        </td>
                                                        <td>
                                                            £{{ $dealCalculator->overview->discountedMonthlyCost }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-dark text-bold">Total Income</td>
                                                        <td>
                                                            £{{ $dealCalculator->overview->income }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-dark text-bold">Total Cost</td>
                                                        <td>
                                                            £{{ $dealCalculator->overview->cost }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-dark text-bold">Handling Fees</td>
                                                        <td>
                                                            £{{ $dealCalculator->overview->handlingFee }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-dark text-bold">Total Gross Profit
                                                        </td>
                                                        <td>
                                                            £{{ $dealCalculator->overview->totalProfit }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-dark text-bold">Profit Margin</td>
                                                        <td>
                                                            {{ $dealCalculator->overview->profitMargin }}%
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-dark text-bold">Authorised</td>
                                                        <td class="text-white {{ $dealCalculator->overview->status == 1 ? 'success' : 'danger'}}">
                                                            @if($dealCalculator->overview->status)
                                                                AUTHORISED
                                                            @else
                                                                NOT AUTHORISED
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="col-sm-12">
                                                <h4 class="text-dark">There is an issue here, please contact
                                                    support</h4>
                                            </div>
                                        @endif
                                    </div>

                                    <br>

                                    <hr>

                                    <br>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif