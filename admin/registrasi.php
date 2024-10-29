<style>
/* Aturan CSS responsif */
@media screen and (max-width: 600px) {
    .gray-text {
        font-size: 1.2em;
        position: absolute;
        top: 0;
        right: 0;
        margin: 20px;
        font-weight: bold;
    }

    .col {
        width: 100%;
    }

    .modal-content {
        padding: 15px;
    }

    .modal-footer {
        padding: 10px 15px;
    }

    /* Tambahkan aturan CSS untuk tabel responsif */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
		border-collapse: collapse;
        margin-bottom: 20px;
        margin-top: 50px; /* Mengurangi jarak atas tabel */
        overflow-x: auto; /* Memberikan scroll horizontal jika perlu */
		display: flex;
		flex-wrap: wrap;
    }

    th, td {
        padding: 10px;
        text-align: left;
		flex: 1; /* Mengatur agar setiap kolom tabel memiliki proporsi yang sama */
        border: 1px solid #ddd; /* Menambahkan border untuk memperjelas batas antar kolom */
		min-width: 50px; /* Menentukan lebar minimal kolom */
		max-width: 250px;
		word-wrap: break-word; /* Mengizinkan pemecahan kata jika teks terlalu panjang */
		min-height: 10px; /* Menentukan tinggi minimal untuk setiap kolom */
		max-height: 15.5px;
        display: flex; /* Menyesuaikan tata letak isi di dalam kolom */
        align-items: center; /* Memusatkan isi vertikal di dalam kolom */
        justify-content: center; /* Memusatkan isi horizontal di dalam kolom */
    }

    /* Aturan CSS untuk baris pada tabel */
    tr {
        border-bottom: 1px solid #ddd;
		
    }

    /* Aturan CSS untuk tajuk kolom pada tabel */
    th {
        background-color: #f2f2f2;
    }

    /* Aturan CSS untuk tombol di dalam tabel */
    .btn {
        margin-bottom: 5px;
    }

    /* Aturan CSS untuk modal */
    .modal {
        max-width: 100%;
        width: 100%;
    }
}
</style>
	  <div class="row">
          <div class="col s12 m9">
            <h3 class="gray-text">Data Siswa</h3>
          </div>  
          <div class="col s12 m3">
            <div class="section"></div>
            <a class="waves-effect waves-light btn modal-trigger black" href="#modal1"><i class="material-icons">add</i></a>
          </div>
        </div>

        <table id="example" class="display responsive-table" style="width:100%">
          <thead>
              <tr>
					<th>No</th>
					<th>NIS</th>
					<th>Nama</th>
					<th>Username</th>
                	<th>Opsi</th>
              </tr>
          </thead>
          <tbody>
            
	<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
		$no=1;
		$query = mysqli_query($koneksi,"SELECT * FROM siswa ORDER BY nis ASC");
		while ($r=mysqli_fetch_assoc($query)) { ?>
		<tr>
			<td><?php echo $no++; ?></td>
			<td><?php echo $r['nis']; ?></td>
			<td><?php echo $r['nama']; ?></td>
			<td><?php echo $r['username']; ?></td>
			<td><a class="btn blue modal-trigger" href="#regis_edit?nis=<?php echo $r['nis'] ?>">Edit</a> <a onclick="return confirm('Anda Yakin Ingin Menghapus Y/N')" class="btn red" href="index.php?p=regis_hapus&nis=<?php echo $r['nis'] ?>">Hapus</a></td>

<!-- ------------------------------------------------------------------------------------------------------------------------------------ -->
        <!-- Modal Structure -->
        <div id="regis_edit?nis=<?php echo $r['nis'] ?>" class="modal">
          <div class="modal-content">
            <h4>Edit</h4>
			<form method="POST">
				<div class="col s12 input-field">
					<label for="nis">NIS</label>
					<input id="nis" type="number" name="nis" value="<?php echo $r['nis']; ?>">
				</div>
				<div class="col s12 input-field">
					<label for="nama">Nama</label>
					<input id="nama" type="text" name="nama" value="<?php echo $r['nama']; ?>">
				</div>
				<div class="col s12 input-field">
					<label for="username">Username</label>		
					<input id="username" type="text" name="username" value="<?php echo $r['username']; ?>"><br><br>
				</div>
				<div class="col s12 input-field">
					<input type="submit" name="Update" value="Simpan" class="btn right">
				</div>
			</form>

			<?php 
				if(isset($_POST['Update'])){
					$update=mysqli_query($koneksi,"UPDATE siswa SET nis='".$_POST['nis']."',nama='".$_POST['nama']."',username='".$_POST['username']."' WHERE nis='".$r['nis']."' ");
					if($update){
						echo "<script>alert('Data Tersimpan')</script>";
						echo "<script>location='location:index.php?p=registrasi';</script>";
					}
				}
			 ?>
          </div>
          <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-black btn-flat">Close</a>
          </div>
        </div>
<!-- ------------------------------------------------------------------------------------------------------------------------------------ -->

		</tr>
            <?php  }
             ?>

          </tbody>
        </table>        

        <!-- Modal Structure -->
        <div id="modal1" class="modal">
          <div class="modal-content">
            <h4>Add</h4>
			<form method="POST">
				<div class="col s12 input-field">
					<label for="nis">NIS</label>
					<input id="nis" type="number" name="nis">
				</div>
				<div class="col s12 input-field">
					<label for="nama">Nama</label>
					<input id="nama" type="text" name="nama">
				</div>
				<div class="col s12 input-field">
					<label for="username">Username</label>		
					<input id="username" type="text" name="username"><br><br>
				</div>
				<div class="col s12 input-field">
					<label for="password">Password</label>
					<input id="password" type="password" name="password"><br><br>
				</div>
				<div class="col s12 input-field">
					<input type="submit" name="simpan" value="Simpan" class="btn right">
				</div>
			</form>

			<?php
if (isset($_POST['simpan'])) {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
	
	echo "NIS: $nis<br>";
    echo "Nama: $nama<br>";
    echo "Username: $username<br>";
    echo "Password: $password<br>";

    if (!empty($nis) && !empty($nama) && !empty($username) && !empty($password)) {
        $query = "INSERT INTO siswa (nis, nama, username, password) VALUES ('$nis', '$nama', '$username', '$password')";
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Data Tersimpan')</script>";
            echo "<script>location='index.php?p=registrasi';</script>";
        } else {
            error_log("Error: " . $query . " - " . mysqli_error($koneksi));
            echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
        }
    } else {
        echo "<script>alert('Semua field harus diisi.')</script>";
    }
}
?>


          </div>
          <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-black btn-flat">Close</a>
          </div>
        </div>