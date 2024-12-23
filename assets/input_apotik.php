<?php include('template/header.php') ?>
<?php include('template/navbar.php') ?>
<?php include 'koneksi.php';
session_start();
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $pemilik = $_POST['pemilik'];
    $alamat = $_POST['alamat'];
    $kecamatan = $_POST['kecamatan'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $query = $conn->query("INSERT INTO apotik(nama,pemilik,alamat,kecamatan,latitude,longitude) 
    VALUES('$nama','$pemilik','$alamat','$kecamatan','$latitude','$longitude')");

    if($query) {
        $_SESSION['pesan'] = 'Data berhasil ditambahkan';
        echo "<script>
        window.location.href = 'apotik.php';
        </script>";
    }
}
?>
<div class="page-content p-5" id="content">
    <button id="sidebarCollapse" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4"><i class="fa fa-bars mr-2"></i></button>
    <div class="row">
        <div class="col-lg-12 mb-12">
            <div id="map" style="height: 400px;"></div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Input data</div>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama" placeholder="Nama" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Pemilik</label>
                            <input type="text" class="form-control" name="pemilik" placeholder="Pemilik" required>
                        </div>
                    </div>
                    <div class="form-group">
                            <label for="inputAddress">Alamat</label>
                            <input type="text" class="form-control" name="alamat" placeholder="Alamat" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputState">Kecamatan</label>
                                <select name="kecamatan" id="inputState" class="form-control">
                                    <option selected>--Silahkan Pilih--</option>
                                    <?php
                                    $kec = $conn->query("SELECT * FROM kecamatan");

                                    if ($kec->num_rows > 0) {
                                        while ($row = $kec->fetch_row()) {
                                    ?>
                                        <option><?= $row[1]; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="form-control col-md-4">
                                <label>Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude">
                            </div>
                            <div class="form-control col-md-4">
                                <label>Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude">
                            </div>
                        </div>
                    <button class="btn btn-info" type="submit" name="simpan">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    let latlang = [0, 0];
    if (latlang[0] == 0 && latlang[1] == 0) {
        latlang = [-0.888027, 119.874639];
    }
    
    let mymap = L.map('map').setView([-0.8365483562098096, 119.89375323356296], 12);
    let layerMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    });
    mymap.addLayer(layerMap);

    let marker = new L.marker(latlang, {
        draggable: 'false'
    });

    marker.on('dragend', function(event) {
        let position = marker.getLatLng();
        marker.setLatLng(position).update();
        $('#latitude').val(position.lat);
        $('#longitude').val(position.lng);
    });

    mymap.addLayer(marker);
</script>
<?php include('template/footer.php') ?>