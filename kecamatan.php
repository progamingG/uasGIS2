<?php include('template/header.php') ?>
<?php include('template/navbar.php') ?>
<?php include 'koneksi.php';
session_start();
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $poligon = $_POST['poligon'];
    $warna = $_POST['warna'];

    $queryResult = $conn->query("INSERT INTO kecamatan(nama,warna,poligon) VALUES('$nama','$warna','$poligon')");
    if ($queryResult) {
        $_SESSION['pesan'] = 'Data berhasil ditambahkan';
    }
}
?>
<div class="page-content p-5" id="content">
    <div class="data-pesan" data-pesan="<?php if (isset($_SESSION['pesan'])) {
                                            echo $_SESSION['pesan'];
                                        }
                                        unset($_SESSION['pesan']); ?>"></div>
    <button id="sidebarCollapse" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4"><i
            class="fa fa-bars mr-2"></i></button>
    <div class="row">
        <div class="col-lg-7">
            <div id="map" style="height: 800px; "></div>
        </div>
        <div class="col-lg-5">
            <form action="" method="POST">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Warna</label>
                    <div class="col-sm-8">
                        <input type="color" class="form-control" name="warna" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Koordinat Poligon</label>
                    <textarea name="poligon" id="poligon" rows="3" class="form-control"></textarea>
                </div>
                <button class="btn btn-info" type="submit" name="simpan">Simpan</button>
            </form>
        </div>
        <div class="col-lg-12 mt-2">
            <div class="card">
                <div class="card-header">Data kecamatan</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Rumah</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = $conn->query("SELECT * FROM kecamatan");
                            $no = 0;
                            if ($query->num_rows > 0) {
                                while ($row = $query->fetch_row()) {
                            ?>
                                    <tr>
                                        <td><?= $no += 1; ?></td>
                                        <td><?= $row[1]; ?></td>
                                        <td><a href="delete_kecamatan.php?id=<?= $row[0]; ?>" class="btn btn-danger btn-hapus-kecamatan">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var map = L.map('map').setView([-0.8365483562098096, 119.89375323356296], 13);
    let layerMap = L.tileLayer(
        'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibmF1ZmFsaGFtYmFsaTY1IiwiYSI6ImNtMnd4eWdlZDBidjYyanBwaHJnZ3FrbHAifQ.mJdw4Ew-5zOyObCXR8akhg', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v12',
        }).addTo(map);
    <?php
    $sql = "SELECT * FROM kecamatan";
    $hasil = $conn->query($sql);
    if ($hasil->num_rows > 0) {
        while ($row = $hasil->fetch_assoc()) { ?>
            var drawnItems = L.geoJson(<?= $row['poligon'] ?>, {
                color: "<?= $row['warna'] ?>"
            }).addTo(map);
    <?php }
    }
    ?>
    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);
    var drawControl = new L.Control.Draw({
        draw: {
            polyline: false,
            rectangle: false,
            circle: false,
            marker: false,
            circlemarker: false,
        },
        edit: {
            featureGroup: drawnItems
        }
    });
    map.addControl(drawControl);

    map.on('draw:created', function(event) {
        var layer = event.layer,
            feature = layer.feature = layer.feature || {};

        feature.type = feature.type || "Feature";
        var props = feature.properties = feature.properties || {};
        drawnItems.addLayer(layer);

        var hasil = $('#poligon').val(JSON.stringify(drawnItems.toGeoJSON()));
    });

    let pesan = $('.data-pesan').data('pesan');

    if (pesan) {
        Swal.fire({
            icon: 'success',
            title: pesan,
            showConfirmButton: false,
            timer: 1500
        })
    }


    $('.btn-hapus-kecamatan').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr("href");

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data kecamatan akan dihapus?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus data!'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
            }
        })
    });
</script>
<?php include('template/footer.php') ?>