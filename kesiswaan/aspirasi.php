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
		min-width: 100px; /* Menentukan lebar minimal kolom */
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
            <h3 class="gray-text">Aspirasi</h3>
          </div>
        </div>

        <table id="example" class="display responsive-table" style="width:100%">
          <thead>
              <tr>
				<th>No</th>
				<th>NIS</th>
				<th>Nama</th>
                <th>Kategori</th>
				<th>Tanggal Masuk</th>
				<th>Status</th>
				<th>Opsi</th>
              </tr>
          </thead>
          <tbody>
            
	<?php 
		$no=1;
		$query = mysqli_query($koneksi,"SELECT * FROM aspirasi INNER JOIN siswa ON aspirasi.nis=siswa.nis WHERE aspirasi.status='proses' AND aspirasi.kategori='kesiswaan' ORDER BY aspirasi.id_aspirasi DESC");
		while ($r=mysqli_fetch_assoc($query)) { ?>
		<tr>
			<td><?php echo $no++; ?></td>
			<td><?php echo $r['nis']; ?></td>
			<td><?php echo $r['nama']; ?></td>
            <td><?php echo $r['kategori']; ?></td>
			<td><?php echo $r['tgl_aspirasi']; ?></td>
			<td><?php echo $r['status']; ?></td>
			<td><a class="btn modal-trigger blue" href="#more?id_aspirasi=<?php echo $r['id_aspirasi'] ?>">More</a>  <a class="btn red" onclick="return confirm('Anda Yakin Ingin Menghapus Y/N')" href="index.php?p=aspirasi_hapus&id_aspirasi=<?php echo $r['id_aspirasi'] ?>">Hapus</a></td>

<!-- ------------------------------------------------------------------------------------------------------------------------------------ -->
        <!-- Modal Structure -->
        <div id="more?id_aspirasi=<?php echo $r['id_aspirasi'] ?>" class="modal">
          <div class="modal-content">
            <h4 class="gray-text">Detail</h4>
            <div class="col s12 m6">
				<p>NIS : <?php echo $r['nis']; ?></p>
            	<p>Dari : <?php echo $r['nama']; ?></p>
                <p>Kategori : <?php echo $r['kategori']; ?></p>
				<p>Tanggal Masuk : <?php echo $r['tgl_aspirasi']; ?></p>
				<?php 
					if($r['foto']=="kosong"){ ?>
						<img src="../img/noimage.jpg" width="100">
				<?php	}else{ ?>
					<img width="100" src="../img/<?php echo $r['foto']; ?>">
				<?php }
				 ?>
				<br><b>Pesan</b>
				<p><?php echo $r['isi_laporan']; ?></p>
				<p>Status : <?php echo $r['status']; ?></p>
            </div>
            <?php 
            	if($r['status']=="proses"){ ?>
	            <div class="col s12 m6">
					<form method="POST">
						<div class="col s12 input-field">
							<label for="textarea">Tanggapan</label>
							<textarea id="textarea" name="tanggapan" class="materialize-textarea"></textarea>
						</div>
						<div class="col s12 input-field">
							<input type="submit" name="tanggapi" value="Kirim" class="btn right">
						</div>
					</form>
	            </div>
            <?php	}
             ?>

			<?php 
				if(isset($_POST['tanggapi'])){
					$tgl = date('Y-m-d');
					$query = mysqli_query($koneksi,"INSERT INTO tanggapan VALUES (NULL,'".$r['id_aspirasi']."','".$tgl."','".$_POST['tanggapan']."','".$_SESSION['data']['id_petugas']."')");
					if($query){
						$update=mysqli_query($koneksi,"UPDATE aspirasi SET status='selesai' WHERE id_aspirasi='".$r['id_aspirasi']."'");
						if($update){
							echo "<script>alert('Tanggapan Terkirim')</script>";
							echo "<script>location='index.php?p=aspirasi';</script>";
						}
					}
				}
			 ?>
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