<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" href="css/materialize.css">
<link rel="stylesheet" href="css/responsive.css">
<style>
   .cont {
      padding: 50px;
      width: 40%;
      margin: 0 auto;
      margin-top: 10%;
      background-color: rgba(50, 50, 50, 0.1); /* Nilai alpha (0.7) menentukan tingkat transparansi */
      border-radius: 10px; /* Untuk membuat sudut kotak */
   }
	    /* Tambahkan media queries untuk ukuran layar tertentu */
    @media screen and (max-width: 768px) {
        .cont {
            width: 90%; /* Atur lebar yang berbeda untuk layar yang lebih kecil */
        }
	}
</style>
<body style="background: url(img/bgweb.jpg); background-size: cover;">
<div class="cont">
<h3 style="text-align: center;" class="blue-text">Menu Login</h3>
<br><center><p>Dikembangkan oleh <a href='https://bit.ly/mpkbegarlist' title='MPK SMAN 2 Magelang' target='_blank'>MPK SMAN 2 Magelang</a></p></center>

	<form method="POST">
		<div class="input_field">
			<label for="username">Username</label>
			<input id="username" type="text" name="username" required>
		</div>
		<div class="input_field">
			<label for="password">Password</label>
			<input id="password" type="password" name="password" required>
		</div>
		<input type="submit" name="login" value="Login" class="btn blue" style="width: 100%;">
	</form>
	<center><p>Belum punya akun? <a href=signup.php >Daftar Disini</a></p></center>
</div>
<?php 
	$servername = "localhost";
	$username = "root"; // Ganti dengan username database Anda
	$password = ""; // Ganti dengan password database Anda
	$dbname = "aspirasiku";
	
	// Membuat koneksi
	$koneksi = new mysqli($servername, $username, $password, $dbname);
	
	// Memeriksa koneksi
	if ($koneksi->connect_error) {
		die("Koneksi gagal: " . $koneksi->connect_error);
	}
	if(isset($_POST['login'])){
		$username = mysqli_real_escape_string($koneksi,$_POST['username']);
		$password = mysqli_real_escape_string($koneksi,md5($_POST['password']));
	
		$sql = mysqli_query($koneksi,"SELECT * FROM siswa WHERE username='$username' AND password='$password' ");
		$cek = mysqli_num_rows($sql);
		$data = mysqli_fetch_assoc($sql);
	
		$sql2 = mysqli_query($koneksi,"SELECT * FROM petugas WHERE username='$username' AND password='$password' ");
		$cek2 = mysqli_num_rows($sql2);
		$data2 = mysqli_fetch_assoc($sql2);

		if($cek>0){
			session_start();
			$_SESSION['username']=$username;
			$_SESSION['data']=$data;
			$_SESSION['level']='siswa';
			header('location:siswa/');
		}
		elseif($cek2>0){
			if($data2['level']=="admin"){
				session_start();
				$_SESSION['username']=$username;
				$_SESSION['data']=$data2;
				header('location:admin/');
			}
			elseif($data2['level']=="petugas"){
				session_start();
				$_SESSION['username']=$username;
				$_SESSION['data']=$data2;
				header('location:petugas/');
			}
			else if($data2['level']=="kurikulum"){
				session_start();
				$_SESSION['username']=$username;
				$_SESSION['data']=$data2;
				header('location:kurikulum/');
			}
			else if($data2['level']=="kesiswaan"){
				session_start();
				$_SESSION['username']=$username;
				$_SESSION['data']=$data2;
				header('location:kesiswaan/');
			}
			else if($data2['level']=="sarpra"){
				session_start();
				$_SESSION['username']=$username;
				$_SESSION['data']=$data2;
				header('location:sarpra/');
			}
			else if($data2['level']=="humas"){
				session_start();
				$_SESSION['username']=$username;
				$_SESSION['data']=$data2;
				header('location:humas/');
			}
		}
		else{
			echo "<script>alert('Gagal Login, Silahkan Coba Lagi')</script>";
		}

	}
?>
</body>