<!DOCTYPE html>
<html>
<head>
	<style>
		body, table {
			font-family: 'Times New Roman', Times, serif;
		}
		.kop {
			display: flex;
			justify-content: space-between;
			align-items: center;
			border-bottom: 2px solid black;
			padding-bottom: 10px;
			margin-bottom: 20px;
		}
		.kop img {
			height: 100px;
		}
		.kop-center {
			text-align: center;
			flex: 1;
			margin: 0 20px;
		}
		.kop-center h3 {
			margin: 0;
			font-size: 18px;
		}
		.kop-center p {
			margin: 5px 0;
			font-size: 14px;
		}
	</style>
</head>
<body>

<div class="kop">
    <img src="../img/jateng.png" alt="Logo Pemprov">
    <div class="kop-center">
        <h3>PEMERINTAH PROVINSI JAWA TENGAH</h3>
        <h3>DINAS PENDIDIKAN DAN KEBUDAYAAN</h3>
        <h3>SEKOLAH MENENGAH ATAS NEGERI 2 MAGELANG</h3>
        <p>Jln. Jend. Urip Sumoharjo, Wates, Magelang / Kode Pos 56113</p>
		<p>Telepon 0293-363669</p>
        <p>Email: sman2magelang@yahoo.co.id | Website: www.sman2-magelang.sch.id</p>
    </div>
    <img src="../img/logo-mpk.png" alt="Logo MPK">
</div>

<h2 style="text-align: center;">Aspirasiku</h2>
<table border="2" style="width: 100%; height: 10%;">
	<tr style="text-align: center;">
		<td>No</td>
		<td>NIS Pelapor</td>
		<td>Nama Pelapor</td>
		<td>Kategori Laporan</td>
		<td>Nama Responden</td>
		<td>Laporan</td>
		<td>Respon</td>
		<td>Tanggal Masuk</td>
		<td>Tanggal Ditanggapi</td>
		<td>Status</td>
	</tr>
	<?php 
		include '../conn/koneksi.php';
		$no=1;
		$query = mysqli_query($koneksi,"SELECT * FROM aspirasi INNER JOIN siswa ON aspirasi.nis=siswa.nis INNER JOIN tanggapan ON tanggapan.id_aspirasi=aspirasi.id_aspirasi INNER JOIN petugas ON tanggapan.id_petugas=petugas.id_petugas ORDER BY tgl_aspirasi DESC");
		while ($r=mysqli_fetch_assoc($query)) { ?>
		<tr>
			<td><?php echo $no++; ?></td>
			<td><?php echo $r['nis']; ?></td>
			<td><?php echo $r['nama']; ?></td>
			<td><?php echo $r['kategori']; ?></td>
			<td><?php echo $r['nama_petugas']; ?></td>
			<td><?php echo $r['isi_laporan']; ?></td>
			<td><?php echo $r['tanggapan']; ?></td>
			<td><?php echo $r['tgl_aspirasi']; ?></td>
			<td><?php echo $r['tgl_tanggapan']; ?></td>
			<td><?php echo $r['status']; ?></td>
		</tr>
	<?php	}
	 ?>
</table>
<script type="text/javascript">
	window.print();
</script>

</body>
</html>
