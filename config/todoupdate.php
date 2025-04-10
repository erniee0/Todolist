<!DOCTYPE html>
<html lang="en">
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

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    
    <!--====== STYLE ======-->
    <link rel="stylesheet" href="style/stylehal.css">

    <!-- ========= BUAT UPDATE TASK UTAMA/LIST ========= -->

    <title>Update Todo</title>
</head>
<body> 
     <!--======= PHP ======-->
     <?php
        include 'koneksi.php';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $data = mysqli_query($koneksi, "SELECT * FROM task WHERE id='$id'");
            $d = mysqli_fetch_array($data);

            if (!$d) {
                echo "Data tidak ditemukan!";
                exit;
            }
        } else {
            echo "ID tidak ditemukan!";
            exit;
        }
        ?>

	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="index.php" class="brand">
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
                    <div id="progres-bar">
                    <a href="apl.php">← Kembali ke Task</a>
                        <div id="progres"></div>
                    </div>
                </div>
            </div>

            <div class="content1">
                <form action="edit.php" method="post">
                        
                    <!--====== ID TERSEMBUNYI! ======-->
                    <input type="hidden" name="id" value="<?php echo $d['id']; ?>">

                    <!--====== buat update tugasnya =======-->
                    <input type="text" class="input-box" name="tugas" placeholder="Write your task"
                        value="<?php echo $d['tugas']; ?>" required>

                    <div class="btn-add">
                        <button type="submit">Save</button>
                    </div>
                </form>   
            </div>
        </div>
		<script src="script/script.js"></script>
</body>
</html>