<div class="row">
    <div class="col-sm-12">
        <h4>
            This opportunity is blown with with a reason of
            <span class="text-{{ $opportunity->status->colour }}">{{ $opportunity->status->name  }} </span>
        </h4>

        <h4>

            @php($note = $opportunity->customerNotes()->where('customer_note_type_id', 8)->orderBy('created_at', 'desc')->first())
            Blown Reason:
            <span class="text-danger">
                @if($note)
                    {{ $note->body }}
                @else
                    @if(!empty($opportunity->not_qualified_reason))
                        {{ $opportunity->not_qualified_reason }}
                    @endif
                    @if(!empty($opportunity->provisioned_failed_reason))
                        {{ $opportunity->provisioned_failed_reason }}
                    @endif
                @endif
            </span>

        </h4>
    </div>
</div>