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
		if(@$_GET['p']==""){
			include_once 'dashboard.php';
		}
		elseif(@$_GET['p']=="dashboard"){
			include_once 'dashboard.php';
		}
		elseif(@$_GET['p']=="aspirasi_hapus"){
      $id_aspirasi = $_GET['id_aspirasi'];
			$query=mysqli_query($koneksi,"SELECT * FROM aspirasi WHERE id_aspirasi='$id_aspirasi'");
			$data=mysqli_fetch_assoc($query);
			unlink('../img/'.$data['foto']);
      $delete_kategori = mysqli_query($koneksi, "DELETE FROM aspirasi WHERE kategori='".$data['kategori']."' AND id_aspirasi='".$_GET['id_aspirasi']."'"); /**Parse error: syntax error, unexpected token "." in C:\xampp\htdocs\Aspirasiku\siswa\index.php on line 110 */
			if($data['status']=="proses"){
				$delete=mysqli_query($koneksi,"DELETE FROM aspirasi WHERE id_aspirasi='".$_GET['id_aspirasi']."'");
				header('location:index.php?p=dashboard');
			}
			elseif($data['status']=="selesai"){
				$delete=mysqli_query($koneksi,"DELETE FROM aspirasi WHERE id_aspirasi='".$_GET['id_aspirasi']."'");
				if($delete){
					$delete2=mysqli_query($koneksi,"DELETE FROM tanggapan WHERE id_aspirasi='".$_GET['id_aspirasi']."'");
					header('location:index.php?p=dashboard');
				}	
      }
		}
		elseif(@$_GET['p']=="more"){
			include_once 'more.php';
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