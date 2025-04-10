<?php
include 'koneksi.php';

//untuk update status pada sub task

// Cek apakah parameter ID dikirim
if (isset($_GET['id']) && isset($_GET['task_id'])) {
    $id = $_GET['id'];
    $task_id = $_GET['task_id'];

    // Ambil data dari tabel sub_task yang akan dipindahkan
    $query_get = "SELECT * FROM sub_task WHERE id = $id";
    $result_get = mysqli_query($koneksi, $query_get);
    $sub_task = mysqli_fetch_assoc($result_get);

    if ($sub_task) {
        // Masukkan data ke dalam tabel history_sub_task
        $query_insert = "INSERT INTO history (task_id, nama_subtugas, status, prioritas, deadline) 
        VALUES ('{$sub_task['task_id']}', '{$sub_task['nama_subtugas']}', 'selesai', '{$sub_task['prioritas']}', '{$sub_task['deadline']}')";
        mysqli_query($koneksi, $query_insert);

        // Hapus data dari tabel sub_task dan ini akan pindah ke history
        $query_delete = "DELETE FROM sub_task WHERE id = $id";
        mysqli_query($koneksi, $query_delete);

        // Redirect kembali ke halaman sub_task.php
        header("Location: sub_task.php?task_id=$task_id");
        exit();
    }
}
?>
