<?php
session_start();
include 'config/koneksi.php';

// ngechek user udah login atau blm:)
if (!isset($_SESSION['id'])) {
    header("Location: config/login.html");
    exit();
}

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

// ini menghitung tugas yang masih aktif
$query_task = mysqli_query($koneksi, "SELECT COUNT(*) AS total_task FROM task");
$result_task = mysqli_fetch_assoc($query_task);
$total_task = $result_task['total_task'] ?? 0;

// history nya ada berapa
$query_history = mysqli_query($koneksi, "SELECT COUNT(*) AS total_history FROM history");
$result_history = mysqli_fetch_assoc($query_history);
$total_history = $result_history['total_history'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="config/style/pagestyle.css">

	<!--INDEX INI DASHBOARD-->
	<title>Dashboard</title>
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
				<a href="index.php">
					<i class='bx bxs-dashboard'></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="config/apl.php">
					<i class='bx bx-list-ul'></i>
					<span class="text">Task List</span>
				</a>
			</li>
			<li>
				<a href="config/history.php">
					<i class='bx bx-history'></i>
					<span class="text">History</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="config/logout.php" class="logout" onclick="confirmLogout(event);">
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
				<img src="config/img/user.png">
				<span><?= $username; ?></span>
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li><a href="#">Dashboard</a></li>
					</ul>
				</div>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-calendar-check'></i>
					<span class="text">
						<h3>List</h3>
						<p><strong><?= $total_task; ?></strong> tugas aktif</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-group'></i>
					<span class="text">
						<h3>History</h3>
						<p><strong><?= $total_history; ?></strong> tugas selesai</p>
					</span>
				</li>
			</ul>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
   <script src="config/script/script.js"></script>

</body>
</html>