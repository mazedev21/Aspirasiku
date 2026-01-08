<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" href="css/materialize.css">
<link rel="stylesheet" href="css/responsive.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    /* Wrapper full screen */
.page-wrapper {
  min-height: 100vh;
  min-height: 100dvh; /* aman mobile */
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 16px;
}
   .cont {
      padding: 50px;
      width: 40%;
      max-width: 420px;
      margin: 0 auto;
      margin-top: 5px;
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

.toggle-password {
  position: absolute;
  right: 10px;
  top: 30px;
  cursor: pointer;
  color: #9e9e9e;
}

.input-field .suffix {
  right: 10px;
}
/* Mobile khusus */
@media only screen and (max-width: 600px) {
  .cont {
    min-width: 100%;
    padding: 16px;
  }
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
<body style="background: url(img/bgweb1.jpg); background-size: cover; height: 100vh;">
<html>
<div id="notification" class="notification"></div>
<div class="page-wrapper">
  <div class="cont">

    <h3 class="blue-text center">Daftar Akun</h3>

    <p class="center">
      Dikembangkan oleh
      <a href="https://bit.ly/mpkbegarlist" target="_blank">
        MPK SMAN 2 Magelang
      </a>
    </p>

    <form method="POST">
      <div class="input_field">
        <label for="username">Username</label>
        <input id="username" type="text" name="username" required>
      </div>

      <div class="input_field">
        <label for="nama">Nama Lengkap</label>
        <input id="nama" type="text" name="nama" required>
      </div>

      <div class="input_field">
        <label for="nis">Nomor Induk Siswa (NIS)</label>
        <input id="nis" type="number" name="nis" required>
      </div>

      <div class="input_field" style="position: relative;">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>

        <i class="material-icons toggle-password"
           onclick="togglePassword()"
           id="toggleIcon">
          visibility
        </i>
      </div>

      <input type="submit"
             name="daftar"
             value="Daftar"
             class="btn blue"
             style="width:100%;">
    </form>

    <p class="center">
      Kembali ke Halaman <a href="login.php">Login</a>
    </p>

  </div>
</div>

</html>

<?php
require_once __DIR__ . "/conn/koneksi.php";

// Periksa apakah data dikirimkan melalui metode POST
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $nis = $_POST['nis'];
    $password = md5($_POST['password']);
    
    // Lakukan validasi sederhana (Anda dapat menambahkan validasi lebih lanjut sesuai kebutuhan)
    if (empty($username) || empty($nama) || empty($nis) ||empty($password)) {
        echo "Semua bidang harus diisi.";
    } else {

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
    $stmt = $koneksi->prepare("INSERT INTO siswa (nis, nama, username, password) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        die("Pernyataan SQL tidak dapat dipersiapkan: " . $koneksi->error);
    }
    $stmt->bind_param("ssss", $nis, $nama, $username, $password);

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
function togglePassword() {
  const password = document.getElementById("password");
  const icon = document.getElementById("toggleIcon");

  if (password.type === "password") {
    password.type = "text";
    icon.textContent = "visibility_off";
  } else {
    password.type = "password";
    icon.textContent = "visibility";
  }
}
</script>
</body>