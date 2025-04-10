<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];
$data = mysqli_query($koneksi, "SELECT * FROM task WHERE user_id='$user_id'");

while ($d = mysqli_fetch_array($data)) {
    echo "<p>{$d['tugas']} - {$d['status']}</p>";
}
?>
