<?php
    $conn = new mysqli("localhost", "root", "", "uas_gis2");

    if (!$conn) {
        echo 'koneksi gagal';
    }
?>