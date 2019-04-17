@inject('formPopulator', 'App\Helpers\FormPopulator')
@extends('layout.master')

@section('title')
    Cashflow &middot; Atlas
@endsection

@section('styles')
    <style>
        .table-responsive>.table>thead>tr>th, .table-responsive>.table>tbody>tr>th, .table-responsive>.table>tfoot>tr>th, .table-responsive>.table>thead>tr>td, .table-responsive>.table>tbody>tr>td, .table-responsive>.table>tfoot>tr>td {
            white-space: nowrap;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-gbp"></i>
                Cashflow
            </h2>
        </div>
    </div>


    <div class="row m-t-25">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    {!! Form::open(['method'=> 'get','class' => 'form']) !!}

                    <div class="row m-b-10">
                        <div class="col-sm-4">
                            {!! Form::label('company_name', 'Company Name', ['class' => 'control-label']) !!}

                            {!! Form::text('company_name', request()->get('company_name'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('start', 'Sold From', ['class' => 'control-label']) !!}

                                {!! Form::text('start', request()->get('start') ?? $formPopulator->now(), ['class' => 'form-control datepicker', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('end', 'Sold To', ['class' => 'control-label']) !!}

                                {!! Form::text('end', request()->get('end') ?? $formPopulator->now(), ['class' => 'form-control datepicker', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('branch', 'Branch', ['class' => 'control-label']) !!}

                                {!! Form::select('branch', [ null => 'All'] + $formPopulator->offices()->toArray(), request()->get('branch'), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('lead_generator', 'Lead Generator', ['class' => 'control-label']) !!}

                                {!! Form::select('lead_generator', [ null => 'All'] + $formPopulator->allUsers(), request()->get('lead_generator'), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('sales_person', 'Lead Generator', ['class' => 'control-label']) !!}

                                {!! Form::select('sales_person', [ null => 'All'] + $formPopulator->allUsers(), request()->get('sales_person'), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('status', 'Status', ['class' => 'control-label']) !!}

                                {!! Form::select('status', $formPopulator->cashFlowStatuses(), request()->get('status'), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2 col-sm-offset-10">
                            <button type="submit" class="btn btn-success btn-block" style="">Filter</button>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row m-t-25">
        <div class="col-sm-12">
            <div class="panel panel-color panel-info">
                <div class="panel-heading p-t-5 p-b-5">
                    <div class="panel-title">
                        <a href="javascript:;" onclick="jQuery('#oneOff').modal('show', {backdrop: 'fade'})"
                           class="btn btn-lg btn-icon btn-info m-b-0"
                        >
                            <i class="fa fa-gbp p-r-10"></i>
                            <span>Add One Off</span>
                        </a>
                    </div>
                    <div class="panel-options">
                        <a href="javascript:;" onclick="jQuery('#monthTotal').modal('show', {backdrop: 'fade'})"
                           class="btn btn-lg btn-icon btn-info m-b-0"
                        >
                            <i class="fa fa-calendar p-r-10"></i>
                            <span>Month</span>
                        </a>
                        <a href="javascript:;" onclick="jQuery('#yearTotal').modal('show', {backdrop: 'fade'})"
                           class="btn btn-lg btn-icon btn-info m-b-0"
                        >
                            <i class="fa fa-calendar p-r-10"></i>
                            <span>Year</span>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-condensed table-bordered">
                                <thead>
                                <tr>
                                    <td>Sales Date</td>
                                    {{--<td>Sales Sheet Generated Date</td>--}}
                                    <td>Branch</td>
                                    <td>Company Name</td>
                                    <td>Network</td>
                                    <td>Lines</td>
                                    <td>Sales Person</td>
                                    <td>Lead Generator</td>
                                    <td>Turnover</td>
                                    <td>Hardware Fund</td>
                                    <td>Hardware Fund VAT</td>
                                    <td>Handling Fees</td>
                                    <td>Handsets</td>
                                    <td>Sims</td>
                                    <td>Sim Saves</td>
                                    <td>Delivery</td>
                                    <td>Total Cashback</td>
                                    <td>Total Cashback VAT</td>
                                    <td>Board GP</td>
                                    <td>% Additional</td>
                                    <td>£ Additional</td>
                                    <td></td>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($items as $item)
                                    <tr class="{{ $item->paid_at ? 'background-success text-white' : '' }} {{ $item->declined_at ? 'background-warning text-white' : '' }} {{ $item->canceled_at ? 'background-danger text-white' : '' }}">
                                        <td>{{ $item->sales_date->format('d/m/Y H:i') }}</td>
                                        {{--<td>{{ $item->generated_date->format('d/m/Y h:i') }}</td>--}}
                                        <td>{{ $item->branch->name }}</td>
                                        <td>{{ $item->company_name }}</td>
                                        <td>{{ $item->network }}</td>
                                        <td>{{ $item->number_of_lines }}</td>
                                        <td>{{ $item->salesPerson->name }}</td>
                                        <td>{{ $item->leadGenerator->name }}</td>
                                        <td>£{{ number_format($item->turnover, 2) }}</td>
                                        <td>£{{ number_format($item->hardware_fund, 2) }}</td>
                                        <td>£{{ number_format($item->hardware_fund_vat, 2) }}</td>
                                        <td>£{{ number_format($item->handling_fees, 2) }}</td>
                                        <td>£{{ number_format($item->handsets, 2) }}</td>
                                        <td>£{{ number_format($item->sims, 2) }}</td>
                                        <td>£{{ number_format($item->sim_saves, 2) }}</td>
                                        <td>£{{ number_format($item->delivery, 2) }}</td>
                                        <td>£{{ number_format($item->total_cashback, 2) }}</td>
                                        <td>£{{ number_format($item->total_cashback_vat, 2) }}</td>
                                        <td>£{{ number_format($item->board_gp, 2) }}</td>
                                        <td>£{{ number_format($item->additional_percent, 2) }}</td>
                                        <td>£{{ number_format($item->additional_pounds, 2) }}</td>
                                        <td>
                                    
                                            @if(!$item->declined_at && !$item->canceled_at)
                                                {!! Form::open(['action' => ['Admin\CashFlowController@destroy', $item], 'method' => 'delete']) !!}
                                                <button type="submit" class="btn btn-danger btn-block btn-icon btn-xs">
                                                    <i class="fa fa-fw fa-close"></i>

                                                    <span>Lost</span>
                                                </button>
                                                {!! Form::close() !!}
                                                
                                                @if(!$item->paid_at)
                                                    {!! Form::open(['action' => ['Admin\CashFlowController@update', $item], 'method' => 'post']) !!}
                                                        
                                                        {!! Form::hidden('paid_at', Carbon\Carbon::now()) !!}
                                                        
                                                        <button type="submit" class="btn btn-success btn-block btn-icon btn-xs">
                                                            <i class="fa fa-fw fa-check"></i>

                                                            <span>Paid</span>
                                                        </button>
                                                    {!! Form::close() !!}
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="21">
                                            There are currently cashflow items
                                        </td>
                                    </tr>
                                @endforelse

                                <tr>
                                    <th></th>
                                    {{--<th></th>--}}
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>£{{ number_format($total['turnover'], 2) }}</th>
                                    <th>£{{ number_format($total['hardware_fund'], 2) }}</th>
                                    <th>£{{ number_format($total['hardware_fund_vat'], 2) }}</th>
                                    <th>£{{ number_format($total['handling_fees'], 2) }}</th>
                                    <th>£{{ number_format($total['handsets'], 2) }}</th>
                                    <th>£{{ number_format($total['sims'], 2) }}</th>
                                    <th>£{{ number_format($total['sim_saves'], 2) }}</th>
                                    <th>£{{ number_format($total['delivery'], 2) }}</th>
                                    <th>£{{ number_format($total['total_cashback'], 2) }}</th>
                                    <th>£{{ number_format($total['total_cashback_vat'], 2) }}</th>
                                    <th>£{{ number_format($total['board_gp'], 2) }}</th>
                                    <th>£{{ number_format($total['additional_percent'], 2) }}</th>
                                    <th>£{{ number_format($total['additional_pounds'], 2) }}</th>
                                </tr>
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
    @component('interface.components.modal')
        @slot('modalId', 'oneOff')
        @slot('modelBorderClass', 'border-top-success')
        @slot('modalTitle', 'Add one off item')
        @slot('modalBody')

            {!! Form::open(['action' => ['Admin\CashFlowOneOffController@store'], 'role' => 'form', 'class' => 'form-horizontal']) !!}

            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::label('value', 'Value', ['class' => 'control-label']) !!}

                        {!! Form::number('value', null, ['class' => 'form-control', 'placeholder' => '000.00', 'min' => '0.01', 'step' => '0.01']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::label('date', 'Date', ['class' => 'control-label']) !!}

                        {!! Form::text('date', null, ['class' => 'form-control datepicker']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        {!! Form::label('type', 'Type', ['class' => 'control-label']) !!}

                        {!! Form::select('type', $formPopulator->cashFlowOneOffs() , null , ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                    <i class="fa fa-fw fa-save"></i>
                    <span>Save</span>
                </button>
            </div>
            {!! Form::close() !!}
        @endslot
    @endcomponent

    @component('interface.components.modal')
        @slot('modalId', 'monthTotal')
        @slot('modelBorderClass', 'border-top-success modal-x-wide')
        @slot('modalTitle', "Month Total - " . $monthStart->format('F Y'))
        @slot('modalBody')
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <select name="branches" id="month-branches" class="form-control">
                            @foreach($month['branches'] as $branch => $data)
                                <option value="{{ str_slug($branch) }}">{{ $branch}} </option>
                            @endforeach
                        </select>
                    </div>

                    @foreach($month['branches'] as $branch => $data)
                        <div class="row @if($branch != 'All') hidden @endif" id="{{ str_slug($branch) }}-month-data">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <table class="table">
                                            <tr>
                                                <th></th>
                                                <th>Board GP</th>
                                                <th>Management GP</th>
                                            </tr>
                                            <tr> 
                                                <td style="font-size: 1.2em;font-weight: bold;color: #efb503;">GP Sold</td>
                                                <td style="font-size: 1.2em;font-weight: bold;color: #efb503;">£{{ number_format($data['GP']['Board GP'], 2) }}</td>
                                                <td style="font-size: 1.2em;font-weight: bold;color: #efb503;">£{{ number_format($data['GP']['Management GP'], 2) }}</td>
                                            </tr>
                                            <tr> 
                                                <td>QC and Validation</td>
                                                <td>£{{ number_format($data['QC and Validation']['Board GP'], 2) }}</td>
                                                <td>£{{ number_format($data['QC and Validation']['Management GP'], 2) }}</td>
                                            </tr>
                                            <tr> 
                                                <td>In Correction</td>
                                                <td>£{{ number_format($data['In Correction']['Board GP'], 2) }}</td>
                                                <td>£{{ number_format($data['In Correction']['Management GP'], 2) }}</td>
                                            </tr>
                                            <tr> 
                                                <td>Awaiting CC</td>
                                                <td>£{{ number_format($data['Awaiting CC']['Board GP'], 2) }}</td>
                                                <td>£{{ number_format($data['Awaiting CC']['Management GP'], 2) }}</td>
                                            </tr>
                                            <tr> 
                                                <td>Declined</td>
                                                <td>£{{ number_format($data['Declined']['Board GP'], 2) }}</td>
                                                <td>£{{ number_format($data['Declined']['Management GP'], 2) }}</td>
                                            </tr>
                                            <tr> 
                                                <td>Canceled</td>
                                                <td>£{{ number_format($data['Canceled']['Board GP'], 2) }}</td>
                                                <td>£{{ number_format($data['Canceled']['Management GP'], 2) }}</td>
                                            </tr>
                                            <tr> 
                                                <td>Passed CC</td>
                                                <td>£{{ number_format($data['Passed CC']['Board GP'], 2) }}</td>
                                                <td>£{{ number_format($data['Passed CC']['Management GP'], 2) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                @if($branch == 'All')

                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="text-dark">One Offs</h4>
                                        <table class="table">
                                            <tr>
                                                <th>
                                                    Type
                                                </th>
                                                <th>
                                                    Value
                                                </th>
                                            </tr>
                                            @foreach($month['one offs'] as $oneOff => $value)
                                                @if($value > 0)
                                                    <tr>
                                                        <td>
                                                            {{ $oneOff }}
                                                        </td>
                                                        <td>
                                                            £{{ number_format($value, 2) }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <h2>£{{ number_format($data['GP']['Total Company GP'], 2) }}</h2>

                                        <h4>Total Company GP</h4>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        @endslot
    @endcomponent

    @component('interface.components.modal')
        @slot('modalId', 'yearTotal')
        @slot('modelBorderClass', 'border-top-success modal-x-wide')
        @slot('modalTitle', "Year Total - " . $yearStart->format('F Y'))
        @slot('modalBody')
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <select name="branches" id="year-branches" class="form-control">
                            @foreach($year['branches'] as $branch => $data)
                                <option value="{{ str_slug($branch) }}">{{ $branch}} </option>
                            @endforeach
                        </select>
                    </div>

                    @foreach($year['branches'] as $branch => $data)
                        <div class="row @if($branch != 'All') hidden @endif" id="{{ str_slug($branch) }}-year-data">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <table class="table">
                                            <tr>
                                                <th></th>
                                                <th>Board GP</th>
                                                <th>Management GP</th>
                                            </tr>
                                            
                                            <tr> 
                                                <td style="font-size: 1.2em;font-weight: bold;color: #efb503;">GP Sold</td>
                                                <td style="font-size: 1.2em;font-weight: bold;color: #efb503;">£{{ number_format($data['GP']['Board GP'], 2) }}</td>
                                                <td style="font-size: 1.2em;font-weight: bold;color: #efb503;">£{{ number_format($data['GP']['Management GP'], 2) }}</td>
                                            </tr>
                                            
                                            <tr> 
                                                <td>QC and Validation</td>
                                                <td>£{{ number_format($data['QC and Validation']['Board GP'], 2) }}</td>
                                                <td>£{{ number_format($data['QC and Validation']['Management GP'], 2) }}</td>
                                            </tr>
                                            <tr> 
                                                <td>In Correction</td>
                                                <td>£{{ number_format($data['In Correction']['Board GP'], 2) }}</td>
                                                <td>£{{ number_format($data['In Correction']['Management GP'], 2) }}</td>
                                            </tr>
                                            <tr> 
                                                <td>Awaiting CC</td>
                                                <td>£{{ number_format($data['Awaiting CC']['Board GP'], 2) }}</td>
                                                <td>£{{ number_format($data['Awaiting CC']['Management GP'], 2) }}</td>
                                            </tr>
                                            <tr> 
                                                <td>Declined</td>
                                                <td>£{{ number_format($data['Declined']['Board GP'], 2) }}</td>
                                                <td>£{{ number_format($data['Declined']['Management GP'], 2) }}</td>
                                            </tr>
                                            <tr> 
                                                <td>Canceled</td>
                                                <td>£{{ number_format($data['Canceled']['Board GP'], 2) }}</td>
                                                <td>£{{ number_format($data['Canceled']['Management GP'], 2) }}</td>
                                            </tr>
                                            <tr> 
                                                <td>Passed CC</td>
                                                <td>£{{ number_format($data['Passed CC']['Board GP'], 2) }}</td>
                                                <td>£{{ number_format($data['Passed CC']['Management GP'], 2) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                @if($branch == 'All')

                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="text-dark">One Offs</h4>
                                        <table class="table">
                                            <tr>
                                                <th>
                                                    Type
                                                </th>
                                                <th>
                                                    Value
                                                </th>
                                            </tr>
                                            @foreach($month['one offs'] as $oneOff => $value)
                                                @if($value > 0)
                                                    <tr>
                                                        <td>
                                                            {{ $oneOff }}
                                                        </td>
                                                        <td>
                                                            £{{ number_format($value, 2) }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <h2>£{{ number_format($data['GP']['Total Company GP'], 2) }}</h2>

                                        <h4>Total Company GP</h4>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        @endslot
    @endcomponent

    <script>
        $('document').ready(function(){
            $('#month-branches').change(function(){

                @foreach($month['branches'] as $branch => $data)
                    $('#{{ str_slug($branch) }}-month-data').addClass('hidden');
                @endforeach

                var current = $(this).val();
                
                $('#' + current +'-month-data').removeClass('hidden');
            })

            $('#year-branches').change(function(){

                @foreach($year['branches'] as $branch => $data)
                    $('#{{ str_slug($branch) }}-year-data').addClass('hidden');
                @endforeach

                var current = $(this).val();
                
                $('#' + current +'-year-data').removeClass('hidden');
            })
        });
    </script>
@endsection
