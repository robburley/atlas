@extends('layout.master')

@section('title')
    Callbacks &middot; Atlas
@endsection

@section('styles')
    <style>
        .ui-datepicker {
            z-index: 9999 !important;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-clock-o"></i>
                Update Callback
            </h2>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-top-success">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            {!! Form::model($callback, ['action' => ['EnergyOpportunity\CallbackController@update', $callback->opportunity->customer, $callback->opportunity, $callback], 'role' => 'form', 'class' => 'form-horizontal']) !!}
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        {!! Form::label('time', 'Callback Time', ['class' => 'control-label']) !!}

                                        {!! Form::text('time', $callback->time->format('d/m/Y H:i:s'), ['class' => 'form-control', 'placeholder' => 'Set a preferred callback time...', 'id' => 'set-callback-time']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                                    <i class="fa fa-fw fa-phone"></i>
                                    <span>Update Callback</span>
                                </button>
                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $('#set-callback-time').datetimepicker({
            timeFormat: 'HH:mm:ss',
            showSecond: false,
            stepMinute: 5,
            hourMin: 5,
            hourMax: 22,
        });
    </script>
@endsection
