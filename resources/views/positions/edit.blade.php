@extends('layout.master')

@section('title')
    Position &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-user"></i>
                Position &middot; {{ $position->applicant_name }}
            </h2>
        </div>
    </div>

    <br>

    {!! Form::model($position, ['url' => '/recruitment/positions/' . $position->id, 'role' => 'form', 'class' => 'form-horizontal', 'method' => 'PATCH', 'files' => true]) !!}
    <div class="row">
        <div class="panel panel-default border-top-success">
            <div class="panel-heading">
                <div class="col-sm-12">
                    <h3 class="panel-title">Details</h3>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-12">
                    @include('positions.forms.basic')

                    <div class="row">

                        <div class="col-sm-6">
                            {!! Form::label('active', 'Open', ['class' => 'col-sm-2 control-label']) !!}

                            <div class="col-sm-10">
                                {!! Form::select('active', FormPopulator::yesNo(), null , ['class' => 'form-control']) !!}

                                {!! $errors->first('active', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                            <i class="fa fa-fw fa-save"></i>
                            <span>Save</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
@endsection
