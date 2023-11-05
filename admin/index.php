<?php
session_start();
include '../koneksi.php';

if (isset($_SESSION['belum_login'])) {
    echo '<script>';
    echo 'Swal.fire({';
    echo '    position: "center",';
    echo '    icon: "success",';
    echo '    title: "' . $_SESSION['belum_login'] . '",';
    echo '    showConfirmButton: false,';
    echo '    timer: 2000'; //Ini 2 detik
    echo '});';
    echo '</script>';
    unset($_SESSION['belum_login']); // Hapus pesan dari session
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_login'] = $user['id_admin'];
          $_SESSION['admin_last_activity'] = time(); // Setel waktu aktivitas terakhir

        header("Location: ../admin/dashboard/dashboard.php"); // Ubah ke halaman yang sesuai
        exit();
    } else {
        $_SESSION['error_message'] = 'Username/Password yang Anda masukkan salah.';
        header("Location: index.php");
        exit();
    }
}

?>


<!doctype html>
<html lang="en">
  <head>
  	<title>LOGIN SIMPANANQIU</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
	
	<link rel="stylesheet" href="../login/css/style.css">
    <!-- <style>
        body {
            background: url("https://images.unsplash.com/photo-1579621970588-a35d0e7ab9b6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80");
        }
    </style> -->

	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">LOGIN ADMIN</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img" style="background-image: url(https://images.unsplash.com/photo-1507679799987-c73779587ccf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2071&q=80);">
			      </div>
						<div class="login-wrap p-4 p-md-5">
			      	<div class="d-flex">
			      		<div class="w-100">
			      			<h3 class="mb-4">Selamat Datang!</h3>
			      		</div>
			      	</div>

<!-- Dibawah ini untuk hasil input dari register  -->
<?php
if (isset($_SESSION['success_message'])) {
    echo '<script>';
    echo 'Swal.fire({';
    echo '    position: "center",';
    echo '    icon: "success",';
    echo '    title: "' . $_SESSION['success_message'] . '",';
    echo '    showConfirmButton: false,';
    echo '    timer: 3000'; //Ini 2 detik
    echo '});';
    echo '</script>';
    unset($_SESSION['success_message']); // Hapus pesan dari session
}
?>

<!-- Untuk notifikasi logout -->
<?php
if (isset($_SESSION['logout_message'])) {
    echo '<script>';
    echo 'Swal.fire({';
    echo '    position: "center",';
    echo '    icon: "success",';
    echo '    title: "' . $_SESSION['logout_message'] . '",';
    echo '    showConfirmButton: false,';
    echo '    timer: 3000'; //Ini 2 detik
    echo '});';
    echo '</script>';
    unset($_SESSION['logout_message']); // Hapus pesan dari session
}
?>



<!-- Untuk Tampilkan ganti passoword berhasil -->
<?php
if (isset($_SESSION['authenticated_user'])) {
    echo '<script>';
    echo 'Swal.fire({';
    echo '    position: "center",';
    echo '    icon: "success",';
    echo '    title: "Berhasil ganti password. Silahkan login!",';
    echo '    showConfirmButton: false,';
    echo '    timer: 3000'; //Ini 3 Detik
    echo '});';
    echo '</script>';
    unset($_SESSION['authenticated_user']); // Hapus authenticated_user dari session
}
?>

<!-- Untuk Pemberitahuan kalo data pasword/akun salah -->
<?php
if (isset($_SESSION['error_message'])) {
    echo '<script>';
    echo 'Swal.fire({';
    echo '    position: "center",';
    echo '    icon: "error",';
    echo '    title: "' . $_SESSION['error_message'] . '",';
    echo '    showConfirmButton: false,';
    echo '    timer: 3000'; //Ini 3 detik
    echo '});';
    echo '</script>';
    unset($_SESSION['error_message']); // Hapus pesan dari session
}

?>

<!-- Kalo belom login, tidak bisa masuk dan berikan notifikasi -->
<?php
if (isset($_SESSION['no_login'])) {
    echo '<script>';
    echo 'Swal.fire({';
    echo '    position: "center",';
    echo '    icon: "error",';
    echo '    title: "' . $_SESSION['no_login'] . '",';
    echo '    showConfirmButton: false,';
    echo '    timer: 3000'; //Ini 3 detik
    echo '});';
    echo '</script>';
    unset($_SESSION['no_login']); // Hapus pesan dari session
}

?>

<!-- Kadaluarsa untuk login, jadi admin udah login tapi belom logout, dan terpaksa harus keluar dan berikan kondisi/notifikasi -->
<!-- Ada di file back_login.php -->
<?php
if (isset($_SESSION['login_session_out'])) {
    echo '<script>';
    echo 'Swal.fire({';
    echo '    position: "center",';
    echo '    icon: "error",';
    echo '    title: "' . $_SESSION['login_session_out'] . '",';
    echo '    showConfirmButton: false,';
    echo '    timer: 3000'; //Ini 3 detik
    echo '});';
    echo '</script>';
    unset($_SESSION['login_session_out']); // Hapus pesan dari session
}

?>


							<form action="" class="signin-form" method="post">
			      		<div class="form-group mb-3">
			      			 <label for="username">Username</label>
                                        <input type="text" class="form-control" name="username" id="username">
			      		</div>
		            <div class="form-group mb-3">
		            	<label for="password">Password</label>
                                        <input type="password" class="form-control" name="password" id="password">
		            </div>
					
		            <div class="form-group">
		            	<button type="submit" class="form-control btn btn-primary rounded submit px-3">Login</button>
					

						
		            </div>
		            <!-- <div class="form-group d-md-flex">
		            	 <div class="w-50 text-left">
			            	<label class="checkbox-wrap checkbox-primary mb-0">Remember Me
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
										</label>
									</div>
									<div class="w-50 text-md-right">
										<a href="#">Forgot Password</a>
									</div> 
		            </div> -->
		          </form>
		          <!-- <p class="text-center">Not a member? <a data-toggle="tab" href="#signup">Sign Up</a></p> -->
		        </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

  <script src="../login/js/jquery.min.js"></script>
  <script src="../login/js/popper.js"></script>
  <script src="../login/js/bootstrap.min.js"></script>
  <script src="../login/js/main.js"></script>

	</body>
</html>

