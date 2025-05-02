<?php
session_start();
$login = isset($_SESSION['username']) ? $_SESSION['username'] : null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard - NyalaPol</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .table-success { background-color: #d1e7dd; }
    .table-warning { background-color: #fff3cd; }
    .table-danger  { background-color: #f8d7da; }
  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5 text-center">
  <img src="images/foto1.png" class="img-thumbnail rounded-circle mb-4" style="max-height: 120px;" alt="Profile Picture">
  <h2 class="fw-bold">Halo semua! NyalaPol di sini!</h2>
  <h5 class="text-muted">NyaLaPol - Nyaman Belajar Pol</h5>
  <p>Dengan menggunakan NyaLaPol, kalian akan merasakan kemudahan dalam mengatur waktu belajar,
     dan yang tidak kalah penting, yaitu kalian akan merasa <b>Nyaman Pol</b>.
  </p>
</div>

<div class="container mt-4">
  <!-- FORM TAMBAH TARGET -->
  <div class="card mb-4">
    <div class="card-header">📝 Tambah Target Belajar</div>
    <div class="card-body">
      <form action="<?= $login ? 'proses.php' : '#' ?>" method="POST"
            onsubmit="return <?= $login ? 'true' : 'alertLogin()' ?>;">
        <div class="row g-2">
          <div class="col-md-3">
            <input type="text" name="judul" class="form-control" placeholder="Judul materi" required>
          </div>
          <div class="col-md-2">
            <input type="date" name="deadline" class="form-control" required>
          </div>
          <div class="col-md-2">
            <input type="text" name="kategori" class="form-control" placeholder="Kategori">
          </div>
          <div class="col-md-3">
            <input type="text" name="catatan" class="form-control" placeholder="Catatan">
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Tambahkan</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- DAFTAR TARGET BELAJAR -->
  <div class="card">
    <div class="card-header">📚 Daftar Target Belajar</div>
    <div class="card-body table-responsive">
      <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
          <tr>
            <th>Judul</th>
            <th>Deadline</th>
            <th>Status</th>
            <th>Kategori</th>
            <th>Catatan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $total = $selesai = 0;
          if ($login) {
            $file = "data/{$login}.txt";
            if (file_exists($file)) {
              $lines = file($file, FILE_IGNORE_NEW_LINES);
              foreach ($lines as $index => $line) {
                list($judul, $deadline, $status, $kategori, $catatan) = explode('|', $line);
                $total++;
                if ($status === 'sudah') $selesai++;

                $now = strtotime(date('Y-m-d'));
                $due = strtotime($deadline);
                $diff = ($due - $now) / (60 * 60 * 24);
                $rowClass = '';
                if ($status == 'sudah') $rowClass = 'table-success';
                else if ($due < $now) $rowClass = 'table-danger';
                else if ($diff <= 2) $rowClass = 'table-warning';

                echo "<tr class='$rowClass'>
                  <td>$judul</td>
                  <td>$deadline</td>
                  <td>$status</td>
                  <td>$kategori</td>
                  <td>$catatan</td>
                  <td>";
                if ($status == 'belum') {
                  echo "
                    <form action='update.php' method='POST' class='d-inline'>
                      <input type='hidden' name='index' value='$index'>
                      <button name='user' value='$login' class='btn btn-sm btn-success'>Selesai</button>
                    </form>
                    <form action='hapus.php' method='POST' class='d-inline'>
                      <input type='hidden' name='index' value='$index'>
                      <button name='user' value='$login' class='btn btn-sm btn-danger'>X</button>
                    </form>";
                } else {
                  echo "-";
                }
                echo "</td></tr>";
              }
            } else {
              echo "<tr><td colspan='6'>Belum ada target belajar.</td></tr>";
            }
          } else {
            echo "<tr><td colspan='6'>Silakan login untuk melihat data belajar Anda.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- STATISTIK -->
  <?php if ($login): ?>
    <div class="mt-4">
      <h5>📊 Progres Belajar: <?= $selesai ?> dari <?= $total ?> target selesai</h5>
      <div class="progress">
        <div class="progress-bar" style="width: <?= $total > 0 ? round(($selesai / $total) * 100) : 0 ?>%">
          <?= $total > 0 ? round(($selesai / $total) * 100) : 0 ?>%
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

<script>
  function alertLogin() {
    alert('Harap login terlebih dahulu.');
    return false;
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
