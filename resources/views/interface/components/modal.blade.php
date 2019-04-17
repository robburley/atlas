<div class="modal fade" id="{{ $modalId }}">
    <div class="modal-dialog {{ $modelBorderClass }}">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">{{ $modalTitle }}</h4>
            </div>

            {{ $modalBody }}
        </div>
    </div>
</div>
