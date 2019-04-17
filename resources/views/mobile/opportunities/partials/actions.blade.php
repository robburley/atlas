<div role="tabpanel" class="tab-pane active" id="actions">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-top-success">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="text-{{ $opportunity->status->colour == 'blue' ? 'info' : $opportunity->status->colour }}">
                            <i class="fa-user"></i> {{ $opportunity->status->name }}
                        </span>
                        | Actions
                    </h3>
                </div>

                <div class="panel-body">
                    @if(PermissionHelper::mobileShowPermissions($opportunity))
                        @include('mobile.opportunities.actions.' . $opportunity->status->slug)
                    @elseif($opportunity->status->blown == 1)
                        @include('mobile.opportunities.actions.blown')
                    @else
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>
                                    This opportunity is currently
                                    <span class="text-{{ $opportunity->status->colour }}">{{ $opportunity->status->name  }} </span>
                                    Please check back soon for an update
                                </h4>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('mobile.opportunities.partials.actions-info')
</div>