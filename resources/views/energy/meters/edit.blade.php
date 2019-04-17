@extends('customers.layout')

@section('title')
    Edit Energy Meter &middot; {{ $customer->company_name }} &middot; Atlas
@endsection

@section('page-title')
    {{ $customer->company_name }}
@endsection

@section('page-description')
    Edit energy meter
@endsection

@section('subcontent')
    {!! Form::model($meter, ['action' => ['EnergyOpportunity\EnergyMeterController@update', $customer->id, $meter->id], 'role' => 'form', 'class' => 'form-horizontal']) !!}
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Edit Meter Details</h3>
                    </div>

                    <div class="panel-body">
                        @include('energy.meters.forms.main')
                    </div>
                </div>
            </div>
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
        $(document).ready(function() {
            $("select .select2-search").select2();

            $("select .select2").select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>


@endsection
