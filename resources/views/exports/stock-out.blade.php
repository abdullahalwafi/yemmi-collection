<h2>Laporan Stok Keluar</h2>
<p>Periode: {{ $start }} s/d {{ $end }}</p>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Invoice</th>
            <th>Produk</th>
            <th class="text-right">Qty</th>
            <th class="text-right">Harga</th>
            <th class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
            <tr>
                <td>{{ \Carbon\Carbon::parse($row->date)->format('d-m-Y') }}</td>
                <td>{{ $row->invoice }}</td>
                <td>{{ $row->product_name }}</td>
                <td class="text-right">{{ $row->qty }}</td>
                <td class="text-right">Rp {{ number_format($row->capital_price) }}</td>
                <td class="text-right">Rp {{ number_format($row->qty * $row->capital_price) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
