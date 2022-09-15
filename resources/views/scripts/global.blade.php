<script>
    $('#btn-logout').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "{{ route('logout') }}",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
            }
        }).then(function() {
            window.location.href = "{{ route('login') }}";
        }).fail(function() {
            window.location.reload();
        });
    });
</script>
<script>
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
</script>
