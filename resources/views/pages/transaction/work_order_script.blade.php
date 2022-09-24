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
                url: "{{ url()->current() }}" + '/get',
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
                    data: 'tgl_work_order',
                    name: 'tgl_work_order'
                },
                {
                    data: 'type_id',
                    name: 'type_id'
                },
                {
                    data: 'staff_id',
                    name: 'staff.nama'
                },
                {
                    data: 'client_id',
                    name: 'client.nama'
                },
                {
                    data: 'keterangan_work_order',
                    name: 'keterangan_work_order'
                },
                {
                    data: 'status_work_order',
                    name: 'status_work_order'
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
        $('input[name=type_id]').val('');
        $('input[name=name]').val('');
        $('input[name=client]').val('');
        $('input[name=date]').val(
            '{{ now()->startOfMonth()->format('Y-m-d') .' - ' .now()->endOfyear()->format('Y-m-d') }}');
        $('input[name=status]').val('all');
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
                    url: "{{ url('work-order') }}" + '/delete/' + id,
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
    // cancel data
    function cancelConfirm(id, kode) {
        console.log(id, kode);
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Membatalkan data " + kode + " ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('work-order') }}" + '/cancel/' + id,
                    type: "POST",
                    data: {
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        Swal.fire(
                            'Dibatalkan!',
                            'Data berhasil dibatalkan.',
                            'success'
                        )
                        datatable();
                    },
                    error: function(data) {
                        console.log(data);
                        Swal.fire(
                            'Gagal!',
                            'Data gagal dibatalkan.<br>' + data.message,
                            'error'
                        )
                    }
                });
            }
        })
    }
</script>
