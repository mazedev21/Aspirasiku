<!DOCTYPE html>
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
   } /* css untuk tabel pendaftaran */
   .notification {
    display: none;
    position: fixed;
    top: 50px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #4CAF50;
    color: white;
    padding: 15px;
    border-radius: 5px;
    z-index: 9999;
} /*css untuk notifikasi*/
.loading {
    display: none;
    position: absolute;
    top: 50px; /* Atur sesuai dengan posisi notifikasi */
    left: 50%;
    transform: translateX(-50%);
} /*css untuk ikon loading*/

.loading img {
    width: 50px; /* Sesuaikan ukuran ikon loading */
}
#togglePassword{
    position: absolute; /* Mengatur posisi tombol */
    top: 74%; /* Mengatur posisi vertikal ke tengah */
    right: 50px; /* Mengatur posisi horizontal ke pojok kanan */
    transform: translateY(0%); /* Menggeser tombol ke atas setengah tinggi */
    background-color: transparent;
    border: none;
    cursor: pointer;
    font-size : 10px;
    display : flex;
    justify-content : center;
}
</style>
<script>
    function showNotification(message) {
    var notification = document.getElementById('notification');
    var loading = document.getElementById('loading');
    notification.innerText = message;
    notification.style.display = 'block';
    loading.style.display = 'block';
    setTimeout(function() {
        notification.style.display = 'none';
        loading.style.display = 'none';
    }, 2000); // Kotak notifikasi akan hilang setelah 3 detik
    } // Script JS untuk notifikasi pendaftaran berhasil
</script>
<body style="background: url(img/bgweb.jpg); background-size: cover;">
<html>
<div id="notification" class="notification"></div>
<div id="loading" class="loading">
    <img src="img/loading.gif" alt="Tunggu Sebentar...">
</div>
<div class="cont">
<h3 style="text-align: center;" class="blue-text">Daftar Akun</h3>
<br><center><p>Dikembangkan oleh <a href='https://bit.ly/mpkbegarlist' title='MPK SMAN 2 Magelang' target='_blank'>MPK SMAN 2 Magelang</a></p></center>
	<form method="POST">
		<div class="input_field">
			<label for="username">Username</label>
			<input id="username" type="text" name="username" required>
		</div>
        <div class="input_field">
			<label for="email">Email</label>
			<input id="email" type="text" name="email" required>
		</div>
        <div class="input_field">
            <label for="nama">Nama Lengkap</label>
            <input id="nama" type="text" name="nama" required>
        </div>
        <div class="input_field">
            <label for="nis">Nomor Induk Siswa (NIS)</label>
            <input id="nis" type="number" name="nis" required>
        </div>
		<div class="input_field">
			<label for="password">Password</label>
			<input id="password" type="password" name="password" required >
            <button type="button" id="togglePassword" class="btn blue" style="width: 15%;">Lihat</button>
		</div>
		<input type="submit" name="daftar" value="daftar" class="btn blue" style="width: 100%;">
	</form>
    <center><p>Kembali ke Halaman <a href=login.php>Login</a></p></center>
</div>
</html>

<?php
// Periksa apakah data dikirimkan melalui metode POST
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $nama = $_POST['nama'];
    $nis = $_POST['nis'];
    $password = md5($_POST['password']);
    
    // Lakukan validasi sederhana (Anda dapat menambahkan validasi lebih lanjut sesuai kebutuhan)
    if (empty($username) || empty($email) || empty($nama) || empty($nis) ||empty($password)) {
        echo "Semua bidang harus diisi.";
    } else {
    // Koneksi ke database
    $servername = "localhost";
    $dbname = "aspirasiku";
    $koneksi = new mysqli($servername, 'henji', '',$dbname);

    // Periksa koneksi
    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }

    // pemeriksaan kesamaan di database
    $check_username = $koneksi->prepare("SELECT * FROM siswa WHERE username = ?");
    $check_username->bind_param("s", $username);
    $check_username->execute();
    $result = $check_username->get_result();
    if ($result->num_rows > 0) {
        echo "<script>showNotification('Username sudah digunakan. Silakan gunakan username lain')</script>";
        echo "<style>.notification { background-color: #ff0000; }</style>";
    } else{
    // Siapkan pernyataan SQL untuk disiapkan
    $stmt = $koneksi->prepare("INSERT INTO siswa (nis, nama, username, password, email) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Pernyataan SQL tidak dapat dipersiapkan: " . $koneksi->error);
    }
    $stmt->bind_param("sssss", $nis, $nama, $username, $password, $email);

    // Lakukan pengeksekusian dan periksa apakah berhasil
    if ($stmt->execute()) {
        echo "<script>showNotification('Pendaftaran berhasil!'); setTimeout(function() { window.location.href = 'login.php'; }, 2000);</script>";
    } else {
        echo "Error: " . $stmt->error;
    }    
}
}
}
?>

<script>
    var togglePassword = document.getElementById('togglePassword');
    var passwordInput = document.getElementById('password');
    
    togglePassword.addEventListener('click', function() {
        var passwordFieldType = passwordInput.getAttribute('type');
        if (passwordFieldType === 'password') {
            passwordInput.setAttribute('type', 'text');
            this.textContent = 'Sembunyikan';
        } else {
            passwordInput.setAttribute('type', 'password');
            this.textContent = 'Lihat';
        }
    });
</script>
</body>