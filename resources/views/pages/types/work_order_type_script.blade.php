<script>
    function datatable() {
        $('#datatable').DataTable().destroy();
        $('#datatable').DataTable({
            scrollY: '50vh',
            searching: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('type.work-order.get') }}",
                data: function(d) {
                    d.kode_work_order = $('input[name=kode_work_order]').val();
                    d.jenis_work_order = $('input[name=jenis_work_order]').val();
                    d.responder = $('input[name=responder]').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'kode_work_order',
                    name: 'kode_work_order'
                },
                {
                    data: 'jenis_work_order',
                    name: 'jenis_work_order'
                },
                {
                    data: 'pts',
                    name: 'pts'
                },
                {
                    data: 'responder',
                    name: 'responder'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
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
    $('.search').click(function(e) {
        e.preventDefault();
        datatable();
    });
    $('.refresh').click(function(e) {
        e.preventDefault();
        $('input[name=kode_work_order]').val('');
        $('input[name=jenis_work_order]').val('');
        $('input[name=responder]').val('');
        datatable();
    });
    $('#reservation').blur(function(e) {
        e.preventDefault();
        datatable();
    });

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
                    url: "{{ url('types/work-order') }}" + '/delete/' + id,
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
