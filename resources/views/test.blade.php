<table>
    <tr>
        <th>Customer Name</th>
        <td>Assigned To</td>
        <th>Bond Payment Ref</th>

    @foreach($deals as $deal)
        <tr>
            <td>{{ $deal->customer->company_name }}</td>
            <td>{{ $deal->activeAssigned->first()->name ?? 'No Assigned' }}</td>
            <td>{{ $deal->bond_payment_reference }}</td>
        </tr>
    @endforeach
</table>