<style>
	/* Aturan CSS responsif */
@media screen and (max-width: 600px) {
    table.responsive-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        overflow-x: auto;
    }

    table.responsive-table th,
    table.responsive-table td {
        padding: 10px;
        text-align: left;
        min-width: 100px;
        word-wrap: break-word;
		white-space: nowrap;
    }

    table.responsive-table th {
        background-color: #f2f2f2;
    }

    /* Lebih banyak aturan CSS responsif sesuai kebutuhan */
    /* Misalnya, untuk form, gambar, dan tombol */
    form {
        padding: 20px;
    }

    form label,
    form input[type="file"],
    form input[type="submit"] {
        display: block;
        margin-bottom: 10px;
    }

    img {
        max-width: 100%;
        height: auto;
    }

    .btn {
        display: block;
        margin-bottom: 10px;
    }

    /* Aturan CSS untuk modal jika diperlukan */
    .modal-content {
        padding: 20px;
    }

    .modal-content p {
        margin-bottom: 10px;
    }

    .modal-footer {
        padding: 10px 20px;
    }
}

</style>

<table class="responsive-table" border="2" style="width: 100%;">
	<tr>
		<td><h4 class="gray-text hide-on-med-and-down">Tulis Aspirasi</h4></td>
		<td><h4 class="gray-text hide-on-med-and-down">Daftar Aspirasi</h4></td>
	</tr>
	<tr>
		<td style="padding: 20px;">
			<form method="POST" enctype="multipart/form-data">
				<textarea class="materialize-textarea" name="laporan" placeholder="Tulis Aspirasi"></textarea><br><br>
				<label>Kategori</label>
      			  <select name="kategori" class="browser-default">
         		   <option value="Kurikulum">Kurikulum</option>
         		   <option value="Kesiswaan">Kesiswaan</option>
         		   <option value="Sarana dan Prasarana">Sarana dan Prasarana</option>
          		  <option value="Hubungan Masyarakat">Hubungan Masyarakat</option>
       			 </select><br><br>
				<label>Gambar</label>
				<input type="file" name="foto"><br><br>
				<input type="submit" name="kirim" value="Kirim" class="btn blue">
			</form>
		</td>

		<td>

			<table border="3" class="responsive-table striped highlight">
				<tr>
					<td>No</td>
					<td>NIS</td>
					<td>Nama</td>
					<td>Kategori</td>
					<td>Tanggal Masuk</td>
					<td>Status</td>
					<td>Opsi</td>
				</tr>
	
				<?php 
				error_reporting(E_ALL);
				ini_set('display_errors', 1);
					$no = 1;
					$aspirasi = mysqli_query($koneksi,"SELECT * FROM aspirasi INNER JOIN siswa ON aspirasi.nis=siswa.nis LEFT JOIN tanggapan ON aspirasi.id_aspirasi=tanggapan.id_aspirasi WHERE aspirasi.nis='".$_SESSION['data']['nis']."' AND (aspirasi.status = 'selesai' OR tanggapan.id_aspirasi IS NULL) ORDER BY aspirasi.id_aspirasi DESC");
					while ($r = mysqli_fetch_assoc($aspirasi)) { ?>
						<tr>
							<td><?php echo $no++; ?></td>
							<td><?php echo $r['nis']; ?></td>
							<td><?php echo $r['nama']; ?></td>
							<td><?php echo $r['kategori']; ?></td>
							<td><?php echo $r['tgl_aspirasi']; ?></td>
							<td><?php echo $r['status']; ?></td>
							<td>
								<a class="btn modal-trigger blue" href="#tanggapan&id_aspirasi=<?php echo $r['id_aspirasi'] ?>">More</a>
								<a class="btn red" onclick="return confirm('Anda Yakin Ingin Menghapus Y/N')" href="index.php?p=aspirasi_hapus&id_aspirasi=<?php echo $r['id_aspirasi'] ?>">Hapus</a>
							</td>
				<!-- ------------------------------------------------------------------------------------------------------------------------------------ -->
						<!-- Modal Structure -->
						<div id="tanggapan&id_aspirasi=<?php echo $r['id_aspirasi'] ?>" class="modal">
						<div class="modal-content">
							<h4 class="gray-text">Detail</h4>
							<div class="col s12 m6">
								<p>NIS : <?php echo $r['nis']; ?></p>
								<p>Dari : <?php echo $r['nama']; ?></p>
								<p>Petugas : <?php echo isset($r['nama_petugas']) ? $r['nama_petugas'] : 'Belum ditanggapi'; ?></p>
								<p>Kategori : <?php echo $r['kategori']; ?></p>
								<p>Tanggal Masuk : <?php echo $r['tgl_aspirasi']; ?></p>
								<p>Tanggal Ditanggapi : <?php echo $r['tgl_tanggapan']; ?></p>
								<?php 
									if($r['foto']=="kosong"){ ?>
										<img src="../img/noImage.png" width="100">
								<?php	}else{ ?>
									<img width="100" src="../img/<?php echo $r['foto']; ?>">
								<?php }
								?>
								<br><b>Pesan</b>
								<p><?php echo $r['isi_laporan']; ?></p>
								<br><b>Respon</b>
								<p><?php echo $r['tanggapan']; ?></p>
							</div>
						
							</div>
						<div class="modal-footer col s12">
							<a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
						</div>
						</div>
				<!-- ------------------------------------------------------------------------------------------------------------------------------------ -->

						</tr>
							<?php  }
							?>

						</tbody>
						</table>  
					<?php 
						if (isset($_POST['kirim'])) {
							// Retrieve form data
							$nis = $_SESSION['data']['nis'];
							$kategori = $_POST['kategori'];
							$tgl = date('Y-m-d');
						
							// File data
							$foto = $_FILES['foto']['name'];
							$source = $_FILES['foto']['tmp_name'];
							$folder = './../img/';
							$listeks = array('jpg', 'png', 'jpeg', 'img');
							$eks = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
							$size = $_FILES['foto']['size'];
							$nama = date('dmYis') . $foto;
						
							// Check if file is uploaded
							if ($foto != "") {
								if (in_array($eks, $listeks)) {
									if ($size <= 10000000) {
										if (move_uploaded_file($source, $folder . $nama)) {
											// Escaping the laporan input to prevent SQL injection
											$laporan = mysqli_real_escape_string($koneksi, $_POST['laporan']);
											
											// Inserting data into the database
											$query = "INSERT INTO aspirasi (tgl_aspirasi, nis, kategori, isi_laporan, foto, status) VALUES ('$tgl', '$nis', '$kategori', '$laporan', '$nama', 'proses')";
											$result = mysqli_query($koneksi, $query);
						
											if ($result) {
												echo "<script>alert('Aspirasi akan segera diproses')</script>";
												echo "<script>location='index.php';</script>";
											} else {
												echo "<script>alert('Gagal menyimpan aspirasi ke database')</script>";
												echo "Error: " . mysqli_error($koneksi);
											}
										} else {
											echo "<script>alert('Gagal mengunggah file')</script>";
										}
									} else {
										echo "<script>alert('Ukuran gambar tidak boleh lebih dari 10MB')</script>";
									}
								} else {
									echo "<script>alert('Format file tidak didukung')</script>";
								}
							} else {
								// Handle case when no file is uploaded
								$laporan = mysqli_real_escape_string($koneksi, $_POST['laporan']);
								
								// Inserting data into the database without file
								$query = "INSERT INTO aspirasi (tgl_aspirasi, nis, kategori, isi_laporan, status) VALUES ('$tgl', '$nis', '$kategori', '$laporan', 'proses')";
								$result = mysqli_query($koneksi, $query);
						
								if ($result) {
									echo "<script>alert('Aspirasi akan segera diproses')</script>";
									echo "<script>location='index.php';</script>";
								} else {
									echo "<script>alert('Gagal menyimpan aspirasi ke database')</script>";
									echo "Error: " . mysqli_error($koneksi);
								}
							}
						}						

					?>