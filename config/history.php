<?php
session_start();
include 'koneksi.php';

// ambil semua sub-task yg udah selesai dari tabel history
$history_query = mysqli_query($koneksi, "SELECT h.*, t.tugas 
                                         FROM history h
                                         JOIN task t ON h.task_id = t.id
                                         ORDER BY h.deadline ASC");
// ambil data dari session 
$id = $_SESSION['id'];
$query_user = mysqli_query($koneksi, "SELECT username FROM user WHERE id = '$id'");

if (!$query_user) {
    die("Error saat mengambil data user: " . mysqli_error($koneksi));
}

$user = mysqli_fetch_assoc($query_user);

if (!$user) {
    echo "Error: User tidak ditemukan.";
    exit();
}
$username = htmlspecialchars($user['username']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="style/stylehal.css">

	<!-- INI BUAT LIST ATAU TUGAS UTAMA NYA -->

	<title>To Do List</title>
</head>

<body>

	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bx-task'></i>
			<span class="text">To Do List</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="../index.php">
					<i class='bx bxs-dashboard'></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="apl.php">
					<i class='bx bx-list-ul'></i>
					<span class="text">Task List</span>
				</a>
			</li>
			<li>
				<a href="history.php">
					<i class='bx bx-history'></i>
					<span class="text">History</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
			<a href="logout.php" class="logout" onclick="confirmLogout(event);">
        			<i class='bx bxs-log-out-circle'></i>
        			<span class="text">Logout</span>
    			</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->

	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu'></i>
			<a href="#" class="nav-link">Menu</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
				</div>
			</form>
			<a href="#" class="profile">
				<img src="img/user.png">
				<span><?= $username; ?></span>
			</a>
		</nav>
		<!-- END NAVBAR -->


    <div class="cont">
        <div class="header">
            <div class="detail">
                <h1>History Sub-Tasks</h1>
                <a href="../index.php">← Kembali ke Dashboard</a>
            </div>
        </div>

        <div class="content1">
            <?php while ($history = mysqli_fetch_array($history_query)) : ?>
                    <div class="task-item done">
                        <span>
                            <strong><?= $history['nama_subtugas']; ?></strong>  
                            <br>
                            <small>Tugas Utama: <?= $history['tugas']; ?></small>  
                            <br>
                            <small>Prioritas: <?= ucfirst($history['prioritas']); ?> | Deadline: <?= date("d-m-Y", strtotime($history['deadline'])) ?></small>
                        </span>
                    </div>
            <?php endwhile; ?>

            <?php if (mysqli_num_rows($history_query) == 0): ?>
                <p>Tidak ada sub-task yang selesai.</p>
            <?php endif; ?>
        </div>
    </div>
	<script src="script/script.js"></script>
</body>
</html>
