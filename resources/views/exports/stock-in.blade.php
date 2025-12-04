<h2>Laporan Stok Masuk</h2>
<p>Periode: {{ $start }} s/d {{ $end }}</p>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Invoice</th>
            <th>Produk</th>
            <th>Qty</th>
            <th>Harga Modal</th>
            <th>Total Modal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
            <tr>
                <td>{{ $row->date }}</td>
                <td>{{ $row->invoice }}</td>
                <td>{{ $row->product->name }}</td>
                <td>{{ $row->qty }}</td>
                <td>{{ number_format($row->product->capital_price) }}</td>
                <td>{{ number_format($row->qty * $row->product->capital_price) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
