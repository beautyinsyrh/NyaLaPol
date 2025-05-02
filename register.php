<?php
session_start();
$err = $sukses = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $users = file('users.txt', FILE_IGNORE_NEW_LINES);
  $exists = false;

  foreach ($users as $user) {
    list($u, ) = explode('|', $user);
    if ($u === $username) {
      $exists = true;
      break;
    }
  }

  if ($exists) {
    $err = 'Username sudah digunakan.';
  } else {
    file_put_contents('users.txt', "$username|$password" . PHP_EOL, FILE_APPEND);
    mkdir('data', 0777, true);
    touch("data/$username.txt");
    $sukses = 'Registrasi berhasil. Silakan login.';
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register - NyalaPol</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include 'navbar.php'; ?>
  <div class="container mt-5">
    <h3>Registrasi</h3>
    <?php if ($err): ?>
      <div class="alert alert-danger"><?= $err ?></div>
    <?php endif; ?>
    <?php if ($sukses): ?>
      <div class="alert alert-success"><?= $sukses ?></div>
    <?php endif; ?>
    <form method="POST">
      <div class="mb-3">
        <label>Username</label>
        <input name="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button class="btn btn-primary">Register</button>
    </form>
  </div>
</body>
</html>
