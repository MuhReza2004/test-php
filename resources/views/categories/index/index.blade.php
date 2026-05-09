@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Daftar Kategori</span>
                    <a href="{{url('categories/form/new')}}" class="btn btn-sm btn-success">Tambah Kategori</a>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <input type="text" id="filter-kode" class="form-control" placeholder="Filter Kode">
                        </div>
                        <div class="col-md-3">
                            <input type="text" id="filter-nama" class="form-control" placeholder="Filter Nama">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary btn-get-data">Filter</button>
                            <span id="loading-filter" style="display: none;">Loading...</span>
                        </div>
                    </div>

                    <table id="table-categories" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table-categories').DataTable({
            searching: false,
            order: [[0, 'desc']],
        });
        getData();
    });

    $('.btn-get-data').click(function() {
        getData();
    });

    function getData(){
        $('#loading-filter').show();
        var dataTableObj = $('#table-categories').DataTable();
        var filter_kode = $('#filter-kode').val();
        var filter_nama = $('#filter-nama').val();
        
        dataTableObj.clear().draw();

        $.ajax({
            url: '{{url("categories/search")}}',
            dataType: 'json',
            data: {
                kode: filter_kode,
                nama: filter_nama
            },
            success: function(results) {
                var data = results.data;
                $.each(data, function(index, item) {
                    var html_action = `
                        <a href="{{url('categories/view')}}/` + item.id + `" class="btn btn-sm btn-primary">View</a>
                        <a href="{{url('categories/form/edit')}}/` + item.id + `" class="btn btn-sm btn-info text-white">Edit</a>
                        <a href="{{url('categories/delete')}}/` + item.id + `" class="btn btn-sm btn-danger" onclick="return confirm('Hapus kategori ini?')">Delete</a>
                    `;

                    dataTableObj.row.add([
                        item.id,
                        item.kode,
                        item.nama,
                        html_action
                    ]).draw(true);
                });
                $('#loading-filter').hide();
            },
            error: function() {
                alert('Gagal mengambil data');
                $('#loading-filter').hide();
            }
        });
    }
</script>
@endsection
