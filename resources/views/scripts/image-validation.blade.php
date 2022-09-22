<script>
    $("#imageFile").change(function(e) {
        e.preventDefault();
        let allowedExtensions = ['jpg', 'png', 'jpeg', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG'];
        sizeLimit = 5000000; // 50 megabyte

        // destructuring file name and size from file object
        let {
            name: fileName,
            size: fileSize
        } = this.files[0];

        /*
         * if filename is apple.png, we split the string to get ["apple","png"]
         * then apply the pop() method to return the file extension
         *
         */
        let fileExtension = fileName.split(".").pop();

        /*
          check if the extension of the uploaded file is included
          in our array of allowed file extensions
        */
        if (!allowedExtensions.includes(fileExtension)) {
            Swal.fire(
                'Gagal',
                'File Bukan Gambar!',
                'error'
            )
            this.value = null;
        } else if (fileSize > sizeLimit) {
            Swal.fire(
                'Gagal',
                'Ukuran Gambar terlalu Besar!',
                'error'
            )
            this.value = null;
        } else {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#img').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
