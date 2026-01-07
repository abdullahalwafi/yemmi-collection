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
                <td>{{ \Carbon\Carbon::parse($row->date)->format('d-m-Y') }}</td>
                <td>{{ $row->invoice }}</td>
                <td>{{ $row->product_name }}</td>
                <td>{{ $row->qty }}</td>
                <td>{{ number_format($row->capital_price, 0, ',', '.') }}</td>
                <td>{{ number_format($row->total_modal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
