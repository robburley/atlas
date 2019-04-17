
<div class="row">
    <div class="col-sm-12">
        <h4>
            This opportunity is blown with with a reason of
            <span class="text-{{ $opportunity->status->colour }}">{{ $opportunity->status->name  }} </span>
        </h4>

        <h4>
            @if(!empty($opportunity->not_qualified_reason))
                Not Qualified Reason: <span  class="text-danger">{{ $opportunity->not_qualified_reason }}</span>
            @endif
        </h4>
    </div>
</div>