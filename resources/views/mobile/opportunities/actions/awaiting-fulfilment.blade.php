<div class="row">
    @if(!$opportunity->hasAllocations())
        <div class="col-sm-12">
            <h4 class="text-dark">This is an opportunity from before allocations were added to the system and have not
                gone through the fulfilment process</h4>
        </div>
    @endif

    @if($opportunity->requiresBcad())
        <div class="col-md-4">
            <a href="{{ "/customers/$customer->id/mobile/opportunities/$opportunity->id/bcad" }}"
               class="btn btn-block text-center m-b-30 @if($opportunity->bcad_reference) btn-success @else btn-blue @endif">
                <h1 class="p-t-10">
                    @if($opportunity->bcadReferenceComplete())
                        <i class="fa fa-check"></i>
                    @else
                        <i class="fa fa-file-excel-o"></i>
                    @endif
                </h1>

                <h3 class="p-t-10 p-b-10">BCAD</h3>
            </a>
        </div>
    @endif

    @if(count($opportunity->canHavePacCode()) > 0)
        <div class="col-md-4">
            <a href="{{ "/customers/$customer->id/mobile/opportunities/$opportunity->id/pac-codes" }}"
               class="btn btn-block text-center m-b-30 @if($opportunity->requiredPacCode()) btn-blue @else btn-success @endif"
            >
                <h1 class="p-t-10">

                    @if($opportunity->requiredPacCode())
                        <i class="fa fa-folder-open"></i>
                    @else
                        <i class="fa fa-check"></i>
                    @endif
                </h1>

                <h3 class="p-t-10 p-b-10">PAC Codes</h3>
            </a>
        </div>
    @endif

    @if($opportunity->awaitingUnlock())
        <div class="col-md-4">
            <a href="{{ "/customers/$customer->id/mobile/opportunities/$opportunity->id/unlocks" }}"
               class="btn btn-block text-center m-b-30 @if($opportunity->unlockComplete()) btn-success @else btn-blue  @endif">
                <h1 class="p-t-10">
                    @if($opportunity->unlockComplete())
                        <i class="fa fa-check"></i>
                    @else
                        <i class="fa fa-key"></i>
                    @endif
                </h1>

                <h3 class="p-t-10 p-b-10">Unlocks</h3>
            </a>
        </div>
    @endif

    @if($opportunity->hasAllocations())
        <div class="col-md-4">
            <a href="{{ "/customers/$customer->id/mobile/opportunities/$opportunity->id/sims" }}"
               class="btn btn-block text-center m-b-30 @if($opportunity->requiresSims()) btn-success @else btn-blue @endif">
                <h1 class="p-t-10">

                    @if($opportunity->requiresSims())
                        <i class="fa fa-check"></i>
                    @else
                        <i class="fa fa-file-sound-o"></i>
                    @endif
                </h1>

                <h3 class="p-t-10 p-b-10">SIMs</h3>
            </a>
        </div>
    @endif



    @if(!is_null($opportunity->bond_type))
        <div class="col-md-4">
            @if($opportunity->readyForBondPayment())
                <a href="{{ "/customers/$customer->id/mobile/opportunities/$opportunity->id/bond-payment-reference" }}"
                   class="btn btn-block text-center m-b-30 @if(!empty($opportunity->bond_payment_reference)) btn-success @else btn-blue @endif">
                    <h1 class="p-t-10">
                        @if(!empty($opportunity->bond_payment_reference))
                            <i class="fa fa-check"></i>
                        @else
                            <i class="fa fa-gbp"></i>
                        @endif
                    </h1>

                    <h3 class="p-t-10 p-b-10">Bond Payment</h3>
                </a>
            @else
                <div class="background-warning text-white text-center m-b-30 p-t-7 p-b-7">
                    <h1 class="p-t-10">
                        <i class="fa fa-gbp"></i>
                    </h1>

                    <h3 class="p-t-10 p-b-10">Bond Payment</h3>
                </div>
            @endif
        </div>
    @endif


    @if($opportunity->willNeedStock())
        @if($opportunity->needsStock())
            <div class="col-md-4">
                <a href="{{ "/customers/$customer->id/mobile/opportunities/$opportunity->id/stock" }}"
                   class="btn btn-block text-center m-b-30 @if($opportunity->allStockOrdered()) btn-success @else btn-blue @endif">
                    <h1 class="p-t-10">
                        @if($opportunity->allStockOrdered())
                            <i class="fa fa-check"></i>
                        @else
                            <i class="fa fa-mobile-phone"></i>
                        @endif
                    </h1>

                    <h3 class="p-t-10 p-b-10">Stock</h3>
                </a>
            </div>
        @else
            <div class="col-md-4">
                <div class="background-warning text-white text-center m-b-30 p-t-7 p-b-7">
                    <h1 class="p-t-10">
                        <i class="fa fa-mobile-phone"></i>
                    </h1>

                    <h3 class="p-t-10 p-b-10">Stock</h3>
                </div>
            </div>
        @endif
    @endif

        @if($opportunity->canBePorted())
            <div class="col-md-4">
                @if($opportunity->readyToPort())
                    <a href="{{ "/customers/$customer->id/mobile/opportunities/$opportunity->id/ports" }}"
                    class="btn btn-block text-center m-b-30 @if($opportunity->portDateSet()) btn-success @else btn-blue @endif">
                        <h1 class="p-t-10">
                            @if($opportunity->portDateSet())
                                <i class="fa fa-check"></i>
                            @else
                                <i class="fa fa-arrows-h"></i>
                            @endif
                        </h1>

                        <h3 class="p-t-10 p-b-10">Ports</h3>
                    </a>
                @else
                    <div class="background-warning text-white text-center m-b-30 p-t-7 p-b-7">
                        <h1 class="p-t-10">
                            <i class="fa fa-arrows-h"></i>
                        </h1>

                        <h3 class="p-t-10 p-b-10">Ports</h3>
                    </div>
                @endif
            </div>
        @endif
