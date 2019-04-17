@extends('layout.master')

@section('title')
    Tariffs &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-user"></i>
                Tariffs
                <a href="/admin/mobile/tariffs/create" class="btn btn-success pull-right">
                    New Tariff
                </a>
            </h2>
        </div>
    </div>

    <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default border-top-purple">
                    <div class="panel-body">
                        {!! Form::open(['method'=> 'get','class' => 'form-inline']) !!}
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}

                                    {!! Form::text('name', request()->get('name', ''), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    {!! Form::label('type', 'Type', ['class' => 'control-label']) !!}
                                    
                                    {!! Form::select('type', $types->prepend('Please Select') , request()->get('type', '') , ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-success btn-block" style="">Filter</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Created at</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($tariffs as $tariff)
                                    <tr>
                                        <td class="v-mid">
                                            {{ $tariff->type->name or '--' }}
                                        </td>

                                        <td class="v-mid">
                                            {!! $tariff->getName() !!}
                                        </td>

                                        <td class="v-mid">
                                            {{ $tariff->created_at->format('d/m/Y') }}
                                        </td>

                                        <td class="v-mid">
                                            <a href="#"
                                               class="btn btn-xs btn-white btn-icon deactivate-tariff" data-id="{{ $tariff->id }}">
                                                <i class="fa fa-fw fa-close"></i>
                                                <span>Deactivate</span>
                                            </a>

                                            {!! Form::open(['url' => '/admin/mobile/tariffs/' . $tariff->id, 'method' => 'POST', 'id' => 'post-deactivate-' . $tariff->id]) !!}
                                                {!! Form::hidden('active', 0) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            There are currently no tariffs.
                                        </td>
                                    </tr>
                                @endforelse
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
    <script>
        $(document).ready(function(){
            $('.deactivate-tariff').click(function(e){
                e.preventDefault();

                var id = $(this).data('id');

                $('#post-deactivate-' + id).submit();
            });
        })
    </script>
@endsection
