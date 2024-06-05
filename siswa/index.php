<style>
  /* CSS untuk tombol sidenav responsif */
@media screen and (max-width: 992px) {
  .sidenav-trigger {
    display: block; /* Tampilkan tombol sidenav */
    margin-top: 10px;
    width: 47px;
    height: 40px;  
  }

  .sidenav-fixed {
    transform: translateX(-100%); /* Sembunyikan sidenav */
  }
}

/* Tombol sidenav */
.sidenav-trigger {
  display: none; /* Sembunyikan tombol sidenav */
}

</style>

<?php 
	session_start();
	error_reporting(0);
	include '../conn/koneksi.php';
	if(!isset($_SESSION['username'])){
		header('location:../index.php');
		exit();
	}
	elseif($_SESSION['level'] != "siswa"){
		header('location:../index.php');
		exit();
	}
?>
  <!DOCTYPE html>
  <html>
    <head>
    	<title>Aspirasiku</title>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>

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
        $(document).ready( function () {
          $('#example').DataTable();
          $('select').formSelect();
        } );
      
      </script>

    </head>

    <body style="background:url(../img/bgweb.jpg); background-size: cover;">

    <div class="row">
      <div class="col s12 m3">
          <ul id="slide-out" class="sidenav sidenav-fixed">
              <li>
                  <div class="user-view">
                      <div class="background">
                          <img src="../img/bgweb.jpg">
                      </div>
                      <a href="#user"><img class="circle" src="https://th.bing.com/th/id/R.3e6e1a2ed7fa6f61cd5d6e97f7c4b0f4?rik=Rve48xGGi6SNgA&riu=http%3a%2f%2fcdn.onlinewebfonts.com%2fsvg%2fimg_424953.png&ehk=OFuupCSCtihF7ZFwMMvJXN8RFsB2GIUG%2fUOce0qwB5U%3d&risl=&pid=ImgRaw&r=0"></a>
                      <a href="#name"><span class="blue-text name"><?php echo ucwords($_SESSION['data']['nama']); ?></span></a> Aspirasiku | Dikembangkan oleh <a href='https://bit.ly/mpkbegarlist' title='MPK SMAN 2 Magelang' target='_blank'>MPK SMAN 2 Magelang</a>
					  
                  </div>
              </li>
              <li><a href="index.php?p=dashboard"><i class="material-icons">dashboard</i>Dashboard</a></li>
              <li>
                  <div class="divider"></div>
              </li>
              <li><a class="waves-effect" href="../index.php?p=logout"><i class="material-icons">logout</i>Logout</a></li>
          </ul>

          <a href="#" data-target="slide-out" class="btn sidenav-trigger"><i class="material-icons">menu</i></a>
      </div>

      <div class="col s12 m9">
      <?php 
include_once 'koneksi.php';

function redirect($location) {
    header("Location: $location");
    exit;
}

$p = isset($_GET['p']) ? $_GET['p'] : 'dashboard';

switch ($p) {
    case '':
    case 'dashboard':
        include_once 'dashboard.php';
        break;

    case 'aspirasi_hapus':
        $id_aspirasi = isset($_GET['id_aspirasi']) ? $_GET['id_aspirasi'] : '';

        // Debugging: Check if id_aspirasi is received
        if (!$id_aspirasi) {
            echo "Error: id_aspirasi is missing!";
            exit;
        }

        $stmt = $koneksi->prepare("SELECT * FROM aspirasi WHERE id_aspirasi = ?");
        $stmt->bind_param("i", $id_aspirasi);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($data = $result->fetch_assoc()) {
            $foto = '../img/' . $data['foto'];
            if (file_exists($foto) && is_writable($foto)) {
                unlink($foto);
            }
            $stmt->close();

            $stmt_delete = $koneksi->prepare("DELETE FROM aspirasi WHERE id_aspirasi = ?");
            $stmt_delete->bind_param("i", $id_aspirasi);
            $stmt_delete->execute();
            $stmt_delete->close();

            if ($data['status'] == "selesai") {
                $stmt_delete_tanggapan = $koneksi->prepare("DELETE FROM tanggapan WHERE id_tanggapan = ?");
                $stmt_delete_tanggapan->bind_param("i", $id_aspirasi);
                $stmt_delete_tanggapan->execute();
                $stmt_delete_tanggapan->close();
            }
            redirect('index.php?p=dashboard');
        } else {
            echo "Error: No record found for id_aspirasi = $id_aspirasi";
            exit;
        }
        break;

    case 'more':
        include_once 'more.php';
        break;

    default:
        include_once '404.php';
        break;
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