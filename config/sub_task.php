<?php
session_start();
include 'koneksi.php';

// ngemastiin task_id dikirim lewat URL
if (!isset($_GET['task_id'])) {
    echo "Task ID tidak ditemukan!";
    exit();
}

$task_id = $_GET['task_id'];

// beliau ngambil informasi dari tugas utama atau list
$task_query = mysqli_query($koneksi, "SELECT * FROM task WHERE id = $task_id");
$task = mysqli_fetch_assoc($task_query);

// Ambil daftar sub-task terkait
$sub_task_query = mysqli_query($koneksi, "SELECT * FROM sub_task WHERE task_id = $task_id");

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
                <h1>Sub Tasks</h1>
                <p>Task: <strong><?= $task['tugas']; ?></strong></p>
                <a href="apl.php">← Kembali ke Task</a>
            </div>
        </div>

        <div class="content1">
            <div class="card1">
                <form action="add_subtask.php" method="post">
                    <input type="hidden" name="task_id" value="<?= $task_id; ?>">
                    <input type="text" class="input-box" name="nama_subtugas" placeholder="Tambahkan sub-task" required>
                    <div class="input-group">
                    <select name="prioritas" class="prioritas">
                        <option value="tinggi">Tinggi</option>
                        <option value="sedang">Sedang</option>
                        <option value="rendah">Rendah</option>
                    </select>

                    <input type="date" name="deadline">
                    </div>

                    <div class="btn-add">
                        <button type="submit">Tambah</button>
                    </div>
                </form>
            </div>

            <!-- SUB-TASKS -->
            <?php while ($sub_task = mysqli_fetch_array($sub_task_query)) : ?>
                <div class="card">
                    <div class="task-item <?= $sub_task['status'] == 'selesai' ? 'done' : '' ?>">
                        <!-- Checkbox -->
                        <input type="checkbox" class="chek"
                            onclick="window.location.href='update_status.php?id=<?= $sub_task['id'] ?>&task_id=<?= $task_id ?>'"
                            <?= $sub_task['status'] == 'selesai' ? 'checked' : '' ?>>  
                        
                        <!-- Nama Sub-task -->
                        <span class="teks-tugas">
                            <?= $sub_task['nama_subtugas']; ?>
                        </span> 

                        <!-- Prioritas n Deadline -->
                        <?php
                        $priority_color = "";
                        if ($sub_task['prioritas'] == 'tinggi') {
                            $priority_color = "color: red; font-weight: bold;";
                        } elseif ($sub_task['prioritas'] == 'sedang') {
                            $priority_color = "color: orange;";
                        } elseif ($sub_task['prioritas'] == 'rendah') {
                            $priority_color = "color: green;";
                        }

                        $deadline_date = strtotime($sub_task['deadline']);
                        $today = strtotime(date("Y-m-d"));
                        $deadline_style = ($deadline_date < $today) ? "color: red; font-weight: bold;" : "";
                        ?>
                    
                        <small class="item2" style="<?= $priority_color; ?>">Prioritas: <?= ucfirst($sub_task['prioritas']); ?></small>
                        <small class="item2" style="<?= $deadline_style; ?>">(Deadline: <?= date("d-m-Y", $deadline_date) ?>)</small>
        
                        <!-- Edit, Hapus-->
                        <a href="editsubtask.php?id=<?= $sub_task['id']; ?>">
                            <i class='bx bx-edit'></i>
                        </a>
                        <a href="hapus_subtask.php?id=<?= $sub_task['id']; ?>&task_id=<?= $task_id; ?>" 
                            onclick="return confirm('Hapus sub-task ini?')">
                            <i class='bx bxs-trash'></i>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>

        </div>
    </div>

    <script src="script/script.js"></script>
</body>
</html>
