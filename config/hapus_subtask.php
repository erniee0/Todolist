<?php
include 'koneksi.php';

if (isset($_GET['id']) && isset($_GET['task_id'])) {
    $id = $_GET['id'];
    $task_id = $_GET['task_id'];

    mysqli_query($koneksi, "DELETE FROM sub_task WHERE id=$id");

    header("Location: sub_task.php?task_id=" . $task_id);
    exit();
}
?>
