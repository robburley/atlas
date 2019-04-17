@extends('layout.master')

@section('title')
    Notifications &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-bell-o"></i>
                Notifications
            </h2>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default border-top-purple">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4>
                                {{ $notification->subject }} <br>

                                <small>
                                    at {{ $notification->created_at->format('d/m/Y H:i') }} by {{ $notification->sender->name }}
                                </small>
                            </h4>
                        </div>


                        @if($notable = $notification->notable)
                            <div class="col-sm-6 text-right">

                                <a href="{{ $notable->path() }}"
                                   class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right">
                                    <i class="fa fa-arrow-right"></i>
                                    <span>
                                    Posted to: {{ ucwords(str_replace('_', ' ', $notable->getTable())) }}
                                        </span>
                                </a>

                            </div>
                        @endif
                    </div>
                </div>
                <div class="panel-body">


                    <p>
                        {!! nl2br($notification->body) !!}
                    </p>

                    <br>

                    {!! Form::open() !!}
                    {!! Form::hidden('read', 1) !!}
                    <button type="submit" class="btn btn-success btn-icon pull-right">
                        <i class="fa fa-fw fa-search"></i>
                        Mark as read
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
@endsection
