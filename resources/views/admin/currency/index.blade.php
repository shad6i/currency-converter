

    <h1>Currency Rates</h1>
    <table>
        <thead>
        <tr>
            <th>Currency</th>
            <th>Rate</th>
            <th>Last Updated</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rates as $rate)
            <tr>
                <td>{{ $rate->currency_code }}</td>
                <td>{{ $rate->rate }}</td>
                <td>{{ $rate->updated_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