</div>

<hr>

<div class="row">
    @if($opportunity->hasAwaitingConnections())
        <div class="col-md-4">
            <a href="{{ "/customers/$customer->id/mobile/opportunities/$opportunity->id/connection" }}"
               class="btn btn-block text-center m-b-30 btn-purple">
                <h1 class="p-t-10">
                    <i class="fa fa-clock-o"></i>
                </h1>

                <h3 class="p-t-10 p-b-10">Awaiting Connection</h3>
            </a>
        </div>
    @endif

    @if($opportunity->hasPendingConnections())
        <div class="col-md-4">
            <a href="{{ "/customers/$customer->id/mobile/opportunities/$opportunity->id/pending-connection" }}"
               class="btn btn-block text-center m-b-30 btn-purple">
                <h1 class="p-t-10">
                    <i class="fa fa-refresh"></i>
                </h1>

                <h3 class="p-t-10 p-b-10">Pending Connections</h3>
            </a>
        </div>
    @endif

    @if($opportunity->hasDeferredConnections())
        <div class="col-md-4">
            <a href="{{ "/customers/$customer->id/mobile/opportunities/$opportunity->id/connection-deferred" }}"
               class="btn btn-block text-center m-b-30 btn-purple">
                <h1 class="p-t-10">
                    <i class="fa fa-mail-reply"></i>
                </h1>

                <h3 class="p-t-10 p-b-10">Connections Deferred</h3>
            </a>
        </div>
    @endif

    @if($opportunity->hasConnectionErrors())
        <div class="col-md-4">
            <a href="{{ "/customers/$customer->id/mobile/opportunities/$opportunity->id/connection-error" }}"
               class="btn btn-block text-center m-b-30 btn-purple">
                <h1 class="p-t-10">
                    <i class="fa fa-close"></i>

                </h1>

                <h3 class="p-t-10 p-b-10">Connection Errors</h3>
            </a>
        </div>
    @endif

    @if($opportunity->hasConnectedLines())
        <div class="col-md-4">
            <a href="{{ "/customers/$customer->id/mobile/opportunities/$opportunity->id/connected" }}"
               class="btn btn-block text-center m-b-30 btn-purple">
                <h1 class="p-t-10">
                    <i class="fa fa-check"></i>
                </h1>

                <h3 class="p-t-10 p-b-10">Connected</h3>
            </a>
        </div>
    @endif
</div>

@if(auth()->user()->isAdmin())
    <div class="row">
        <div class="col-xs-12 text-right">
            {!! Form::open(['action' => ['MobileOpportunity\MobileOpportunityController@update', $customer->id, $opportunity->id], 'method' => 'post']) !!}
            {!! Form::hidden('mobile_opportunity_status_id', $mobileOpportunityStatusHelper->get('order-cancelled')) !!}
            {!! Form::hidden('order_canceled', true) !!}

            <button type="submit" class="btn btn-danger btn-lg btn-icon">
                <i class="fa-warning"></i>
                <span>
                Cancel Order
            </span>
            </button>
            {!! Form::close() !!}
        </div>
    </div>
@endif