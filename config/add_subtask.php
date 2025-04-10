<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form dan lakukan sanitasi
    $task_id = mysqli_real_escape_string($koneksi, $_POST['task_id']);
    $nama_subtugas = mysqli_real_escape_string($koneksi, $_POST['nama_subtugas']);
    $prioritas = mysqli_real_escape_string($koneksi, $_POST['prioritas']);
    $deadline = mysqli_real_escape_string($koneksi, $_POST['deadline']);

    // Validasi input tidak boleh kosong
    if (empty($task_id) || empty($nama_subtugas) || empty($prioritas) || empty($deadline)) {
        echo "<script>
                alert('semua kolom harus diisi')
                
            </script>";
        exit();
    }

    // Query untuk menambahkan sub-task
    $query = "INSERT INTO sub_task (task_id, nama_subtugas, prioritas, deadline) 
              VALUES ('$task_id', '$nama_subtugas', '$prioritas', '$deadline')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: sub_task.php?task_id=" . $task_id);
        exit();
    } else {
        echo "Gagal menambahkan sub-task: " . mysqli_error($koneksi);
    }
}
?>
