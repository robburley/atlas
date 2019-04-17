<div class="col-sm-8 text-right m-b-20">
    @if($opportunity->status->blown == 1 && $opportunity->status->unrecoverable == 0 && auth()->user()->hasPermission('recoverable_fixedLine'))
        <a href="javascript:;" onclick="jQuery('#save-lead').modal('show', {backdrop: 'fade'})"
           class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
            <i class="fa fa-refresh"></i>
            <span>Recover</span>
        </a>
    @endif

    @if(auth()->user()->hasPermission('blow_lead_fixed_line') && $opportunity->status->blown != 1 && $opportunity->status->id < $fixedLineOpportunityStatusHelper->get('passed-credit-check') && $opportunity->status->id != $fixedLineOpportunityStatusHelper->get('awaiting-closer-contact') && $opportunity->status->id != $fixedLineOpportunityStatusHelper->get('awaiting-callback'))
        <a href="javascript:;" onclick="jQuery('#blow-lead').modal('show', {backdrop: 'fade'})"
           class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
            <i class="fa fa-times"></i>
            <span>Blown</span>
        </a>
    @endif

    @if(auth()->user()->hasPermission('awaiting_assignment_fixed_line') && $opportunity->status->id <= $fixedLineOpportunityStatusHelper->get('awaiting-purchase-order') && $opportunity->status->id >= $fixedLineOpportunityStatusHelper->get('awaiting-closer-contact'))
        <a href="javascript:;" onclick="jQuery('#reassign-lead').modal('show', {backdrop: 'fade'})"
           class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
            <i class="fa fa-user"></i>
            <span>Reassign</span>
        </a>
    @endif

    @if($opportunity->status->id != $fixedLineOpportunityStatusHelper->get('awaiting-closer-contact'))
        <a href="javascript:;" onclick="jQuery('#set-callback').modal('show', {backdrop: 'fade'})"
           class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
            <i class="fa fa-phone"></i>
            <span>Set Callback</span>
        </a>
    @endif

    @if(auth()->user()->hasPermission('edit_fixed_line') && ($opportunity->status->id != $fixedLineOpportunityStatusHelper->get('awaiting-credit-check') && $opportunity->status->id != $fixedLineOpportunityStatusHelper->get('awaiting-provisioning')) )
        <a href="/customers/{{ $customer->id }}/fixed-line/opportunities/{{ $opportunity->id }}/edit"
           class="btn btn-white btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0">
            <i class="fa fa-pencil"></i>
            <span>Edit</span>
        </a>
    @endif
</div>