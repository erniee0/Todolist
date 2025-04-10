<?php 
include 'koneksi.php';

// Ambil data dari form
$id = $_POST['id'] ?? '';
$nama_subtugas = $_POST['nama_subtugas'] ?? '';

// Ambil `task_id` dulu sebelum update
$result = mysqli_query($koneksi, "SELECT task_id FROM sub_task WHERE id = '$id'");
$row = mysqli_fetch_assoc($result);
$task_id = $row['task_id'] ?? '';

if (empty($id)) {
    echo "Error: Task ID tidak ditemukan!";
    exit();
}

// Update guyssss
$stmt = mysqli_prepare($koneksi, "UPDATE sub_task SET nama_subtugas = ? WHERE id = ?");
mysqli_stmt_bind_param($stmt, "si", $nama_subtugas, $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// balik ke sub_task.php dengan `task_id`
header("Location: sub_task.php?task_id=$task_id");
exit();

?>
