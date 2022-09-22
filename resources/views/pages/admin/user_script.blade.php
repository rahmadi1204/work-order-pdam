<script>
    function datatable() {
        $('#datatable').DataTable().destroy();
        $('#datatable').DataTable({
            scrollY: '50vh',
            searching: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('user.get') }}",
                data: function(d) {
                    d.role = $('input[name=role]').val();
                    d.name = $('input[name=name]').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'last_seen',
                    name: 'last_seen'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
            order: [
                [1, 'asc']
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
        $('input[name=role]').val('');
        $('input[name=name]').val('');
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
                    url: "{{ url('/admin/users') }}" + '/delete/' + id,
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
