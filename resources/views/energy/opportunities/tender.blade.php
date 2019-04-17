<table>
    <tr>
        <th>Customer Name</th>
        <th>Company Type (Sole/Partner/Ltd)</th>
        <th>Company Registration No. (if limited)</th>
        <th>DMC Name</th>
        <th>DMC Date of Birth (if sole trader)</th>
        <th>DMC Telephone Number</th>
        <th>DMC Email Address</th>
        <th>Site Address</th>
        <th>Billing Address</th>
        <th>Top Line and Bottom Line of MPAN (Elec)</th>
        <th>MPRN (Gas) Number</th>
        <th>Annual Quantity (integer)</th>
        <th>KVA</th>
        <th>Uplift (pence, can be decimal)</th>
        <th>Contract Start Date</th>
        <th>Term of contract</th>
    </tr>
    @foreach($energyOpportunity->meters as $meter)
        <tr>
            <th>{{ $energyOpportunity->customer->company_name }}</th>
            <th>Company Type (Sole/Partner/Ltd)</th>
            <th>Company Registration No. (if limited)</th>
            <th>DMC Name</th>
            <th>DMC Date of Birth (if sole trader)</th>
            <th>DMC Telephone Number</th>
            <th>DMC Email Address</th>
            <th>{{ $meter->site->address }}</th>
            <th>Billing Address</th>
            <th>Top Line and Bottom Line of MPAN (Elec)</th>
            <th>MPRN (Gas) Number</th>
            <th>Annual Quantity (integer)</th>
            <th>KVA</th>
            <th>Uplift (pence, can be decimal)</th>
            <th>Contract Start Date</th>
            <th>Term of contract</th>
        </tr>
    @endforeach
</table>