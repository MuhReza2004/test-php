<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    var start_date = '';
    var end_date = '';
    var data_per_fetch = 500;
    var data_fetched = 0;

    $(document).ready(function() {
        $('#table').DataTable({
            searching: false,
            order: [[0, 'desc']],
        });
        getData()
    });

    $('.btn-get-data').click(function() {
        getData()
    })

    function getData(){
        
        $('#loading-filter').show();
        var dataTableObj = $('#table').DataTable();
        var filter_kode = $('#filter-kode').val()
        var filter_nama = $('#filter-nama').val()
        var filter_harga_min = $('#filter-harga-min').val()
        var filter_harga_max = $('#filter-harga-max').val()
        dataTableObj.clear().draw();

        $.ajax({
            url: '{{url("master-items/search")}}',
            dataType: 'json',
            tryCount: 0,
            retryLimit: 3,
            data: {
                'kode': filter_kode,
                'nama': filter_nama,
                'hargamin': filter_harga_min,
                'hargamax': filter_harga_max
            },
            success: function(results) {
                var data = results.data

                $.each(data, function(index, item) {
                    var harga_jual = Math.round(item.harga_beli + item.harga_beli * item.laba / 100);
                    var kode = item.kode;

                    var foto_url = item.foto ? '{{asset("foto")}}/' + item.foto : 'https://via.placeholder.com/50';
                    var html_foto = `<img src="` + foto_url + `" width="50" height="50" style="object-fit: cover;">`;

                    var categories_html = '';
                    if (item.categories && item.categories.length > 0) {
                        var names = item.categories.map(function(cat) {
                            return `<span class="badge bg-info text-dark">` + cat.nama + `</span>`;
                        });
                        categories_html = names.join(' ');
                    } else {
                        categories_html = '-';
                    }

                    var html_view = `<a href="{{url('master-items/view/')}}/` + kode + `" class="btn btn-sm btn-primary">View</a>`;

                    var row = [
                        html_foto,
                        item.kode,
                        item.nama,
                        categories_html,
                        item.jenis,
                        item.harga_beli,
                        harga_jual,
                        item.supplier,
                        html_view
                    ];

                    dataTableObj.row.add(row).draw(true);
                });
                $('#loading-filter').hide();
            },
            error: function(xhr, textStatus, errorThrown) {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    $.ajax(this);
                    return;
                }
                alert('Terjadi kesalahan server, tidak dapat mengambil data')
                $('#loading-filter').hide();

                return;
            }
        })
    }
</script>