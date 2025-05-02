<?php
session_start();
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $users = file('users.txt', FILE_IGNORE_NEW_LINES);

  foreach ($users as $user) {
    list($u, $p) = explode('|', $user);
    if ($u === $username && $p === $password) {
      $_SESSION['username'] = $username;
      header('Location: index.php');
      exit;
    }
  }
  $err = 'Username atau password salah!';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - NyalaPol</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include 'navbar.php'; ?>
  <div class="container mt-5">
    <h3>Login</h3>
    <?php if ($err): ?>
      <div class="alert alert-danger"><?= $err ?></div>
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
      <button class="btn btn-primary">Login</button>
    </form>
  </div>
</body>
</html>
