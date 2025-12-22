<h2>Laporan Stok Keluar</h2>
<p>Periode: {{ $start }} s/d {{ $end }}</p>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Invoice</th>
            <th>Produk</th>
            <th>Qty</th>
            <th>Harga Jual</th>
            <th>Total Penjualan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
            <tr>
                <td>{{ $row->date }}</td>
                <td>{{ $row->invoice }}</td>
                <td>{{ $row->product_name }}</td>
                <td>{{ $row->qty }}</td>
                <td>{{ number_format($row->capital_price) }}</td>
                <td>{{ number_format($row->qty * $row->capital_price) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
