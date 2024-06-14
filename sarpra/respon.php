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
		min-width: 150px; /* Menentukan lebar minimal kolom */
        word-wrap: break-word; /* Mengizinkan pemecahan kata jika teks terlalu panjang */
		min-height: 10px; /* Menentukan tinggi minimal untuk setiap kolom */
		max-height: 15px;
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
            <h3 class="gray-text">Respon</h3>
          </div>
        </div>

        <table id="example" class="display responsive-table" style="width:100%">
          <thead>
              <tr>
				<th>No</th>
				<th>NIS</th>
				<th>Nama</th>
                <th>Kategori</th>
				<th>Petugas</th>
				<th>Tanggal Masuk</th>
				<th>Tanggal Ditanggapi</th>
				<th>Status</th>
				<th>Opsi</th>
              </tr>
          </thead>
          <tbody>
            
	<?php 
		$no=1;
		$query = mysqli_query($koneksi,"SELECT * FROM aspirasi INNER JOIN siswa ON aspirasi.nis=siswa.nis AND aspirasi.kategori='sarana dan prasarana' INNER JOIN tanggapan ON aspirasi.id_aspirasi=tanggapan.id_aspirasi INNER JOIN petugas ON tanggapan.id_petugas=petugas.id_petugas ORDER BY tanggapan.id_aspirasi DESC");
		while ($r=mysqli_fetch_assoc($query)) { ?>
		<tr>
			<td><?php echo $no++; ?></td>
			<td><?php echo $r['nis']; ?></td>
			<td><?php echo $r['nama']; ?></td>
            <td><?php echo $r['kategori']; ?></td>
			<td><?php echo $r['nama_petugas']; ?></td>
			<td><?php echo $r['tgl_aspirasi']; ?></td>
			<td><?php echo $r['tgl_tanggapan']; ?></td>
			<td><?php echo $r['status']; ?></td>
			<td><a class="btn blue modal-trigger" href="#more?id_tanggapan=<?php echo $r['id_tanggapan'] ?>">More</a></td>
		

<!-- ------------------------------------------------------------------------------------------------------------------------------------ -->
        <!-- Modal Structure -->
        <div id="more?id_tanggapan=<?php echo $r['id_tanggapan'] ?>" class="modal">
          <div class="modal-content">
            <h4 class="gray-text">Detail</h4>
            <div class="col s12">
				<p>NIS : <?php echo $r['nis']; ?></p>
            	<p>Dari : <?php echo $r['nama']; ?></p>
                <p>Kategori : <?php echo $r['kategori']; ?></p>
            	<p>Petugas : <?php echo $r['nama_petugas']; ?></p>
				<p>Tanggal Masuk : <?php echo $r['tgl_aspirasi']; ?></p>
				<p>Tanggal Ditanggapi : <?php echo $r['tgl_tanggapan']; ?></p>
				<?php 
					if($r['foto']=="kosong"){ ?>
						<img src="../img/noImage.jpg" width="100">
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