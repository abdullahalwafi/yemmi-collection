<h2>Laporan Produk</h2>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>#</th>
            <th>Produk</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Modal</th>
            <th>Harga Jual</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->category->name }}</td>
                <td>{{ $p->qty }}</td>
                <td>{{ number_format($p->capital_price) }}</td>
                <td>{{ number_format($p->price) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
