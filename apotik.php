<?php include('template/header.php') ?>
<?php include('template/navbar.php') ?>
<?php
session_start();
?>

<div class="page-content p-5" id="content">
  <div class="data-pesan" data-pesan="<?php if (isset($_SESSION['pesan'])) {
                                            echo $_SESSION['pesan'];
                                        }
                                        unset($_SESSION['pesan']); ?>"></div>
  <button id="sidebarCollapse" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4"><i
      class="fa fa-bars mr-2"></i></button>
  <div class="row">
    <div class="col-lg-12 mr-2">
      <a href="input_apotik.php" class="btn btn-info">Tambah</a>
    </div>
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">Data Apotik</div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Nim</th>
                <th scope="col">Lokasi</th>
                <th scope="col">Fakultas</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                            include 'koneksi.php';
                            $query = $conn->query("SELECT * FROM apotik");
                            $no = 0;
                            if ($query->num_rows > 0) {
                                while ($row = $query->fetch_row()) {
                            ?>
              <tr>
                <td><?= $no += 1; ?></td>
                <td><?= $row[1]; ?></td>
                <td><?= $row[2]; ?></td>
                <td><?= $row[3]; ?></td>
                <td><?= $row[4]; ?></td>
                <td>
                  <a href="edit_apotik.php?id=<?= $row[0]; ?>" class="btn btn-info"><i
                      class="fa fa-pencil-square-o"></i></a>
                  <a href="delete_apotik.php?id=<?= $row[0]; ?>" class="btn btn-danger btn-hapus-apotik"><i
                      class="fa fa-trash"></i></a>
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
let pesan = $('.data-pesan').data('pesan');

if (pesan) {
  Swal.fire({
    icon: 'success',
    title: pesan,
    showConfirmButton: false,
    timer: 1500
  })
}

$('.btn-hapus-apotik').on('click', function(e) {
  e.preventDefault();
  const href = $(this).attr("href");

  Swal.fire({
    title: 'Apakah anda yakin?',
    text: "Data apotik akan dihapus?",
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