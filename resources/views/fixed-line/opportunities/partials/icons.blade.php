<i class="fa fa-fw fa-mobile text-warning"></i>

@if($opportunity->appointment)
    <i class="fa fa-fw fa fa-calendar text-purple"
       data-toggle="tooltip"
       data-placement="top"
       title="Appointment"
    ></i>
@endif

@if(! is_null($opportunity->valid) && $opportunity->valid == 0)
    <i class="fa fa-fw fa fa-crosshairs text-danger"
       data-toggle="tooltip"
       data-placement="top"
       title="Sent back to lead generator"
    ></i>
@endif


@if($opportunity->hot_transfer)
    <i class="fa fa-fw fa fa-fire text-danger"
       data-toggle="tooltip"
       data-placement="top"
       title="Hot Transfer"
    ></i>
@endif

@if($opportunity->inactiveAssigned->count() > 0)
    <i class="fa fa-fw fa fa-refresh text-info"
       data-toggle="tooltip"
       data-placement="top"
       title="Opportunity Reassigned"
    ></i>
@endif

@if($opportunity->qualified == 1)
    <i class="fa fa-fw fa-thumbs-up text-success"
       data-toggle="tooltip"
       data-placement="top"
       title="Qualified {{ $opportunity->qualified_at ? $opportunity->qualified_at->format('d/m/Y H:i') : 'NA' }}"
    ></i>
@elseif(!is_null($opportunity->qualified) && $opportunity->qualified == 0)
    <i class="fa fa-fw fa-thumbs-down text-danger"
       data-toggle="tooltip"
       data-placement="top"
       title="Not Qualfied {{ $opportunity->qualified_at ? $opportunity->qualified_at->format('d/m/Y H:i') : 'NA' }}"
    ></i>
@endif