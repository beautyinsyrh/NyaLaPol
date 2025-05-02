<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = $_SESSION['username'];
  $judul = trim($_POST['judul']);
  $deadline = $_POST['deadline'];
  $kategori = trim($_POST['kategori']);
  $catatan = trim($_POST['catatan']);
  $status = 'belum';

  $data = "$judul|$deadline|$status|$kategori|$catatan";
  file_put_contents("data/$user.txt", $data . PHP_EOL, FILE_APPEND);
}

header("Location: index.php");
exit;
