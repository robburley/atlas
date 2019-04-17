@extends('layout.master')

@section('title')
    Branch Report &middot; Closers &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-file-text-o"></i>
                Branch Report
            </h2>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-top-info">
                <div class="panel-body">
                </div>
                {!! Form::open(['method'=> 'get','class' => 'form-inline']) !!}
                <div class="row">
                    <div class="col-sm-4 p-b-10">
                        <div class="form-group">
                            {!! Form::label('start', 'Created From', ['class' => 'control-label']) !!}

                            {!! Form::text('start', request()->get('start') ?? \Carbon\Carbon::now()->startOfDay()->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-sm-4 p-b-10">
                        <div class="form-group">
                            {!! Form::label('end', 'Created To', ['class' => 'control-label']) !!}

                            {!! Form::text('end', request()->get('end') ?? \Carbon\Carbon::now()->endOfDay()->format('d/m/Y') , ['class' => 'form-control datepicker', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-sm-4 p-b-10">
                        <button type="submit" class="btn btn-success btn-block">Filter</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


    @foreach($data as $office => $items)
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>{{ $office }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-wrapper">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    </thead>
                                    @foreach($items->get('data') as $key => $value)
                                        @if(is_array($value))
                                            @foreach($value as $k => $v)
                                                <tr>
                                                    @if($loop->first)
                                                        <td>
                                                            <strong>
                                                                {{ $key }}
                                                            </strong>
                                                        </td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                    <td>
                                                        @if($k == 'Total')
                                                            <strong>
                                                                {{ $k }}
                                                            </strong>
                                                        @else
                                                            {{ $k }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($k == 'Total')
                                                            <strong>
                                                                {{ $v }}
                                                            </strong>
                                                        @else
                                                            {{ $v }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>
                                                    <strong>
                                                        {{ $key }}
                                                    </strong>
                                                </td>

                                                <td></td>

                                                <td>
                                                    <strong>
                                                        {{ $value }}
                                                    </strong>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lead Generation Leaderboard</h3>

                        <div class="panel-options">
                            <a href="#" data-toggle="panel" class="">
                                <span class="collapse-icon">–</span>
                                <span class="expand-icon">+</span>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">

                        <ul class="list-group">
                            @forelse($items->get('leaderboard') as $user)
                                <li class="list-group-item">
                                    <span class="badge badge-purple">{{ $user['count'] }}</span>

                                    {{ $loop->iteration }}. {{ $user['name'] }}
                                </li>
                            @empty
                                <li class="list-group-item">
                                    No Leads today
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
