<div class="col-sm-3">
    <div class="panel panel-default border-top-success ">
        {{--visible-xs--}}
        <div class="panel-heading  text-center">
            <h3 class="panel-title">{{ $opportunity->status->name }}</h3>
        </div>
    </div>

    <ul class="cbp_tmtimeline  hidden">

        @foreach($statuses as $status)
            <li>
                @if($opportunity->status->id <= $status->id)
                    <div class="cbp_tmicon timeline-bg-{{ $status->colour == 'blue' ? 'info' : $status->colour }}">
                        <i class="fa-user"></i>
                    </div>
                @else

                    <div class="cbp_tmicon timeline-bg-gray">
                        <i class="fa-check text-success"></i>
                    </div>
                @endif

                <div class="cbp_tmlabel empty m-b-20 " style="padding-left: 10px;">
                    @if($opportunity->status->id == $status->id)
                        <strong>{!! $opportunity->getStatusText($status->id, $status->name) !!}</strong>
                    @else
                        {!! $opportunity->getStatusText($status->id, $status->name) !!}
                    @endif
                </div>
            </li>

        @endforeach
    </ul>
</div>