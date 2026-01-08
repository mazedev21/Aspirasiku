<!DOCTYPE html>
<html>
<head>
    <title>Aspirasiku</title>
    <!-- Include Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
	<style>
	/* Aturan CSS responsif */
    
@@media screen and (max-width: 600px) {
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
		display: block;
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
		max-height: 13px;
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

.responsive-table-wrapper {
        display: block;
        max-height: 400px; /* Atur tinggi maksimum tabel */
        max-width: 440px;
        overflow-y: auto; /* Aktifkan overflow vertikal */
        overflow-x: auto;
    }
</style>
</head>
<body>

<div class="container">
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
                <div class="responsive-table-wrapper">
                <table border="3" class="responsive-table striped highlight">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>NIS</td>
                            <td>Nama</td>
                            <td>Kategori</td>
                            <td>Tanggal Masuk</td>
                            <td>Status</td>
                            <td>Opsi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        error_reporting(E_ALL);
                        ini_set('display_errors', 1);

                        $no = 1;
                        $query = "
                            SELECT 
                                a.id_aspirasi, 
                                a.tgl_aspirasi, 
                                a.nis, 
                                a.kategori, 
                                a.isi_laporan, 
                                a.foto, 
                                a.status, 
                                s.nama, 
                                s.username, 
                                s.password, 
                                s.telp, 
                                t.id_tanggapan, 
                                t.tgl_tanggapan, 
                                t.tanggapan, 
                                t.id_petugas 
                            FROM 
                                aspirasi a 
                            INNER JOIN 
                                siswa s ON a.nis = s.nis 
                            LEFT JOIN 
                                tanggapan t ON a.id_aspirasi = t.id_aspirasi 
                            WHERE a.nis = '" . $_SESSION['data']['nis'] . "' 
                                AND (a.status = 'selesai' OR t.id_aspirasi IS NULL)
                            ORDER BY 
                                a.id_aspirasi DESC
                        ";
                        $aspirasi = mysqli_query($koneksi, $query);

                        while ($r = mysqli_fetch_assoc($aspirasi)) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $r['nis']; ?></td>
                            <td><?php echo $r['nama']; ?></td>
                            <td><?php echo $r['kategori']; ?></td>
                            <td><?php echo $r['tgl_aspirasi']; ?></td>
                            <td><?php echo $r['status']; ?></td>
                            <td>
                                <a class="btn modal-trigger blue" href="#tanggapan<?php echo $r['id_aspirasi']; ?>">More</a>
                                <a class="btn red" onclick="return confirm('Anda Yakin Ingin Menghapus Y/N')" 
                                   href="index.php?p=aspirasi_hapus&id_aspirasi=<?php echo $r['id_aspirasi']; ?>">Hapus</a> 
                            </td>
                        </tr>
                        <!-- Modal Structure -->
                        <div id="tanggapan<?php echo $r['id_aspirasi']; ?>" class="modal">
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
                                    if ($r['foto'] == "kosong") { ?>
                                        <img src="../img/noImage.jpg" width="100">
                                    <?php } else { ?>
                                        <img width="100" src="../img/<?php echo $r['foto']; ?>">
                                    <?php } ?>
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
                        <?php } ?>
                    </tbody>
                </table>
                </div>
            </td>
        </tr>
    </table>
</div>

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
        $query = "INSERT INTO aspirasi (tgl_aspirasi, nis, kategori, isi_laporan, foto, status) VALUES ('$tgl', '$nis', '$kategori', '$laporan', 'noImage.jpg', 'proses')";
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

<!-- Include jQuery and Materialize JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
    $(document).ready(function(){
        $('.modal').modal();
    });
</script>

</body>
</html>
