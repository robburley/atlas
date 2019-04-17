<div class="row">
    @foreach($opportunity->unactionedCorrections as $correction)
        <div class="col-sm-8 col-sm-offset-2">
            <div class="row">
                <div class="col-xs-2 text-right">
                    <h1 class="m-t-70"><i class="fa fa-close fa-3x fa-pull-left fa-border text-danger" aria-hidden="true"></i>
                    </h1>
                </div>

                <div class="col-xs-10">
                    <h4 class="text-dark">
                        {{ $correction->type }}
                    </h4>

                    <hr>

                    {{ $correction->created_at->diffForHumans() }}, <span
                            class="text-dark">{{ $correction->user->name }}</span> added a correction. <br>

                    <div class="p-t-20">
                        {{ $correction->description }}
                    </div>

                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-sm-offset-8">
                    <a class="btn btn-block btn-purple btn-icon btn-icon-standalone btn-icon-standalone-right btn-single text-left"
                       id="{{ strtolower($correction->type) }}-button"
                    >
                        <i class="fa-check"></i>

                        <span>Resolve</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 hidden" id="{{ strtolower($correction->type) }}-content">
                @include('mobile.opportunities.actions.partials.corrections.' . strtolower($correction->type))
            </div>
        </div>

        <hr>
    @endforeach
</div>

<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <h4 class="text-dark text-right">
            Once you are happy that you have resolved all of the above issues, <br>
            click the button below to send the opportunity back to quality control
        </h4>

        <div class="row">
            <div class="col-md-4 col-md-offset-8">
                {!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer, $opportunity], 'method' => 'post']) !!}
                {!! Form::hidden('mobile_opportunity_status_id', 23) !!}

                <button class="btn btn-block btn-success btn-icon btn-icon-standalone btn-icon-standalone-right btn-single text-left">
                    <i class="fa-save"></i>

                    <span>Submit to Quality Control</span>
                </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @parent
    <script>
        @foreach($opportunity->unactionedCorrections as $correction)
        $('#{{ strtolower($correction->type) }}-button').click(function () {
            $('#{{ strtolower($correction->type) }}-content').removeClass('hidden')

            $('#{{ strtolower($correction->type) }}-button').addClass('hidden')
        })
        @endforeach
    </script>
@endsection