<?php
include('template/header.php')
?>
<?php
include('template/navbar.php')
?>
<?php include 'koneksi.php' ?>

<div class="page-content p-5" id="content">
    <button class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4" id="sidebarCollapse" type="button">
        <i class="fa fa-bars mr-2"></i>
    </button>
    <div class="row">
        <div class="col-lg-10">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Lokasi Awal</label>
                    <select id="lokasi_awal" class="form-control">
                        <option selected>--Silahkan Pilih--</option>
                        <?php
                        include 'koneksi.php';
                        $kec = $conn->query("SELECT * FROM apotik");
                        if ($kec->num_rows > 0) {
                            while ($row = $kec->fetch_assoc()) {
                        ?>
                                <option value="<?= $row['latitude']; ?>, <?= $row['longitude']; ?>"><?= $row['nama']; ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Lokasi tujuan</label>
                    <select id="lokasi_tujuan" class="form-control">
                        <option selected>--Silahkan Pilih--</option>
                        <?php
                        include 'koneksi.php';
                        $kec = $conn->query("SELECT * FROM apotik");
                        if ($kec->num_rows > 0) {
                            while ($row = $kec->fetch_assoc()) {
                        ?>
                                <option value="<?= $row['latitude']; ?>, <?= $row['longitude']; ?>"><?= $row['nama']; ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <button class="btn btn-danger" style="margin-top: 32px" id="rute">Rute</button>
        </div>
        <div class="col">
            <div id="map" class=""></div>
        </div>
    </div>
</div>
<script>
    let map = L.map('map').setView([-0.893, 119.865], 12);
    let layerMap = L.tileLayer(
        'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibmF1ZmFsaGFtYmFsaTY1IiwiYSI6ImNtMnd4eWdlZDBidjYyanBwaHJnZ3FrbHAifQ.mJdw4Ew-5zOyObCXR8akhg', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v12',
        });
    map.addLayer(layerMap);
    let markers = [];
    let icons = L.icon({
        iconUrl: "img/home.png",
        iconSize: [50, 50],
        iconAnchor: [10, 10],
        popupAnchor: [0, -10],
    })
    <?php
    include 'koneksi.php';
    $sql = "SELECT * FROM apotik";
    $hasil = $conn->query($sql);
    if ($hasil->num_rows > 0) {
        while ($row = $hasil->fetch_row()) { ?>
            markers.push({
                active: true,
                name: "<?= $row[1] ?>",
                layer: L.marker([<?= $row[5] ?>, <?= $row[6] ?>], {
                    icon: icons
                }).bindPopup('Nama : <?= $row[1] ?> <br> NIM : <?= $row[2] ?> <br>' +
                    "<a href='detail_apotik.php?id=<?= $row[0] ?>' class='btn btn-outline-info btn-sm'>Detail</a>").addTo(map)
            });
    <?php }
    }
    ?>
    <?php
    $sql = "SELECT * FROM kecamatan";
    $hasil = $conn->query($sql);
    if ($hasil->num_rows > 0) {
        while ($row = $hasil->fetch_assoc()) { ?>
            var drawnItems = L.geoJson(<?= $row['poligon'] ?>, {
                color: "<?= $row['warna'] ?>"
            }).addTo(map);
            drawnItems.bindTooltip("<?= $row['nama'] ?>", {
                // permanent: false, // Label selalu terlihat
                direction: "center", // Label ditampilkan di tengah
                className: "polygon-label" // Tambahkan kelas CSS untuk styling
            }).openTooltip();
    <?php }
    }
    ?>
    // Fungsi untuk suara

    $('#rute').on('click', function() {
        let awal = $('#lokasi_awal').val();
        let awalLatLng = awal.split(',')
        let tujuan = $('#lokasi_tujuan').val();
        let tujuanLatLng = tujuan.split(',')
        if (!awal || !tujuan) {
            playVoice("Silakan pilih lokasi awal dan tujuan terlebih dahulu.");
            return;
        }


        let control = L.Routing.control({
            waypoints: [
                L.latLng(awalLatLng[0], awalLatLng[1]),
                L.latLng(tujuanLatLng[0], tujuanLatLng[1])
            ],
            routeWhileDragging: false
        }).addTo(map);
        control.on('routesfound', function(e) {
            const routes = e.routes;
            const instructions = [];

            // Mengambil petunjuk dari rute
            routes[0].instructions.forEach((instruction, index) => {
                // Terjemahkan ke Bahasa Indonesia
                let translatedInstruction;
                switch (instruction.type) {
                    case 'Straight':
                        translatedInstruction = `Lurus ke ${instruction.direction} sejauh ${instruction.distance} meter.`;
                        break;
                    case 'Left':
                        translatedInstruction = `Belok kiri sejauh ${instruction.distance} meter.`;
                        break;
                    case 'Right':
                        translatedInstruction = `Belok kanan sejauh ${instruction.distance} meter.`;
                        break;
                    case 'DestinationReached':
                        translatedInstruction = "Anda telah tiba di tujuan Anda.";
                        break;
                    default:
                        translatedInstruction = instruction.text; // Default jika tidak dikenali
                }
                instructions.push(translatedInstruction);
            });

            // Putar suara untuk setiap instruksi
            instructions.forEach(instruction => playVoice(instruction));
        });

        function playVoice(message) {
            console.log(message)
            const utterance = new SpeechSynthesisUtterance(message);
            utterance.lang = 'id-ID'; // Bahasa Indonesia
            window.speechSynthesis.speak(utterance);
        }
        // Notifikasi suara

    })
    let baseLayers = [{
        group: "tipe maps",
        layers: [{
                // name : "mapbox/streets-v11",
                name: "light",
                layer: L.tileLayer(
                    'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibmF1ZmFsaGFtYmFsaTY1IiwiYSI6ImNtMnd4eWdlZDBidjYyanBwaHJnZ3FrbHAifQ.mJdw4Ew-5zOyObCXR8akhg', {
                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                            'Imagery <a href="https://www.mapbox.com/">Mapbox</a>',
                        id: 'mapbox/light-v10',
                    }
                )
            },
            {
                name: "street",
                layer: layerMap
            },
            {
                name: "dark",
                layer: L.tileLayer(
                    'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibmF1ZmFsaGFtYmFsaTY1IiwiYSI6ImNtMnd4eWdlZDBidjYyanBwaHJnZ3FrbHAifQ.mJdw4Ew-5zOyObCXR8akhg', {
                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                            'Imagery <a href="https://www.mapbox.com/">Mapbox</a>',
                        id: 'mapbox/dark-v10',
                    }
                )
            },
        ]

    }]




    let overLayer = [{
        group: "marker apotik",
        layers: markers
    }]

    let panelLayers = new L.control.panelLayers(baseLayers, overLayer)

    map.addControl(panelLayers);
    // console.log(markers)
</script>
<?php include('template/footer.php') ?>