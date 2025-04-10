<?php 
//============= PROSES BUAT NGE HAPUS TASK UTAMA ATAU LIST:) =============//

// koneksi database
include 'koneksi.php';
 
// menangkap data id yang di kirim dari url
$tugas = $_GET['tugas'];
 
 
// menghapus data dari database
mysqli_query($koneksi,"delete from task where tugas='$tugas'");
 
// mengalihkan halaman kembali ke index.php
header("location:apl.php");
 
?>