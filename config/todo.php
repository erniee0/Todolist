<?php 
// Koneksi database
session_start(); // Mulai session
include 'koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['id']; // Ambil user_id dari session
$tugas = isset($_POST['tugas']) ? $_POST['tugas'] : '';
$status = "belum selesai";
$prioritas = "sedang";
$tanggal = date('Y-m-d'); 

// Perbaiki query dengan menambahkan user_id
$query = "INSERT INTO task (tugas, user_id) 
          VALUES ('$tugas', '$user_id')";

// Eksekusi query
if (mysqli_query($koneksi, $query)) {
    header("Location: apl.php"); 
} else {
    echo "Error: " . mysqli_error($koneksi); 
}
