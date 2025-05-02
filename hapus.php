<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $loginUser = $_SESSION['username'] ?? null;
  $user = $_POST['user'] ?? '';
  $index = isset($_POST['index']) ? (int)$_POST['index'] : -1;

  if ($loginUser && $user === $loginUser) {
    $file = "data/$user.txt";

    if (file_exists($file)) {
      $lines = file($file, FILE_IGNORE_NEW_LINES);
      if (isset($lines[$index])) {
        unset($lines[$index]);
        file_put_contents($file, implode(PHP_EOL, $lines));
      }
    }
  }
}

header("Location: index.php");
exit;
