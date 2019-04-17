@extends('mobile.opportunities.fulfilment.layout')

@section('fulfilment-content')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="text-dark">
                Order Stock
            </h4>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12 text-right">
            @if($opportunity->salesInformation && $opportunity->salesInformation->delivery_address)
                <h4 class="text-dark">Delivery Address</h4>
                <p>{!! $opportunity->salesInformation->delivery_address !!}</p>
            @endif
        </div>

        <div class="col-sm-12">
            {!! Form::open(['action' => ['MobileOpportunity\Fulfilment\StockController@store', $customer, $opportunity], 'method' => 'post']) !!}
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Hardware</th>
                    <th>Supplier</th>
                    <th>Price</th>
                    <th>Lead Time</th>
                    <th>Price Paid</th>
                    <th>IMEI</th>
                    <th></th>
                </tr>

                @foreach($opportunity->allocations as $allocation)
                    @if($allocation->tender_complete)
                        <tr>
                            <td class="v-mid">
                                {{ $allocation->name }}
                                {!! Form::hidden("data[$allocation->id][id]", $allocation->id) !!}
                            </td>

                            <td>
                                {{ $allocation->handset_name ?? 'No Hardware' }} @if($allocation->colour ) in {{ $allocation->colour }} @endif
                            </td>

                            <td>
                                {{ $allocation->mobileTender->supplier->name or 'No Supplier' }}
                            </td>

                            <td>
                                £{{ number_format($allocation->mobileTender->selected_unit_price ?? 0, 2) }}
                            </td>

                            <td>
                                @if($allocation->mobileTender)
                                    @if($allocation->mobileTender->selected_lead_time == 1)
                                        1 Day
                                    @elseif($allocation->mobileTender->selected_lead_time == 7)
                                        Less Than 1 Week
                                    @else
                                        More that 1 Week
                                    @endif
                                @endif

                            </td>

                            <td>
                                {!! Form::number("data[$allocation->id][price]", $allocation->price_paid, ['class' => 'form-control', 'step' => 0.01, 'min' => 0]) !!}
                            </td>

                            <td>
                                {!! Form::text("data[$allocation->id][imei]", $allocation->imei, ['class' => 'form-control']) !!}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>

            <button class="btn btn-success pull-right m-t-10">
                <i class="fa fa-upload"></i>
                Update
            </button>
            {!! Form::close() !!}
        </div>
    </div>


@endsection