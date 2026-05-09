@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $method == 'new' ? 'Tambah' : 'Edit' }} Kategori</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('categories/form/'.$method.'/'.$item->id) }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label>Kode Kategori</label>
                            <input type="text" class="form-control" name="kode" value="{{ old('kode', $item->kode) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Nama Kategori</label>
                            <input type="text" class="form-control" name="nama" value="{{ old('nama', $item->nama) }}" required>
                        </div>

                        <div class="mt-4">
                            <a href="{{ url('categories') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
