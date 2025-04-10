<?php
session_start();
include 'koneksi.php';

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
			<a href="config/logout.php" class="logout" onclick="confirmLogout(event);">
        			<i class='bx bxs-log-out-circle'></i>
        			<span class="text">Logout</span>
    			</a>
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
					<h1>To do list</h1>
					<p>Your Day, Your Way!</p>
				</div>
			</div>

			<!-- FORM ADD TASK -->
			<div class="content1">
				<div class="card1">
					<form action="todo.php" method="post">
						<input type="text" class="input-box" name="tugas" placeholder="Make your list">
						<div class="btn-add">
							<button type="submit">Add</button>
						</div>
					</form>
				</div>

				<!-- LIST TASK -->
				<div class="task-container">
					<?php
						include 'koneksi.php';

						$data = mysqli_query($koneksi, "SELECT * FROM task");
						while($d = mysqli_fetch_array($data)){
					?>
					<div class="card">
						<div class="task-item">
							<span class="teks-tugas">
								<?= htmlspecialchars($d['tugas']); ?>
							</span>
							<div class="task-actions">
								<a href="todoupdate.php?id=<?= $d['id']; ?>"><i class='bx bx-edit'></i></a>
								<a href="hapus.php?tugas=<?= urlencode($d['tugas']); ?>"
									onclick="return confirm('Are you sure?')">
									<i class='bx bxs-trash'></i>
								</a>
								<a href="sub_task.php?task_id=<?= $d['id']; ?>" class="view-subtask">
									<i class='bx bx-list-plus'></i>
								</a>
							</div>
						</div>
					</div>
					<?php
						}
					?>
				</div>
			</div>
		</div>

		<!-- JAVASCRIPT -->
		<script src="script/script.js"></script>
	</section>
</body>
</html>