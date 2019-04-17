{{--<ul id="main-menu" class="main-menuX"> sidenav--}}

<ul class="navbar-nav">
    {{--<li class="{{ request()->is('/') ? 'active' : '' }}">--}}
    {{--<a href="/">--}}
    {{--<i class="fa fa-fw fa-home"></i>--}}
    {{--<span class="title">Dashboard</span>--}}
    {{--</a>--}}
    {{--</li>--}}

    <li class="visible-xs">
        <form name="userinfo_search_form" method="get" action="/search">
            <input type="text" name="input" class="form-control search-field" pattern=".{3,}"
                   placeholder="Type to search..."/>

            <button type="submit" class="btn btn-info btn-block">
                <i class="fa fa-fw fa-search"></i>
                Search
            </button>
        </form>
    </li>

    @if(auth()->user()->hasPermission('create_customer'))
        <li>
            <a href="javascript:;" onclick="jQuery('#create-customer').modal('show', {backdrop: 'fade'})">
                <i class="fa fa-fw fa-plus"></i>
                <span class="title">New Customer</span>
            </a>
        </li>
    @endif

    <li class="{{ request()->is('mobile*') || request()->is('energy*') || request()->is('recruitment*') || request()->is('fixed-line*') ? 'active opened expanded' : '' }}">
        <a href="#">
            <i class="fa fa-fw fa-wrench"></i>
            <span class="title">Services</span>
        </a>

        <ul>
            @if(auth()->user()->hasAnyPermission([
                'read_mobile',
            ]))
                <li class="{{ request()->is('mobile*') ? 'active opened expanded' : '' }}">
                    <a href="#">
                        <i class="fa fa-fw fa-mobile"></i>
                        <span class="title">Mobile</span>
                    </a>

                    <ul>


                        @if(auth()->user()->hasAnyPermission([
                        'awaiting_bill_mobile',
                        'awaiting_validation_mobile',
                        'awaiting_assignment_mobile',
                        ]))
                            <li>
                                <a href="#">
                                    <i class="fa fa-fw fa-bullseye"></i>
                                    <span class="title">Lead Generation</span>
                                </a>

                                <ul>
                                    <li class="{{ request()->is('mobile/awaiting-bill') ? 'active' : '' }}">
                                        <a href="/mobile/awaiting-bill">
                                            <span class="title">Awaiting Bill</span>

                                            <span class="label text-blue pull-right">{{ NavPopulator::getMobileStatusFigure('awaiting-bill') }}</span>
                                        </a>
                                    </li>

                                    <li class="{{ request()->is('mobile/awaiting-validation') ? 'active' : '' }}">
                                        <a href="/mobile/awaiting-validation">
                                            <span class="title">Awaiting Validation</span>

                                            <span class="label text-warning pull-right">{{ NavPopulator::getMobileStatusFigure('awaiting-validation') }}</span>
                                        </a>
                                    </li>

                                    <li class="{{ request()->is('mobile/awaiting-assignment') ? 'active' : '' }}">
                                        <a href="/mobile/awaiting-assignment">
                                            <span class="title">Awaiting Assignment</span>

                                            <span class="label text-warning pull-right">{{ NavPopulator::getMobileStatusFigure('awaiting-assignment') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        {{--@if(auth()->user()->hasAnyPermission([--}}
                        {{--'awaiting_closer_contact_mobile',--}}
                        {{--'awaiting_callback_mobile',--}}
                        {{--'awaiting_commercials_mobile',--}}
                        {{--'awaiting_proposal_mobile',--}}
                        {{--'awaiting_acceptance_mobile',--}}
                        {{--'awaiting_letterhead_mobile',--}}
                        {{--'awaiting_purchase_order_mobile',--}}
                        {{--'awaiting_credit_check_mobile',--}}
                        {{--'awaiting_fulfilment_mobile',--}}
                        {{--'awaiting_correction_mobile',--}}
                        {{--'awaiting_quality_control_mobile',--}}
                        {{--]))--}}
                        <li>
                            <a href="#">
                                <i class="fa fa-fw fa-line-chart"></i>
                                <span class="title">Sales</span>
                            </a>

                            <ul>
                                <li class="{{ request()->is('mobile/awaiting-closer-contact') ? 'active' : '' }}">
                                    <a href="/mobile/awaiting-closer-contact">
                                        <span class="title">Awaiting Closer Contact</span>

                                        <span class="label text-purple pull-right">{{ NavPopulator::getMobileStatusFigure('awaiting-closer-contact') }}</span>
                                    </a>
                                </li>

                                <li class="{{ request()->is('mobile/awaiting-callback') ? 'active' : '' }}">
                                    <a href="/mobile/awaiting-callback">
                                        <span class="title">Awaiting Callback</span>

                                        <span class="label text-purple pull-right">{{ NavPopulator::getMobileStatusFigure('awaiting-callback') }}</span>
                                    </a>
                                </li>

                                <li class="{{ request()->is('mobile/awaiting-commercials') ? 'active' : '' }}">
                                    <a href="/mobile/awaiting-commercials">
                                        <span class="title">Awaiting Commercials</span>

                                        <span class="label text-purple pull-right">{{ NavPopulator::getMobileStatusFigure('awaiting-commercials') }}</span>
                                    </a>
                                </li>

                                <li class="{{ request()->is('mobile/awaiting-proposal') ? 'active' : '' }}">
                                    <a href="/mobile/awaiting-proposal">
                                        <span class="title">Awaiting-Proposal</span>

                                        <span class="label text-purple pull-right">{{ NavPopulator::getMobileStatusFigure('awaiting-proposal') }}</span>
                                    </a>
                                </li>

                                <li class="{{ request()->is('mobile/awaiting-acceptance') ? 'active' : '' }}">
                                    <a href="/mobile/awaiting-acceptance">
                                        <span class="title">Awaiting Acceptance</span>

                                        <span class="label text-blue pull-right">{{ NavPopulator::getMobileStatusFigure('awaiting-acceptance') }}</span>
                                    </a>
                                </li>

                                <li class="{{ request()->is('mobile/awaiting-customer-information') ? 'active' : '' }}">
                                    <a href="/mobile/awaiting-customer-information">
                                        <span class="title">Awaiting Information</span>

                                        <span class="label text-blue pull-right">{{ NavPopulator::getMobileStatusFigure('awaiting-customer-information') }}</span>
                                    </a>
                                </li>

                                <li class="{{ request()->is('mobile/awaiting-purchase-order') ? 'active' : '' }}">
                                    <a href="/mobile/awaiting-purchase-order">
                                        <span class="title">Awaiting Purchase order</span>

                                        <span class="label text-blue pull-right">{{ NavPopulator::getMobileStatusFigure('awaiting-purchase-order') }}</span>
                                    </a>
                                </li>

                                <li class="{{ request()->is('mobile/awaiting-correction') ? 'active' : '' }}">
                                    <a href="/mobile/awaiting-correction">
                                        <span class="title">Awaiting Correction</span>

                                        <span class="label text-warning pull-right">{{ NavPopulator::getCorrectionStatusFigure() }}</span>
                                    </a>
                                </li>

                                <li class="{{ request()->is('mobile/awaiting-quality-control') ? 'active' : '' }}">
                                    <a href="/mobile/awaiting-quality-control">
                                        <span class="title">Awaiting Quality Control</span>

                                        <span class="label text-secondary pull-right">{{ NavPopulator::getMobileStatusFigure('awaiting-quality-control') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{--@endif--}}

                        @if(auth()->user()->hasAnyPermission(['awaiting_credit_check_mobile', 'awaiting_fulfilment_mobile']))
                            <li>
                                <a href="#">
                                    <i class="fa fa-fw fa-gbp"></i>
                                    <span class="title">Credit Check</span>
                                </a>

                                <ul>
                                    <li class="{{ request()->is('mobile/awaiting-credit-check') ? 'active' : '' }}">
                                        <a href="/mobile/awaiting-credit-check">
                                            <span class="title">Awaiting Credit check</span>

                                            <span class="label text-secondary pull-right">{{ NavPopulator::getMobileStatusFigure('awaiting-credit-check') }}</span>
                                        </a>
                                    </li>

                                    <li class="{{ request()->is('mobile/pending-credit-check') ? 'active' : '' }}">
                                        <a href="/mobile/pending-credit-check">
                                            <span class="title">Pending Credit check</span>

                                            <span class="label text-secondary pull-right">{{ NavPopulator::getMobileStatusFigure('pending-credit-check') }}</span>

                                        </a>
                                    </li>

                                    <li class="{{ request()->is('mobile/awaiting-escalation') ? 'active' : '' }}">
                                        <a href="/mobile/awaiting-escalation">
                                            <span class="title">Awaiting Escalation</span>

                                            <span class="label text-warning pull-right">{{ NavPopulator::getMobileStatusFigure('awaiting-escalation') }}</span>

                                        </a>
                                    </li>

                                    <li class="{{ request()->is('mobile/awaiting-bond-payment') ? 'active' : '' }}">
                                        <a href="/mobile/awaiting-bond-payment">
                                            <span class="title">Awaiting Bond</span>

                                            <span class="label text-warning pull-right">{{ NavPopulator::getMobileStatusFigure('awaiting-bond-payment') }}</span>

                                        </a>
                                    </li>

                                    <li class="{{ request()->is('mobile/bond-agreement-returned') ? 'active' : '' }}">
                                        <a href="/mobile/bond-agreement-returned">
                                            <span class="title">Bond Agreement Returned</span>

                                            <span class="label text-warning pull-right">{{ NavPopulator::getMobileStatusFigure('bond-agreement-returned') }}</span>

                                        </a>
                                    </li>

                                    @if(auth()->user()->hasPermission('awaiting_fulfilment_mobile'))
                                        <li class="{{ request()->is('mobile/fulfilment/awaiting-bond-payment') ? 'active' : '' }}">
                                            <a href="/mobile/fulfilment/awaiting-bond-payment">
                                                <span class="title">Awaiting Bond Confirmation</span>

                                                <span class="label text-warning pull-right">{{ NavPopulator::getAwaitingBondPaymentFigure() }}</span>
                                            </a>
                                        </li>
                                    @endif

                                    <li class="{{ request()->is('mobile/awaiting-proofs') ? 'active' : '' }}">
                                        <a href="/mobile/awaiting-proofs">
                                            <span class="title">Awaiting Proofs</span>

                                            <span class="label text-warning pull-right">{{ NavPopulator::getMobileStatusFigure('awaiting-proofs') }}</span>

                                        </a>
                                    </li>

                                    <li class="{{ request()->is('mobile/pending-proofs') ? 'active' : '' }}">
                                        <a href="/mobile/pending-proofs">
                                            <span class="title">Pending Proofs</span>

                                            <span class="label text-warning pull-right">{{ NavPopulator::getMobileStatusFigure('pending-proofs') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if(auth()->user()->hasPermission('awaiting_fulfilment_mobile'))
                            <li>
                                <a href="#">
                                    <i class="fa fa-fw fa-gears"></i>
                                    <span class="title">Fulfilment</span>
                                </a>

                                <ul>
                                    <li class="{{ request()->is('/mobile/fulfilment/awaiting-pac-codes') ? 'active' : '' }}">
                                        <a href="/mobile/fulfilment/awaiting-pac-codes">
                                            <span class="title">Awaiting PAC Code</span>

                                            <span class="label text-secondary pull-right">{{ NavPopulator::getPacCodeStatusFigure() }}</span>
                                        </a>
                                    </li>

                                    <li class="{{ request()->is('/mobile/fulfilment/awaiting-sims') ? 'active' : '' }}">
                                        <a href="/mobile/fulfilment/awaiting-sims">
                                            <span class="title">Awaiting SIMs</span>

                                            <span class="label text-secondary pull-right">{{ NavPopulator::getAwaitingSimsStatusFigure() }}</span>
                                        </a>
                                    </li>

                                    <li class="{{ request()->is('mobile/fulfilment/awaiting-unlock') ? 'active' : '' }}">
                                        <a href="/mobile/fulfilment/awaiting-unlock">
                                            <span class="title">Awaiting Unlock</span>

                                            <span class="label text-secondary pull-right">{{ NavPopulator::getAwaitingUnlockStatusFigure() }}</span>
                                        </a>
                                    </li>

                                    <li class="{{ request()->is('mobile/fulfilment/pending-unlock') ? 'active' : '' }}">
                                        <a href="/mobile/fulfilment/pending-unlock">
                                            <span class="title">Pending Unlock</span>

                                            <span class="label text-secondary pull-right">{{ NavPopulator::getPendingUnlockStatusFigure() }}</span>
                                        </a>
                                    </li>

                                    <li class="{{ request()->is('mobile/fulfilment/awaiting-port') ? 'active' : '' }}">
                                        <a href="/mobile/fulfilment/awaiting-port">
                                            <span class="title">Awaiting Port</span>

                                            <span class="label text-secondary pull-right">{{ NavPopulator::getAwaitingPortStatusFigure() }}</span>
                                        </a>
                                    </li>

                                    <li class="{{ request()->is('mobile/order-cancelled') ? 'active' : '' }}">
                                        <a href="/mobile/order-cancelled">
                                            <span class="title">Order Cancelled</span>

                                            <span class="label text-danger pull-right">{{ NavPopulator::getMobileStatusFigure('order-cancelled') }}</span>

                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if(auth()->user()->hasPermission('awaiting_fulfilment_mobile'))
                            <li>
                                <a href="#">
                                    <i class="fa fa-fw fa-truck"></i>
                                    <span class="title">Stock</span>
                                </a>

                                <ul>
                                    <li class="{{ request()->is('mobile/fulfilment/awaiting-stock') ? 'active' : '' }}">
                                        <a href="/mobile/fulfilment/awaiting-stock">
                                            <span class="title">Awaiting Stock</span>

                                            <span class="label text-secondary pull-right">{{ NavPopulator::getAwaitingStockStatusFigure() }}</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->is('mobile/fulfilment/awaiting-imei') ? 'active' : '' }}">
                                        <a href="/mobile/fulfilment/awaiting-imei">
                                            <span class="title">Awaiting IMEI</span>

                                            <span class="label text-secondary pull-right">{{ NavPopulator::getAwaitingImeiStatusFigure() }}</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->is('mobile/fulfilment/tenders') ? 'active' : '' }}">
                                        <a href="/mobile/fulfilment/tenders">
                                            <span class="title">Tenders</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if(auth()->user()->hasPermission('awaiting_fulfilment_mobile'))
                            <li>
                                <a href="#">
                                    <i class="fa fa-fw fa-chain"></i>
                                    <span class="title">Connection</span>
                                </a>

                                <ul>
                                    <li class="{{ request()->is('/mobile/fulfilment/awaiting-bcad') ? 'active' : '' }}">
                                        <a href="/mobile/fulfilment/awaiting-bcad">
                                            <span class="title">Awaiting BCAD</span>

                                            <span class="label text-secondary pull-right">{{ NavPopulator::getAwaitingBCADStatusFigure() }}</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->is('/mobile/fulfilment/pending-bcad') ? 'active' : '' }}">
                                        <a href="/mobile/fulfilment/pending-bcad">
                                            <span class="title">Pending BCAD</span>

                                            <span class="label text-secondary pull-right">{{ NavPopulator::getPendingBCADStatusFigure() }}</span>
                                        </a>
                                    </li>

                                    <li class="{{ request()->is('mobile/fulfilment/awaiting-connection') ? 'active' : '' }}">
                                        <a href="/mobile/fulfilment/awaiting-connection">
                                            <span class="title">Awaiting Connection</span>

                                            <span class="label text-secondary pull-right">{{ NavPopulator::getAwaitingConnectionStatusFigure() }}</span>
                                        </a>
                                    </li>

                                    <li class="{{ request()->is('mobile/fulfilment/pending-connection') ? 'active' : '' }}">
                                        <a href="/mobile/fulfilment/pending-connection">
                                            <span class="title">Pending Connection</span>

                                            <span class="label text-secondary pull-right">{{ NavPopulator::getPendingConnectionStatusFigure() }}</span>
                                        </a>
                                    </li>

                                    <li class="{{ request()->is('mobile/fulfilment/connection-deferred') ? 'active' : '' }}">
                                        <a href="/mobile/fulfilment/connection-deferred">
                                            <span class="title">Connection Deferred</span>

                                            <span class="label text-secondary pull-right">{{ NavPopulator::getConnectionDeferredStatusFigure() }}</span>
                                        </a>
                                    </li>

                                    <li class="{{ request()->is('mobile/fulfilment/connection-error') ? 'active' : '' }}">
                                        <a href="/mobile/fulfilment/connection-error">
                                            <span class="title">Connection Error</span>

                                            <span class="label text-secondary pull-right">{{ NavPopulator::getConnectionErrorStatusFigure() }}</span>
                                        </a>
                                    </li>

                                    <li class="{{ request()->is('mobile/fulfilment/connected') ? 'active' : '' }}">
                                        <a href="/mobile/fulfilment/connected">
                                            <span class="title">Connected</span>

                                            <span class="label text-secondary pull-right">{{ NavPopulator::getConnectedStatusFigure() }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        <li>
                            <a href="#">
                                <i class="fa fa-fw fa-folder-open"></i>
                                <span class="title">Insights</span>
                            </a>

                            <ul>
                                @if(auth()->user()->hasPermission('awaiting_fulfilment_mobile'))
                                    <li class="{{ request()->is('mobile/awaiting-fulfilment') ? 'active' : '' }}">
                                        <a href="/mobile/awaiting-fulfilment">
                                            <span class="title">Fulfilment</span>

                                            <span class="label text-secondary pull-right">{{ NavPopulator::getMobileStatusFigure('awaiting-fulfilment') }}</span>

                                        </a>
                                    </li>
                                @endif

                                @if(auth()->user()->hasPermission('awaiting_assignment_mobile'))
                                    <li class="{{ request()->is('mobile/reassignable') ? 'active' : '' }}">
                                        <a href="/mobile/reassignable">
                                            <span class="title">Reassignment</span>

                                            <span class="label text-danger pull-right">{{ NavPopulator::getReassignableOrders() }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if(auth()->user()->hasPermission('recoverable_mobile'))
                                    <li class="{{ request()->is('mobile/recoverable') ? 'active' : '' }}">
                                        <a href="/mobile/recoverable">
                                            <span class="title">Recoverable</span>

                                            <span class="label text-warning pull-right">{{ NavPopulator::getRecoverableOrders() }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if(auth()->user()->hasPermission('vettable_mobile'))
                                    <li class="{{ request()->is('mobile/vettable') ? 'active' : '' }}">
                                        <a href="/mobile/vettable">
                                            <span class="title">Vettable</span>

                                            <span class="label text-warning pull-right">{{ NavPopulator::getVettableOrders() }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if((auth()->user()->hasPermission('create_mobile') && auth()->user()->role_id == 4) || auth()->user()->isAdmin())
                                    <li class="{{ request()->is('mobile/qualified-leads') ? 'active' : '' }}">
                                        <a href="/mobile/qualified-leads">
                                            <span class="title">My Qualified Leads</span>
                                        </a>
                                    </li>
                                @endif

                                @if((auth()->user()->moderatesATeam()))
                                    <li class="{{ request()->is('mobile/team-awaiting-bill') ? 'active' : '' }}">
                                        <a href="/mobile/team-awaiting-bill">
                                            <span class="title">Team Awaiting Bill</span>
                                        </a>
                                    </li>
                                @endif

                                @if(auth()->user()->hasPermission('create_mobile'))
                                    <li class="{{ request()->is('mobile/pipeline') ? 'active' : '' }}">
                                        <a href="/mobile/pipeline">
                                            <span class="title">Sales Pipeline</span>
                                        </a>
                                    </li>
                                @endif

                                @if(auth()->user()->hasPermission('view_connection_log_mobile'))
                                    <li class="{{ request()->is('mobile/connection-log') ? 'active' : '' }}">
                                        <a href="/mobile/connection-log">
                                            <span class="title">Connection Log</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </li>

                    </ul>
                </li>
            @endif

            @if(auth()->user()->hasAnyPermission([
                'read_fixed_line',
            ]))
                <li class="{{ request()->is('fixed-line*') ? 'active opened expanded' : '' }}">
                    <a href="#">
                        <i class="fa fa-fw fa-phone"></i>
                        <span class="title">Fixed Line</span>
                    </a>

                    <ul>
                        <li class="{{ request()->is('fixed-line/awaiting-bill') ? 'active' : '' }}">
                            <a href="/fixed-line/awaiting-bill">
                                <span class="title">Awaiting Bill</span>

                                <span class="label text-blue pull-right">{{ NavPopulator::getFixedLineStatusFigure('awaiting-bill') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('fixed-line/awaiting-validation') ? 'active' : '' }}">
                            <a href="/fixed-line/awaiting-validation">
                                <span class="title">Awaiting Validation</span>

                                <span class="label text-warning pull-right">{{ NavPopulator::getFixedLineStatusFigure('awaiting-validation') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('fixed-line/awaiting-assignment') ? 'active' : '' }}">
                            <a href="/fixed-line/awaiting-assignment">
                                <span class="title">Awaiting Assignment</span>

                                <span class="label text-warning pull-right">{{ NavPopulator::getFixedLineStatusFigure('awaiting-assignment') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('fixed-line/awaiting-closer-contact') ? 'active' : '' }}">
                            <a href="/fixed-line/awaiting-closer-contact">
                                <span class="title">Awaiting Closer Contact</span>

                                <span class="label text-purple pull-right">{{ NavPopulator::getFixedLineStatusFigure('awaiting-closer-contact') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('fixed-line/awaiting-callback') ? 'active' : '' }}">
                            <a href="/fixed-line/awaiting-callback">
                                <span class="title">Awaiting Callback</span>

                                <span class="label text-purple pull-right">{{ NavPopulator::getFixedLineStatusFigure('awaiting-callback') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('fixed-line/awaiting-commercials') ? 'active' : '' }}">
                            <a href="/fixed-line/awaiting-commercials">
                                <span class="title">Awaiting Commercials</span>

                                <span class="label text-purple pull-right">{{ NavPopulator::getFixedLineStatusFigure('awaiting-commercials') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('fixed-line/awaiting-proposal') ? 'active' : '' }}">
                            <a href="/fixed-line/awaiting-proposal">
                                <span class="title">Awaiting Proposal</span>

                                <span class="label text-purple pull-right">{{ NavPopulator::getFixedLineStatusFigure('awaiting-proposal') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('fixed-line/awaiting-acceptance') ? 'active' : '' }}">
                            <a href="/fixed-line/awaiting-acceptance">
                                <span class="title">Awaiting Acceptance</span>

                                <span class="label text-blue pull-right">{{ NavPopulator::getFixedLineStatusFigure('awaiting-acceptance') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('fixed-line/awaiting-customer-information') ? 'active' : '' }}">
                            <a href="/fixed-line/awaiting-customer-information">
                                <span class="title">Awaiting Customer Information</span>

                                <span class="label text-blue pull-right">{{ NavPopulator::getFixedLineStatusFigure('awaiting-customer-information') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('fixed-line/awaiting-purchase-order') ? 'active' : '' }}">
                            <a href="/fixed-line/awaiting-purchase-order">
                                <span class="title">Awaiting Purchase Order</span>

                                <span class="label text-blue pull-right">{{ NavPopulator::getFixedLineStatusFigure('awaiting-purchase-order') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('fixed-line/awaiting-provisioning') ? 'active' : '' }}">
                            <a href="/fixed-line/awaiting-provisioning">
                                <span class="title">Awaiting Provisioning</span>

                                <span class="label text-blue pull-right">{{ NavPopulator::getFixedLineStatusFigure('awaiting-provisioning') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('fixed-line/provisioned') ? 'active' : '' }}">
                            <a href="/fixed-line/provisioned">
                                <span class="title">Provisioned</span>

                                <span class="label text-blue pull-right">{{ NavPopulator::getFixedLineStatusFigure('provisioned') }}</span>
                            </a>
                        </li>

                        @if(auth()->user()->hasPermission('recoverable_fixed_line'))
                            <li class="{{ request()->is('fixed-line/recoverable') ? 'active' : '' }}">
                                <a href="/fixed-line/recoverable">
                                    <span class="title">Recoverable</span>

                                    <span class="label text-warning pull-right">{{ NavPopulator::getFixedLineRecoverableOrders() }}</span>
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->hasPermission('create_fixed_line'))
                            <li class="{{ request()->is('fixed-line/pipeline') ? 'active' : '' }}">
                                <a href="/fixed-line/pipeline">
                                    <span class="title">Sales Pipeline</span>
                                </a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif

            @if(auth()->user()->hasAnyPermission([
                'read_energy',
            ]))
                <li class="{{ request()->is('energy*') ? 'active opened expanded' : '' }}">
                    <a href="#">
                        <i class="fa fa-fw fa-flash"></i>
                        <span class="title">Energy</span>
                    </a>

                    <ul>
                        <li class="{{ request()->is('energy/awaiting-bill') ? 'active' : '' }}">
                            <a href="/energy/awaiting-bill">
                                <span class="title">Awaiting Bill</span>

                                <span class="label text-blue pull-right">{{ NavPopulator::getEnergyStatusFigure('awaiting-bill') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('energy/awaiting-letter-of-authority') ? 'active' : '' }}">
                            <a href="/energy/awaiting-letter-of-authority">
                                <span class="title">Awaiting LoA</span>

                                <span class="label text-warning pull-right">{{ NavPopulator::getEnergyStatusFigure('awaiting-letter-of-authority') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('energy/awaiting-validation') ? 'active' : '' }}">
                            <a href="/energy/awaiting-validation">
                                <span class="title">Awaiting Validation</span>

                                <span class="label text-warning pull-right">{{ NavPopulator::getEnergyStatusFigure('awaiting-validation') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('energy/awaiting-assignment') ? 'active' : '' }}">
                            <a href="/energy/awaiting-assignment">
                                <span class="title">Awaiting Assignment</span>

                                <span class="label text-warning pull-right">{{ NavPopulator::getEnergyStatusFigure('awaiting-assignment') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('energy/awaiting-closer-contact') ? 'active' : '' }}">
                            <a href="/energy/awaiting-closer-contact">
                                <span class="title">Awaiting Closer Contact</span>

                                <span class="label text-purple pull-right">{{ NavPopulator::getEnergyStatusFigure('awaiting-closer-contact') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('energy/awaiting-callback') ? 'active' : '' }}">
                            <a href="/energy/awaiting-callback">
                                <span class="title">Awaiting Callback</span>

                                <span class="label text-purple pull-right">{{ NavPopulator::getEnergyStatusFigure('awaiting-callback') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('energy/awaiting-current-supplier-response') ? 'active' : '' }}">
                            <a href="/energy/awaiting-current-supplier-response">
                                <span class="title f-s-80">Awaiting Supplier Response</span>

                                <span class="label text-purple pull-right">{{ NavPopulator::getEnergyStatusFigure('awaiting-current-supplier-response') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('energy/awaiting-tender-request') ? 'active' : '' }}">
                            <a href="/energy/awaiting-tender-request">
                                <span class="title f-s-80">Awaiting Tender Request</span>

                                <span class="label text-warning pull-right">{{ NavPopulator::getEnergyStatusFigure('awaiting-tender-request') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('energy/awaiting-tender-responses') ? 'active' : '' }}">
                            <a href="/energy/awaiting-tender-responses">
                                <span class="title f-s-80">Awaiting Tender Responses</span>

                                <span class="label text-blue pull-right">{{ NavPopulator::getEnergyStatusFigure('awaiting-tender-responses') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('energy/awaiting-quote') ? 'active' : '' }}">
                            <a href="/energy/awaiting-quote">
                                <span class="title">Awaiting Quote</span>

                                <span class="label text-blue pull-right">{{ NavPopulator::getEnergyStatusFigure('awaiting-quote') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('energy/awaiting-acceptance') ? 'active' : '' }}">
                            <a href="/energy/awaiting-acceptance">
                                <span class="title">Awaiting Acceptance</span>

                                <span class="label text-secondary pull-right">{{ NavPopulator::getEnergyStatusFigure('awaiting-acceptance') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('energy/accepted') ? 'active' : '' }}">
                            <a href="/energy/accepted">
                                <span class="title">Accepted</span>

                                <span class="label text-success pull-right">{{ NavPopulator::getEnergyStatusFigure('accepted') }}</span>
                            </a>
                        </li>


                        @if(auth()->user()->hasPermission('recoverable_energy'))
                            <li class="{{ request()->is('energy/recoverable') ? 'active' : '' }}">
                                <a href="/energy/recoverable">
                                    <span class="title">Recoverable</span>

                                    <span class="label text-warning pull-right">{{ NavPopulator::getEnergyRecoverableOrders() }}</span>
                                </a>
                            </li>
                        @endif


                        <li class="{{ request()->is('energy/quotable') ? 'active' : '' }}">
                            <a href="/energy/quotable">
                                <span class="title">Quotable</span>
                            </a>
                        </li>

                        @if(auth()->user()->hasPermission('show_all_leads_energy'))
                            <li class="{{ request()->is('energy/pipeline') ? 'active' : '' }}">
                                <a href="/energy/pipeline">
                                    <span class="title">Sales Pipeline</span>
                                </a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif

            @if(auth()->user()->hasAnyPermission([
                'read_applications',
                'manage_positions'
            ]))
                <li class="{{ request()->is('recruitment*') ? 'active opened expanded' : '' }}">
                    <a href="#">
                        <i class="fa fa-fw fa-users"></i>
                        <span class="title">Recruitment</span>
                    </a>
                    <ul>
                        @if(auth()->user()->hasPermission('read_applications'))
                            <li class="{{ request()->is('recruitment/applications*') ? 'active' : '' }}">
                                <a href="/recruitment/applications">
                                    <span class="title">Applications</span>
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasPermission('manage_positions'))
                            <li class="{{ request()->is('recruitment/positions*') ? 'active' : '' }}">
                                <a href="/recruitment/positions">
                                    <span class="title">Positions</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
        </ul>
    </li>


    @if(auth()->user()->hasAnyPermission([
        'view_reports',
        'reports-closers',
        'reports-qualified-bill',
        'reports-callbacks',
        'reports-bills-requirements',
        'reports-appointment-booking',
        'reports-appointments-confirmed',
        'reports-field-sales',
        'reports-appointments-sat',
        'reports-calendar-events',
        'reports-pitch-close',
        'reports-blown-appointments',
        'reports-acquisitions'
    ]))
        <li class="{{ request()->is('reports*') ? 'active opened expanded' : '' }}">
            <a href="#">
                <i class="fa fa-fw fa-file-text-o"></i>
                <span class="title">Reports</span>
            </a>

            <ul>
                @if(auth()->user()->hasAnyPermission([
                    'view_reports',
                    'reports-closers',
                    'reports-qualified-bill',
                    'reports-callbacks',
                    'reports-bills-requirements',
                    'reports-appointment-booking',
                    'reports-appointments-confirmed',
                    'reports-field-sales',
                    'reports-appointments-sat',
                    'reports-pitch-close',
                    'reports-blown-appointments',
                    'reports-acquisitions',
                    'reports-validators'
                ]))
                    <li class="{{ request()->is('reports/mobile*') ? 'active opened expanded' : '' }}">
                        <a href="#">
                            <i class="fa fa-fw fa-mobile"></i>
                            <span class="title">Mobile</span>
                        </a>

                        <ul>
                            @if(auth()->user()->hasPermission('reports-validators') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/mobile/validators') ? 'active' : '' }}">
                                    <a href="/reports/mobile/validators">
                                        <span class="title">Validators</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-closers') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/mobile/closers') ? 'active' : '' }}">
                                    <a href="/reports/mobile/closers">
                                        <span class="title">Closers</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-agents') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/mobile/agents') ? 'active' : '' }}">
                                    <a href="/reports/mobile/agents">
                                        <span class="title">Agents</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-qualified-bill') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/mobile/qualified-bill') ? 'active' : '' }}">
                                    <a href="/reports/mobile/qualified-bill">
                                        <span class="title">Qualified Bill</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-callbacks') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/mobile/callbacks') ? 'active' : '' }}">
                                    <a href="/reports/mobile/callbacks">
                                        <span class="title">Callbacks</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-bills-requirements') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/mobile/bills-requirements') ? 'active' : '' }}">
                                    <a href="/reports/mobile/bills-requirements">
                                        <span class="title">Bills vs Requirements</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-appointment-booking') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/mobile/appointment-booking') ? 'active' : '' }}">
                                    <a href="/reports/mobile/appointment-booking">
                                        <span class="title">Appointment Booking</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-appointments-confirmed') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/mobile/appointments-confirmed') ? 'active' : '' }}">
                                    <a href="/reports/mobile/appointments-confirmed">
                                        <span class="title">Appointments Confirmed</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-field-sales') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/mobile/field-sales') ? 'active' : '' }}">
                                    <a href="/reports/mobile/field-sales">
                                        <span class="title">Field Sales</span>
                                    </a>
                                </li>
                            @endif

                            {{--@if(auth()->user()->hasPermission('reports-appointments-sat') || auth()->user()->hasPermission('view_reports'))--}}
                            {{--<li class="{{ request()->is('reports/mobile/appointments-sat') ? 'active' : '' }}">--}}
                            {{--<a href="/reports/mobile/appointments-sat">--}}
                            {{--<span class="title">Appointments to be sat</span>--}}
                            {{--</a>--}}
                            {{--</li>--}}
                            {{--@endif--}}

                            @if(auth()->user()->hasPermission('reports-closer-statstics') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/mobile/closer-statistics') ? 'active' : '' }}">
                                    <a href="/reports/mobile/closer-statistics">
                                        <span class="title">Closer Statistics</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-pitch-close') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/mobile/pitch-close') ? 'active' : '' }}">
                                    <a href="/reports/mobile/pitch-close">
                                        <span class="title">Pitch & Close</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-blown-appointments') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/mobile/blown-appointments') ? 'active' : '' }}">
                                    <a href="/reports/mobile/blown-appointments">
                                        <span class="title">Blown Invalid Appointments</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-acquisitions') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/mobile/acquisitions') ? 'active' : '' }}">
                                    <a href="/reports/mobile/acquisitions">
                                        <span class="title">Yesterday's Acquisitions</span>
                                    </a>
                                </li>
                            @endif


                        </ul>
                @endif

                @if(auth()->user()->hasAnyPermission([
                    'view_reports',
                    'reports-fixed-line-closers',
                    'reports-fixed-line-qualified-bill',
                    'reports-fixed-line-callbacks',
                    'reports-fixed-line-bills-requirements',
                    'reports-fixed-line-appointment-booking',
                    'reports-fixed-line-field-sales',
                    'reports-fixed-line-appointments-sat',
                    'reports-fixed-line-pitch-close',
                ]))
                    <li class="{{ request()->is('reports/fixed-line*') ? 'active opened expanded' : '' }}">
                        <a href="#">
                            <i class="fa fa-fw fa-phone"></i>
                            <span class="title">Fixed Line</span>
                        </a>

                        <ul>

                            @if(auth()->user()->hasPermission('reports-fixed-line-closers') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/fixed-line/closers') ? 'active' : '' }}">
                                    <a href="/reports/fixed-line/closers">
                                        <span class="title">Closers</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-fixed-line-agents') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/fixed-line/agents') ? 'active' : '' }}">
                                    <a href="/reports/fixed-line/agents">
                                        <span class="title">Agents</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-fixed-line-qualified-bill') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/fixed-line/qualified-bill') ? 'active' : '' }}">
                                    <a href="/reports/fixed-line/qualified-bill">
                                        <span class="title">Qualified Bill</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-fixed-line-callbacks') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/fixed-line/callbacks') ? 'active' : '' }}">
                                    <a href="/reports/fixed-line/callbacks">
                                        <span class="title">Callbacks</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-fixed-line-bills-requirements') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/fixed-line/bills-requirements') ? 'active' : '' }}">
                                    <a href="/reports/fixed-line/bills-requirements">
                                        <span class="title">Bills vs Requirements</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-fixed-line-appointment-booking') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/fixed-line/appointment-booking') ? 'active' : '' }}">
                                    <a href="/reports/fixed-line/appointment-booking">
                                        <span class="title">Appointment Booking</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-fixed-line-field-sales') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/fixed-line/field-sales') ? 'active' : '' }}">
                                    <a href="/reports/fixed-line/field-sales">
                                        <span class="title">Field Sales</span>
                                    </a>
                                </li>
                            @endif

                            {{--@if(auth()->user()->hasPermission('reports-fixed-line-appointments-sat') || auth()->user()->hasPermission('view_reports'))--}}
                            {{--<li class="{{ request()->is('reports/fixed-line/appointments-sat') ? 'active' : '' }}">--}}
                            {{--<a href="/reports/fixed-line/appointments-sat">--}}
                            {{--<span class="title">Appointments to be sat</span>--}}
                            {{--</a>--}}
                            {{--</li>--}}
                            {{--@endif--}}

                            @if(auth()->user()->hasPermission('reports-fixed-line-closer-statstics') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/fixed-line/closer-statistics') ? 'active' : '' }}">
                                    <a href="/reports/fixed-line/closer-statistics">
                                        <span class="title">Closer Statistics</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-fixed-line-pitch-close') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/fixed-line/pitch-close') ? 'active' : '' }}">
                                    <a href="/reports/fixed-line/pitch-close">
                                        <span class="title">Pitch & Close</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                @endif

                @if(auth()->user()->hasAnyPermission([
                    'view_reports',
                    'reports-calendar-events',
                    'reports-general-branch',
                ]))

                    <li class="{{ request()->is('reports/general*') ? 'active opened expanded' : '' }}">
                        <a href="#">
                            <i class="fa fa-fw fa-info-circle"></i>
                            <span class="title">General</span>
                        </a>

                        <ul>
                            @if(auth()->user()->hasPermission('reports-calendar-events') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/general/calendar-events') ? 'active' : '' }}">
                                    <a href="/reports/general/calendar-events">
                                        <span class="title">Calendar Events</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-journey-team-survey') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/general/journey-team-survey') ? 'active' : '' }}">
                                    <a href="/reports/general/journey-team-survey">
                                        <span class="title">Journey Team Survey</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('reports-general-branch') || auth()->user()->hasPermission('view_reports'))
                                <li class="{{ request()->is('reports/general/branch') ? 'active' : '' }}">
                                    <a href="/reports/general/branch">
                                        <span class="title">Branch</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


                @if(Gate::allows('view-cashflow') || Gate::allows('view-profitability'))
                    <li class="{{ request()->is('reports/general*') ? 'active opened expanded' : '' }}">
                        <a href="#">
                            <i class="fa fa-fw fa-gbp"></i>
                            <span class="title">Finance</span>
                        </a>

                        <ul>
                            @if(Gate::allows('view-cashflow'))
                                <li class="{{ request()->is('/reports/finance/cashflow*') ? 'active' : '' }}">
                                    <a href="/reports/finance/cashflow">
                                        <i class="fa fa-fw fa-gbp"></i>
                                        <span class="title">Cashflow</span>
                                    </a>
                                </li>
                            @endif

                            @if(Gate::allows('view-profitability'))
                                <li class="{{ request()->is('/reports/finance/branch-profitability*') ? 'active' : '' }}">
                                    <a href="/reports/finance/branch-profitability">
                                        <i class="fa fa-fw fa-bank"></i>
                                        <span class="title">Branch Profitability</span>
                                    </a>
                                </li>
                            @endif


                            @if(Gate::allows('view-cashflow'))
                                <li class="{{ request()->is('/reports/mobile/fulfilment-overview*') ? 'active' : '' }}">
                                    <a href="/reports/mobile/fulfilment-overview">
                                        <i class="fa fa-fw fa-gbp"></i>
                                        <span class="title">Fulfilment Overview</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            </ul>

        </li>

    @endif



    @if(auth()->user()->hasAnyPermission(['create_users_admin', 'create_teams_admin', 'create_tariffs_mobile', 'manage_hr']))
        <li class="{{ request()->is('admin*') ? 'active opened expanded' : '' }}">
            <a href="#">
                <i class="fa fa-fw fa-cog"></i>
                <span class="title">Admin</span>
            </a>

            <ul>
                @if(auth()->user()->hasPermission('create_tariffs_mobile'))
                    <li class="{{ request()->is('admin/mobile*') ? 'active opened expanded' : '' }}">
                        <a href="#">
                            <i class="fa fa-fw fa-mobile-phone"></i>
                            <span class="title">Mobile</span>
                        </a>

                        <ul>
                            <li class="{{ request()->is('/admin/mobile/tariffs*') ? 'active' : '' }}">
                                <a href="/admin/mobile/tariffs">
                                    <span class="title">Tariffs</span>
                                </a>
                            </li>
                        </ul>

                        <ul>
                            <li class="{{ request()->is('/admin/mobile/phones*') ? 'active' : '' }}">
                                <a href="/admin/mobile/phones">
                                    <span class="title">Phones</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if(auth()->user()->hasAnyPermission(['create_users_admin', 'create_teams_admin']))
                    <li class="{{ request()->is('admin/users*') || request()->is('admin/teams*') ? 'active opened expanded' : '' }}">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span class="title">Users</span>
                        </a>

                        <ul>
                            @if(auth()->user()->hasPermission('create_users_admin'))
                                <li class="{{ request()->is('admin/users*') ? 'active' : '' }}">
                                    <a href="/admin/users">
                                        <i class="fa fa-fw fa-user"></i>
                                        <span class="title">Users</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('create_teams_admin'))
                                <li class="{{ request()->is('admin/teams*') ? 'active' : '' }}">
                                    <a href="/admin/teams">
                                        <i class="fa fa-fw fa-users"></i>
                                        <span class="title">Teams</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->isAdmin())
                                <li class="{{ request()->is('admin/users/permission-templates*') ? 'active' : '' }}">
                                    <a href="/admin/users/permission-templates">
                                        <i class="fa fa-fw fa-fast-forward"></i>
                                        <span class="title">Permission Template</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


                @if(auth()->user()->hasAnyPermission(['manage_hr']))
                    <li class="{{ request()->is('admin/hr*') || request()->is('admin/teams*') ? 'active opened expanded' : '' }}">
                        <a href="#">
                            <i class="fa fa-fw fa-users"></i>
                            <span class="title">HR</span>
                        </a>

                        <ul>
                            <li class="{{ request()->is('admin/hr*') ? 'active' : '' }}">
                                <a href="/admin/hr/">
                                    <i class="fa fa-fw fa-users"></i>
                                    <span class="title">HR Profiles</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if(auth()->user()->isAdmin())
                    <li class="{{ request()->is('faq*') ? 'active opened expanded' : '' }}">
                        <a href="">
                            <i class="fa fa-fw fa-question-circle"></i>
                            <span class="title">Faq</span>
                        </a>

                        <ul>
                            <li class="{{ request()->is('/faq/questions*') ? 'active' : '' }}">
                                <a href="/faq/questions">
                                    <i class="fa fa-fw fa-question"></i>
                                    <span class="title">Questions</span>

                                    <span class="label text-warning pull-right">{{ NavPopulator::getMobileStatusFigure('awaiting-validation') }}</span>
                                    <span class="label text-success pull-right">{{ NavPopulator::getQuestionsAsked() }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </li>
    @endif
</ul>
