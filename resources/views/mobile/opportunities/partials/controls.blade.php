<div class="col-sm-8 text-right m-b-20">
    @if($opportunity->status->blown == 1 && $opportunity->status->unrecoverable == 0 && auth()->user()->hasPermission('recoverable_mobile'))
        <a href="javascript:;" onclick="jQuery('#save-lead').modal('show', {backdrop: 'fade'});"
           class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
            <i class="fa fa-refresh"></i>
            <span>Recover</span>
        </a>
    @endif

    @if(auth()->user()->hasPermission('blow_lead_mobile') && $opportunity->status->blown != 1 && $opportunity->status->id != $mobileOpportunityStatusHelper->get('awaiting-closer-contact') && $opportunity->status->id != $mobileOpportunityStatusHelper->get('awaiting-callback'))
        <a href="javascript:;" onclick="jQuery('#blow-lead').modal('show', {backdrop: 'fade'});"
           class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
            <i class="fa fa-times"></i>
            <span>Blown</span>
        </a>
    @endif

    @if(auth()->user()->hasPermission('awaiting_assignment_mobile') && $opportunity->status->id <= $mobileOpportunityStatusHelper->get('awaiting-purchase-order') && $opportunity->status->id >= $mobileOpportunityStatusHelper->get('awaiting-closer-contact'))
        <a href="javascript:;" onclick="jQuery('#reassign-lead').modal('show', {backdrop: 'fade'});"
           class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
            <i class="fa fa-user"></i>
            <span>Reassign</span>
        </a>
    @endif

    {{--@if( auth()->user()->hasPermission('welcome_call_mobile'))--}}
        {{--<a href="javascript:;" onclick="jQuery('#welcome-call').modal('show', {backdrop: 'fade'});"--}}
           {{--class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">--}}
            {{--<i class="fa fa-phone"></i>--}}
            {{--<span>Welcome Call</span>--}}
        {{--</a>--}}
    {{--@endif--}}

    @if($opportunity->status->id != $mobileOpportunityStatusHelper->get('awaiting-closer-contact') || $opportunity->appointment == 1)
        <a href="javascript:;" onclick="jQuery('#set-callback').modal('show', {backdrop: 'fade'});"
           class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
            <i class="fa fa-phone"></i>
            <span>Set Callback</span>
        </a>
    @endif

    @if($opportunity->status->blown == 1 && empty($opportunity->review_date))
        <a href="javascript:;" onclick="jQuery('#set-vetted').modal('show', {backdrop: 'fade'});"
           class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
            <i class="fa fa-check"></i>
            <span>Vetted</span>
        </a>
    @endif

    @if(auth()->user()->hasPermission('edit_mobile') && ($opportunity->status->id != $mobileOpportunityStatusHelper->get('awaiting-credit-check') && $opportunity->status->id != $mobileOpportunityStatusHelper->get('awaiting-fulfilment')) )
        <a href="/customers/{{ $customer->id }}/mobile/opportunities/{{ $opportunity->id }}/edit"
           class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
            <i class="fa fa-pencil"></i>
            <span>Edit</span>
        </a>
    @endif
</div>