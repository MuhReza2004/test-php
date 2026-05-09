<!DOCTYPE html>
<html>
<head>
    <title>Print Kategori - {{ $category->nama }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th, .data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .data-table th { background-color: #f2f2f2; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 10px; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN KATEGORI ITEM</h2>
    </div>

    <table class="info-table">
        <tr>
            <th width="100">Nama Kategori</th>
            <td>: {{ $category->nama }}</td>
        </tr>
        <tr>
            <th>Kode Kategori</th>
            <td>: {{ $category->kode }}</td>
        </tr>
    </table>

    <h4>Daftar Item dalam Kategori Ini</h4>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jenis</th>
                <th>Harga Beli</th>
            </tr>
        </thead>
        <tbody>
            @forelse($category->masterItems as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->kode }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->jenis }}</td>
                <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Belum ada item dalam kategori ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d-m-Y H:i:s') }}
    </div>
</body>
</html>
