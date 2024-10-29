<?php 
session_start();
include '../conn/koneksi.php';

if(!isset($_SESSION['username'])){
    header('location:../index.php');
    exit();
} elseif($_SESSION['data']['level'] != "admin"){
    header('location:../index.php');
    exit();
}

// Handle different page requests and deletions
if (isset($_GET['p'])) {
    $page = $_GET['p'];

    switch ($page) {
        case 'regis_hapus':
            $query = mysqli_query($koneksi, "DELETE FROM siswa WHERE nis='" . $_GET['nis'] . "'");
            if ($query) {
                header('location:index.php?p=registrasi');
                exit();
            }
            break;

        case 'aspirasi_hapus':
            $query = mysqli_query($koneksi, "SELECT * FROM aspirasi WHERE id_aspirasi='" . $_GET['id_aspirasi'] . "'");
            $data = mysqli_fetch_assoc($query);
            unlink('../img/' . $data['foto']);
            if ($data['status'] == "proses") {
                $delete = mysqli_query($koneksi, "DELETE FROM aspirasi WHERE id_aspirasi='" . $_GET['id_aspirasi'] . "'");
                header('location:index.php?p=aspirasi');
                exit();
            } elseif ($data['status'] == "selesai") {
                $delete = mysqli_query($koneksi, "DELETE FROM aspirasi WHERE id_aspirasi='" . $_GET['id_aspirasi'] . "'");
                if ($delete) {
                    $delete2 = mysqli_query($koneksi, "DELETE FROM tanggapan WHERE id_aspirasi='" . $_GET['id_aspirasi'] . "'");
                    header('location:index.php?p=aspirasi');
                    exit();
                }
            }
            break;

        case 'tanggapan_hapus':
            $query = mysqli_query($koneksi, "DELETE FROM tanggapan WHERE id_tanggapan='" . $_GET['id_tanggapan'] . "'");
            if ($query) {
                header('location:index.php?p=respon');
                exit();
            }
            break;

        case 'user_hapus':
            $query = mysqli_query($koneksi, "DELETE FROM petugas WHERE id_petugas='" . $_GET['id_petugas'] . "'");
            if ($query) {
                header('location:index.php?p=user');
                exit();
            }
            break;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	
    <title>Aplikasi aspirasi siswa</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="screen,projection"/>

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable();
            $('select').formSelect();
        });
    </script>

    <style>
        @media screen and (max-width:600px) {
            .sidenav-trigger {
                margin-top: 10px;
            }
        }

        .sidenav-custom {
            background-color: #0D47A1 !important; /* Dark blue background color */
            color: white !important; /* White text color */
        }

        .sidenav-custom .user-view {
            background-color: #1565C0; /* Slightly lighter blue for user view background */
        }

        .sidenav-custom a {
            color: white !important; /* Ensure all links are white */
        }

        .sidenav-custom .user-view a {
            color: white !important; /* Ensure user view links are white */
        }

        .sidenav-custom .material-icons {
            color: white !important; /* Ensure all material icons are white */
        }
    </style>
		<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="img/favicon.jpeg">
</head>

<body style="background:url(../img/bgweb1.jpg); background-size: cover;">

<div class="row">
    <div class="col s12 m3">
        <ul id="slide-out" class="sidenav sidenav-fixed sidenav-custom">
            <li>
                <div class="user-view">
                    <div class="background">
                        <img src="../img/bgweb1.jpg">
                    </div>
                    <a href="#user"><img class="circle"
                                         src="https://th.bing.com/th/id/R.3e6e1a2ed7fa6f61cd5d6e97f7c4b0f4?rik=Rve48xGGi6SNgA&riu=http%3a%2f%2fcdn.onlinewebfonts.com%2fsvg%2fimg_424953.png&ehk=OFuupCSCtihF7ZFwMMvJXN8RFsB2GIUG%2fUOce0qwB5U%3d&risl=&pid=ImgRaw&r=0"></a>
                    <a href="#name"><span class="white-text name"><?php echo ucwords($_SESSION['data']['nama_petugas']); ?></span></a>
                    Aspirasiku | Dikembangkan oleh <a href='https://bit.ly/mpkbegarlist' title='MPK SMAN 2 Magelang' target='_blank'>MPK SMAN 2 Magelang</a>
                </div>
            </li>
            <li><a href="index.php?p=dashboard"><i class="material-icons">dashboard</i>Dashboard</a></li>
            <li><a href="index.php?p=registrasi"><i class="material-icons">featured_play_list</i>Registrasi</a></li>
            <li><a href="index.php?p=aspirasi"><i class="material-icons">report</i>Aspirasi</a></li>
            <li><a href="index.php?p=respon"><i class="material-icons">question_answer</i>Respon</a></li>
            <li><a href="index.php?p=user"><i class="material-icons">account_box</i>User</a></li>
            <li><a href="index.php?p=laporan"><i class="material-icons">book</i>Laporan</a></li>
            <li>
                <div class="divider"></div>
            </li>
            <li><a class="waves-effect" href="../index.php?p=logout"><i class="material-icons">logout</i>Logout</a></li>
        </ul>

        <a href="#" data-target="slide-out" class="btn sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>

    <div class="col s12 m9">
        <?php 
        if(!isset($_GET['p']) || $_GET['p'] == "dashboard"){
            include 'dashboard.php';
        } elseif($_GET['p'] == "registrasi"){
            include 'registrasi.php';
        } elseif($_GET['p'] == "aspirasi"){
            include 'aspirasi.php';
        } elseif($_GET['p'] == "more"){
            include 'more.php';
        } elseif($_GET['p'] == "respon"){
            include 'respon.php';
        } elseif($_GET['p'] == "user"){
            include 'user.php';
        } elseif($_GET['p'] == "user_input"){
            include 'user_input.php';
        } elseif($_GET['p'] == "user_edit"){
            include 'user_edit.php';
        } elseif($_GET['p'] == "laporan"){
            include 'laporan.php';
        }
        ?>
    </div>
</div>




      <!--JavaScript at end of body for optimized loading-->
      <script type="text/javascript" src="../js/materialize.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

      <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
          var elems = document.querySelectorAll('.sidenav');
          var instances = M.Sidenav.init(elems);
        });

        document.addEventListener('DOMContentLoaded', function() {
          var elems = document.querySelectorAll('.modal');
          var instances = M.Modal.init(elems);
        });

      </script>

    </body>
  </html>