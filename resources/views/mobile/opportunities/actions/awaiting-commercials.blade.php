@if(auth()->user()->hasPermission('use_tariff_match_mobile'))
    @if(auth()->user()->hasPermission('use_deal_calc_mobile') && count($opportunity->activeDealCalculators) < 1)
        <div class="row">
            <div class="col-sm-12">
                <a class="btn btn-warning pull-right" id="show-deal-calc">Use Deal Calculator</a>
                <a class="btn btn-warning pull-right" id="show-tariff-match">Use Tariff Match</a>
            </div>
        </div>

        <div id="deal-calc">
            <deal-calc :customer="{{ $customer->id }}" :opportunity="{{ $opportunity->id }}"
                       :status_id="{{ $opportunity->mobile_opportunity_status_id }}"></deal-calc>
        </div>
    @endif


    @if(auth()->user()->hasPermission('use_deal_calc_mobile') && !$opportunity->tariffMatch && count($opportunity->activeDealCalculators) > 0)
        <div id="deal-calc">
            <deal-calc :customer="{{ $customer->id }}" :opportunity="{{ $opportunity->id }}"
                       :status_id="{{ $opportunity->mobile_opportunity_status_id }}"></deal-calc>
        </div>
    @else
        <div id="tariff-match">
            <tariff-match :customer="{{ $customer->id }}" :opportunity="{{ $opportunity->id }}" :user_level="{{ auth()->user()->role_id }}"></tariff-match>
        </div>
    @endif
@elseif(auth()->user()->hasPermission('use_deal_calc_mobile'))
    <deal-calc :customer="{{ $customer->id }}" :opportunity="{{ $opportunity->id }}"
               :status_id="{{ $opportunity->mobile_opportunity_status_id }}"></deal-calc>
@else
    <p>You do not have the correct permissions to create a deal.</p>
@endif


@section('scripts')
    @parent
    @if(auth()->user()->hasPermission('use_deal_calc_mobile') && count($opportunity->activeDealCalculators) < 1)
        <script>
            $('#deal-calc').hide()
            $('#show-tariff-match').hide()

            $(document).ready(function () {
                $('#show-deal-calc').click(function (e) {
                    e.preventDefault()

                    $('#show-deal-calc').hide()

                    $('#show-tariff-match').show()

                    $('#tariff-match').slideUp()

                    $('#deal-calc').slideDown()
                })

                $('#show-tariff-match').click(function (e) {
                    e.preventDefault()

                    $('#show-tariff-match').hide()

                    $('#show-deal-calc').show()

                    $('#deal-calc').slideUp()

                    $('#tariff-match').slideDown()
                })
            })
        </script>
    @endif
@endsection