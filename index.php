<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REPORT AO</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        select,
        input[type="file"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Error message style */
        #location-error {
            color: red;
            display: none;
        }

        /* Image preview */
        #image-preview {
            margin-top: 10px;
            text-align: center;
            position: relative;
        }

        #image-preview img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .watermark {
            display: none;
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            color: black;
        }

        .hidden-preview {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>REPORT AO</h2>
        <form action="#" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_ao">Nama AO:</label>
                <input type="text" id="nama_ao" name="nama_ao" value="<?php echo htmlspecialchars($_GET['ao'] ?? ''); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="jenis_laporan">Jenis Laporan:</label>
                <select id="jenis_laporan" name="jenis_laporan" required>
                    <option value="">Pilih jenis laporan</option>
                    <option value="kunjungan">Kunjungan</option>
                    <option value="marketing">Marketing</option>
                    <option value="penagihan">Penagihan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="gambar">Upload Gambar:</label>
                <input type="file" id="gambar" name="gambar" accept="image/*" required capture onchange="previewImage()">
                <div id="image-preview" class="hidden-preview">
                    <img id="preview" src="#" alt="Preview">
                    <div id="watermark" class="watermark">
                        Latitude: <span id="latitude"></span>, Longitude: <span id="longitude"></span><br>Tanggal: <span id="date"></span>, Jam: <span id="time"></span>
                    </div>
                </div>
            </div>

            <!-- Menggunakan style="display: none;" sebagai alternatif untuk hidden -->
            <div class="form-group" style="display: none;">
                <label for="latlong">Latitude & Longitude:</label>
                <input type="text" id="latlong" name="latlong" readonly>
            </div>

            <input type="submit" value="Kirim">
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            getLocation();
        });

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                document.getElementById("location-error").style.display = "block";
            }
        }

        function showPosition(position) {
            var latlongInput = document.getElementById("latlong");
            latlongInput.value = position.coords.latitude + ", " + position.coords.longitude;

            document.getElementById("latitude").textContent = position.coords.latitude.toFixed(6);
            document.getElementById("longitude").textContent = position.coords.longitude.toFixed(6);

            var currentDateTime = new Date();

            // Format tanggal dd/mm/yyyy untuk kompatibilitas dengan Safari
            var date = ("0" + currentDateTime.getDate()).slice(-2) + "/" + ("0" + (currentDateTime.getMonth() + 1)).slice(-2) + "/" + currentDateTime.getFullYear();
            document.getElementById("date").textContent = date;

            // Format waktu 24 jam
            var time = ("0" + currentDateTime.getHours()).slice(-2) + ":" + ("0" + currentDateTime.getMinutes()).slice(-2);
            document.getElementById("time").textContent = time;
        }

        function showError(error) {
            var errorElement = document.getElementById("location-error");
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    errorElement.innerHTML = "Pengguna menolak permintaan untuk Geolocation.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorElement.innerHTML = "Informasi lokasi tidak tersedia.";
                    break;
                case error.TIMEOUT:
                    errorElement.innerHTML = "Waktu permintaan untuk mendapatkan lokasi pengguna habis.";
                    break;
                case error.UNKNOWN_ERROR:
                    errorElement.innerHTML = "Terjadi kesalahan yang tidak diketahui.";
                    break;
            }
            errorElement.style.display = "block";
        }

        function previewImage() {
            var preview = document.querySelector('#preview');
            var file = document.querySelector('input[type=file]').files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
                document.getElementById('watermark').style.display = 'block';
            }

            if (file) {
                reader.readAsDataURL(file);
                document.getElementById('image-preview').classList.remove('hidden-preview');
            } else {
                preview.src = "";
                document.getElementById('watermark').style.display = 'none';
                document.getElementById('image-preview').classList.add('hidden-preview');
            }
        }
    </script>
</body>

</html>