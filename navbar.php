<?php
if (session_status() == PHP_SESSION_NONE) session_start();
$login = $_SESSION['username'] ?? null;
?>

<nav class="navbar bg-body-tertiary px-4">
  <a class="navbar-brand" href="index.php">
    <img src="images/foto1.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
    NyalaPol
  </a>
  <div>
    <?php if ($login): ?>
      Hi, <strong><?= htmlspecialchars($login) ?></strong>
      <a href="logout.php" class="btn btn-outline-danger btn-sm ms-3">Logout</a>
    <?php else: ?>
      <a href="login.php" class="btn btn-outline-primary btn-sm">Login</a>
      <a href="register.php" class="btn btn-primary btn-sm ms-2">Register</a>
    <?php endif; ?>
  </div>
</nav>
