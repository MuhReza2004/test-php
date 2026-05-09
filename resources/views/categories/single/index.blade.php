@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="mb-3 d-flex justify-content-between">
                <a href="{{ url('categories') }}" class="btn btn-secondary">Kembali ke Daftar</a>
                <a href="{{ url('categories/print-pdf/'.$category->id) }}" class="btn btn-danger">Download PDF</a>
            </div>

            <div class="card mb-4">
                <div class="card-header">Detail Kategori</div>
                <div class="card-body">
                    <table class="table table-borderless w-auto">
                        <tr>
                            <th width="150">Kode</th>
                            <td>: {{ $category->kode }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>: {{ $category->nama }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Daftar Item dalam Kategori Ini</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jenis</th>
                                <th>Harga Beli</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($category->masterItems as $item)
                            <tr>
                                <td>
                                    @if($item->foto)
                                        <img src="{{ asset('foto/'.$item->foto) }}" width="40" height="40" style="object-fit: cover;">
                                    @else
                                        <img src="https://via.placeholder.com/40" width="40">
                                    @endif
                                </td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->jenis }}</td>
                                <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada item dalam kategori ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
