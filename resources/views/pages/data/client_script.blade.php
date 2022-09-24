<script>
    // fungsi untuk mengambil data dari database
    function datatable() {
        $('#datatable').DataTable().destroy();
        $('#datatable').DataTable({
            scrollY: '50vh',
            searching: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('client.get') }}",
                data: function(d) {
                    d.no_sambungan = $('input[name=no_sambungan]').val();
                    d.name = $('input[name=name]').val();
                    d.alamat = $('input[name=alamat]').val();
                    d.status = $('#filterActive').val();
                    d.date = $('input[name=date]').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tgl_masuk',
                    name: 'tgl_masuk'
                },
                {
                    data: 'no_sambungan',
                    name: 'no_sambungan'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'alamat',
                    name: 'alamat'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
            order: [
                [1, 'desc']
            ]
        });
    }
    datatable();
    // tombol cari
    $('.search').click(function(e) {
        e.preventDefault();
        datatable();
    });
    // tombol refresh data
    $('.refresh').click(function(e) {
        e.preventDefault();
        $('input[name=no_sambungan]').val('');
        $('input[name=name]').val('');
        $('input[name=alamat]').val('');
        $('input[name=status]').val('all');
        $('input[name=date]').val('');
        datatable();
    });
    // mengosongkan field pencarian lain lalu cari data
    $('#filterActive').change(function(e) {
        e.preventDefault();
        $('input[name=no_sambungan]').val('');
        $('input[name=name]').val('');
        $('input[name=alamat]').val('');
        $('input[name=date]').val('');
        datatable();
    });

    // hapus data
    function deleteConfirm(id, name) {
        console.log(id, name);
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Menghapus data " + name + " ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('clients') }}" + '/delete/' + id,
                    type: "POST",
                    data: {
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        Swal.fire(
                            'Terhapus!',
                            'Data berhasil dihapus.',
                            'success'
                        )
                        datatable();
                    },
                    error: function(data) {
                        console.log(data);
                        Swal.fire(
                            'Gagal!',
                            'Data gagal dihapus.',
                            'error'
                        )
                    }
                });
            }
        })
    }
</script>
