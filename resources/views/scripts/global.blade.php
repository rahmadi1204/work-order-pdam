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
    $('form').submit(function(e) {
        let text = $(this).attr('data-text');
        $('button[type=submit]').attr('disabled', true);
        $('button[type=submit]').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...');
        setTimeout(() => {
            $('button[type=submit]').attr('disabled', false);
            $('button[type=submit]').html(text);
        }, 5000);
    });
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
</script>
<script>
    function getKoordinate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Failed to get location");
            console.log('Failed to get location');
        }
    }

    function showPosition(position) {
        console.log(position);
        $('#latitude').val(position.coords.latitude);
        $('#longitude').val(position.coords.longitude);
    }

    function getGoogleMaps() {
        let latitude = $('#latitude').val();
        let longitude = $('#longitude').val();
        let url = `https://www.google.com/maps/search/?api=1&query=${latitude},${longitude}`;
        $('#google_maps').val(url);
        window.open(url, '_blank');
    }
</script>
<script>
    $(function() {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
    })
</script>
<script>
    $(function() {
        bsCustomFileInput.init();

        $('#datepicker').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            icons: {
                time: "far fa-clock",
                date: "far fa-calendar",
                up: "fas fa-arrow-up",
                down: "fas fa-arrow-down"
            }

        })
        $('#datepicker1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            icons: {
                time: "far fa-clock",
                date: "far fa-calendar",
                up: "fas fa-arrow-up",
                down: "fas fa-arrow-down"
            }

        })
        $('#datepicker2').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            icons: {
                time: "far fa-clock",
                date: "far fa-calendar",
                up: "fas fa-arrow-up",
                down: "fas fa-arrow-down"
            }

        })
        $('.telp').inputmask({
            mask: '(999) 9999-9999'
        });
        $('.hp').inputmask({
            mask: '9999-9999-99999'
        });
        $('.id-pelanggan').inputmask({
            mask: '99/99/99/9999'
        });
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {
            'placeholder': 'mm/dd/yyyy'
        })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });

        //Date range picker
        $('#reservation').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            }
        })
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                    'MMMM D, YYYY'))
            }
        )

        //Timepicker
        $('#timepicker').datetimepicker({
            format: 'LT'
        })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        })

        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

    })
</script>
<script>
    // setTimeout(function() {
    //     $('.alert-success').toggle(1000);
    //     $('.alert-info').toggle(1000);
    //     $('.alert-danger').toggle(1000);
    // }, 5000);
</script>
