<?php

$berkasData = "assets/data/data.json"; // alamat file data.json
$dataJson = file_get_contents($berkasData); // mengambil object json dari file data.json ke dalam variabel
$dataArray = json_decode($dataJson, true); // mengubah object json ke dalam bentuk array php 

// membuat list bandara menggunakan array
$listBandara = array(
    "1001" =>  [ // kode bandara
        "nama" => "Soekarno-Hatta (CGK)", // nama bandara
        "pajak" => 50000 // pajak bandara
    ],
    "1002" =>  [
        "nama" => "Husein Sastranegara (BDO)",
        "pajak" => 30000
    ],
    "1003" =>  [
        "nama" => "Abdul Rachman Saleh (MLG)",
        "pajak" => 40000
    ],
    "1004" =>  [
        "nama" => "Juanda (SUB)",
        "pajak" => 40000
    ],
    "2005" =>  [
        "nama" => "Ngurah Rai (DPS)",
        "pajak" => 80000
    ],
    "2006" =>  [
        "nama" => "Hasanuddin (UPG)",
        "pajak" => 70000
    ],
    "2007" =>  [
        "nama" => "Inanwatan (INX)",
        "pajak" => 90000
    ],
    "2008" =>  [
        "nama" => "Sultan Iskandarmuda (BTJ)",
        "pajak" => 70000
    ]
);

// mengecek tombol submit sudah ditekan atau tidak
if (isset($_POST['submit'])) {
    
    // Memasukan hasil input form ke dalam variabel sesuai dengan nama
    $maskapai = $_POST['maskapai']; 
    $kodeBandaraAsal = $_POST['bandaraAsal'];
    $kodeBandaraTujuan = $_POST['bandaraTujuan'];
    $hargaTiket = intval($_POST['hargaTiket']);

    // Menghitung pajak bandara
    $pajakBandaraAsal = $listBandara[$kodeBandaraAsal]['pajak'];
    $pajakBandaraTujuan = $listBandara[$kodeBandaraTujuan]['pajak'];
    $totalPajak = $pajakBandaraAsal + $pajakBandaraTujuan;

    // Menghitung total harga tiket setelah ditambah dengan pajak
    $totalHargaTiket = $hargaTiket + $totalPajak;

    // Membuat array baru untuk memasukan semua data baru 
    $dataBaru = array(
        "maskapai" => $maskapai,
        "bandaraAsal" => $listBandara[$kodeBandaraAsal]['nama'],
        "bandaraTujuan" => $listBandara[$kodeBandaraTujuan]['nama'],
        "hargaTiket" => $hargaTiket,
        "pajak" => $totalPajak,
        "totalHargaTiket" => $totalHargaTiket,
    );

    // Menambahkan data baru ke dalam variabel $dataArray
    array_push($dataArray, $dataBaru);

    // Mengubah nilai variabel $dataArray ke dalam bentuk object Json
    $dataJson = json_encode($dataArray, JSON_PRETTY_PRINT);
    // Memasukan data json yang sudah diubah ke dalam file data.json
    file_put_contents($berkasData, $dataJson);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>penerbangan</title>
    <link rel="stylesheet" href="assets/library/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <main>
        <div>
            <article class="d-flex justify-content-center" id="home">
                <div style="color: var(--bs-white);">
                    <h1></h1>
                    <p></p>
                </div>
            </article>
            <div class="container-fluid card-container">
                <div class="row" style="margin-bottom: 100px;">
                    <div class="col-md-12 d-flex justify-content-center">
                        <div class="form-card card-style">
                            <section class="judul-text">
                                <h2>Pendaftaran Rute Penerbangan</h2>
                                <hr class="garis">
                            </section>
                            <section class="text-center">
                                <img src="assets/gambar/gambar.png" alt="pesawat">
                            </section>
                            <section>
                                <form method="POST">
                                    <div class="form-input"><label class="form-label">Maskapai :</label><input class="form-control" type="text" placeholder="Nama maskapai" name="maskapai" required="">
                                        <div class="form-input"><label class="form-label">Bandara Asal :</label><select name="bandaraAsal" class="form-select" required="">
                                                <optgroup label="Pilih bandara">
                                                    <option value="1001">Soekarno-Hatta (CGK)</option>
                                                    <option value="1002">Husein Sastranegara (BDO)</option>
                                                    <option value="1003">Abdul Rachman Saleh (MLG)</option>
                                                    <option value="1004">Juanda (SUB)</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="form-input"><label class="form-label">Bandara Tujuan :</label><select name="bandaraTujuan" class="form-select" required="">
                                                <optgroup label="Pilih Bandara">
                                                    <option value="2005">Ngurah Rai (DPS)</option>
                                                    <option value="2006">Hasanuddin (UPG)</option>
                                                    <option value="2007">Inanwatan (INX)</option>
                                                    <option value="2008">Sultan Iskandarmuda (BTJ)</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="form-input"><label class="form-label">Harga Tiket :</label><input class="form-control" type="number" placeholder="Harga tiket" name="hargaTiket" min="1" required="">
                                            <div class="form-submit text-center"><button class="btn button" name="submit" type="submit">Submit</button></div>
                                        </div>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="row table-row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <div class="table-card card-style">
                            <section class="judul-text">
                                <h2>Daftar Rute Tersedia</h2>
                                <hr class="garis">
                            </section>
                            <section>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="font-white">
                                            <tr class="text-nowrap text-truncate text-capitalize text-center">
                                                <th>Maskapai</th>
                                                <th>Asal Penerbangan</th>
                                                <th>Tujuan penerbangan</th>
                                                <th>Harga Tiket</th>
                                                <th>Pajak</th>
                                                <th>Total Harga tiket<br></th>
                                            </tr>
                                        </thead>
                                        <tbody class="font-white">
                                        <?php
                                            // Mengurutkan daftar rute penerbangan sesuai abjad dari nama maskapai
                                            usort($dataArray, fn($a, $b) => $a['maskapai'] <=> $b['maskapai']);

                                            // Melakukan pengulangan untuk semua nilai dalam array $dataArray
                                            for ($i=0; $i < count($dataArray); $i++) { 
                                        ?>
                                            <!-- Menampilkan setiap data dalam $dataArray ke dalam table -->
                                            <tr>
                                                <td><?=$dataArray[$i]['maskapai']?></td>
                                                <td><?=$dataArray[$i]['bandaraAsal']?></td>
                                                <td><?=$dataArray[$i]['bandaraTujuan']?></td>
                                                <td><?=$dataArray[$i]['hargaTiket']?></td>
                                                <td><?=$dataArray[$i]['pajak']?></td>
                                                <td><?=$dataArray[$i]['totalHargaTiket']?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="text-center">
        <hr>
        <p class="text-capitalize">© Copyleft - created by Ilham</p>
    </footer>
    <script src="assets/library/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>