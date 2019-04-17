<p>Hi team</p>

<p>
    Please find attached connection details, for {{ $opportunity->customer->company_name }}. Can you please confirm once
    the connections have been processed?
</p>

@if($opportunity->selectedDealCalculator->first()->overview->bcad > 0 || $opportunity->selectedDealCalculator->first()->overview->monthsFree > 0)
    <p>
        Note:
    </p>
    <ul>
        @if($opportunity->selectedDealCalculator->first()->overview->bcad > 0)
            <li>BCAD is reduced to:
                @foreach($opportunity->selectedDealCalculator->first()->primaryConnections as $connection)
                    {{ $connection->tariff->type->name }} {{ $connection->tariff->tariff_code }} -
                    £{{ $connection->cost }},
                @endforeach
            </li>
        @endif

        @if($opportunity->selectedDealCalculator->first()->overview->monthsFree > 0)
            <li>+ {{  $opportunity->selectedDealCalculator->first()->overview->monthsFree }} Months FOC</li>
        @endif
    </ul>
@endif

<p>Many Thanks</p>

<p>{{ $user->name }}</p>