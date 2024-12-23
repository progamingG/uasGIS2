<!-- header -->
<?php include('template/header.php') ?>
<!-- navbar -->
<?php include('template/navbar.php') ?>
<?php include('koneksi.php');
session_start();
if (isset($_POST['simpan'])) {
    $id = $_GET['id'];
    $nama = $_POST['nama'];
    $pemilik = $_POST['pemilik'];
    $alamat = $_POST['alamat'];
    $kecamatan = $_POST['kecamatan'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $query = $conn->query("UPDATE apotik SET nama='$nama', pemilik='$pemilik', alamat='$alamat', kecamatan='$kecamatan', latitude='$latitude', longitude='$longitude' WHERE id='$id'");

    if ($query) {
        $_SESSION['pesan'] = 'Data brhasil diubah';
        echo "<script>
        window.location.href = 'apotik.php';
        </script>";
    } else {
        echo "<script>alert('gagal diubah')</script>";
    }
}
?>
<!-- content -->
<div class="page-content p-5" id="content">
    <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4"><i
            class="fa fa-bars mr-2"></i></button>
    <div class="row">
        <div class="col-lg-12 mb-2">
            <div id="maps" style="height: 400px;"></div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Input Data
                </div>
                <div class="card-body">
                    <?php
                    $id = $_GET['id'];
                    $query = $conn->query("SELECT * FROM apotik WHERE id='$id'");
                    $latitude = '';
                    $longitude = '';
                    if ($query->num_rows > 0) {
                        $row = $query->fetch_row();

                        $latitude = $row[5];
                        $longitude = $row[6];
                    ?>
                        <form action="" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama" placeholder="Nama" value="<?= $row[1]; ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Pemilik</label>
                                    <input type="text" class="form-control" name="pemilik" placeholder="Pemilik" value="<?= $row[2]; ?>"
                                        required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputAddress">Alamat</label>
                                    <input type="text" class="form-control" name="alamat" placeholder="Masukkan alamat"
                                        value="<?= $row[3]; ?>" required>
                                </div>
                                <!-- <div class="form-row"> -->
                                <div class="form-group col-md-4">
                                    <label for="inputState">Kecamatan</label>
                                    <select id="inputState" class="form-control" name="kecamatan">
                                        <option selected><?= $row[4]; ?></option>
                                        <?php
                                        $kec = $conn->query("SELECT * FROM kecamatan");

                                        if ($kec->num_rows > 0) {
                                            while ($row = $kec->fetch_row()) {
                                        ?>
                                                <option><?= $row[1]; ?></option>
                                        <?php }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Latitude</label>
                                    <input type="text" class="form-control" id="latitude" name="latitude" value="<?= $latitude; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Longitude</label>
                                    <input type="text" class="form-control" id="longitude" name="longitude" value="<?= $longitude; ?>">
                                </div>
                                <!-- </div> -->
                            </div>
                            <button type="submit" name="simpan" class="btn btn-info">Simpan</button>
                        </form>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let latlang = [0, 0];
    if (latlang[0] == 0 && latlang[1] == 0) {
        latlang = [<?= $latitude ?>, <?= $longitude ?>];
    }
    let mymap = L.map('maps').setView([-0.8931699926701577, 119.8647374574928], 13);

    let layerMap = L.tileLayer(
        'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibmF1ZmFsaGFtYmFsaTY1IiwiYSI6ImNtMnd4eWdlZDBidjYyanBwaHJnZ3FrbHAifQ.mJdw4Ew-5zOyObCXR8akhg', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v12',
        });
    mymap.addLayer(layerMap);
    let marker = new L.marker(latlang, {
        draggable: 'true'
    });
    marker.on('dragend', function(event) {
        let position = marker.getLatLng();
        marker.setLatLng(position).update();
        $("#latitude").val(position.lat);
        $("#longitude").val(position.lng);
    });
    mymap.addLayer(marker);
</script>
<?php include('template/footer.php') ?>