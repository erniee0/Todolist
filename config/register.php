<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah username atau email sudah terdaftar
    $cek_query = "SELECT * FROM user WHERE username = '$username' OR email = '$email'";
    $cek_result = mysqli_query($koneksi, $cek_query);

    if (mysqli_num_rows($cek_result) > 0) {
        echo "<script>
                alert('username atau email sudah digunakan');
                window.location.href = 'regitrasi.html';
            </script>";
    } else {
        $query = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";
        if (mysqli_query($koneksi, $query)) {
            header("Location: login.html");
            exit();
        } else {
            echo "<script>
                alert('Gagal mendaftar'); 
                </script>";  mysqli_error($koneksi);
        }
    }
}
?>
