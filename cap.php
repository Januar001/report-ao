<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Kamera</title>
    <style>
        video {
            width: 100%;
            max-width: 400px;
            margin: auto;
            display: block;
        }
    </style>
</head>

<body>
    <h1>Akses Kamera</h1>
    <video id="videoElement" autoplay></video>

    <script>
        // Mengakses elemen video
        const video = document.getElementById('videoElement');

        // Mengecek apakah browser mendukung navigator.mediaDevices.getUserMedia
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            // Minta izin untuk menggunakan kamera
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(function(stream) {
                    // Menyetel stream ke objek video untuk menampilkan hasil dari kamera
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function(error) {
                    console.error('Gagal mengakses kamera: ', error);
                });
        } else {
            console.error('Browser tidak mendukung navigator.mediaDevices.getUserMedia.');
        }
    </script>
</body>

</html>