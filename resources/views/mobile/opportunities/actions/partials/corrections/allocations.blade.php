<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <mobile-allocation :customer="{{ $customer->id }}"
                           :opportunity="{{ $opportunity->id }}"
                           :deal_calculator="{{ $opportunity->selectedDealCalculator()->with(['handsets.handset','connections.tariff.type',])->first()->toJson() }}"
                           :allocations="{{ $opportunity->allocations()->with(['vas'])->get() }}"
                           :hide_finished="true"
        ></mobile-allocation>
    </div>
</div>