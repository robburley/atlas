@extends('layout.master')

@section('title')
    Tenders &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-user"></i>
                Tenders &middot; {{ $tender->id }}
            </h2>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Prices
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Hardware</th>
                            <th>Quantity</th>
                            @foreach($handsets->first()->get('data') as $data)
                                <th>
                                    {{ $data->get('supplier') }}
                                </th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($handsets as $handset)
                            <tr>
                                <td>
                                    {{ $handset->get('device') }}
                                </td>
                                <td>
                                    {{ $handset->get('quantity') }}
                                </td>
                                @foreach($handset->get('data') as $data)
                                    <td>
                                        @if($data->get('response') && $data->get('response')->unit_price > 0)
                                            £{{ number_format($data->get('response')->unit_price ?? 0, 2) }}
                                        @else
                                            --
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
@endsection
