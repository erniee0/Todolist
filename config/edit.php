<?php
include 'koneksi.php';

// UNTUK TASK UTAMA //
// ambil data dari form
$id = isset($_POST['id']) ? $_POST['id'] : '';
$tugas = isset($_POST['tugas']) ? $_POST['tugas'] : '';

// ubah data berdasarkan id
mysqli_query($koneksi, "update task set tugas='$tugas' where id='$id'");

// kembali lagi ke halaman utama
header("location:apl.php");


?>
