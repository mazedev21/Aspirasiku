<style>
@media screen and (max-width: 600px) {
  .sidenav-trigger{
    margin-top: 10px;
  }
}
</style>

<?php 
	session_start();
	include '../conn/koneksi.php';
	if(!isset($_SESSION['username'])){
		header('location:../index.php');
	}
	elseif($_SESSION['data']['level'] != "petugas"){
		header('location:../index.php');
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
                      <a href="#name"><span class="blue-text name"><?php echo ucwords($_SESSION['data']['nama_petugas']); ?></span></a> Aspirasiku | Dikembangkan oleh <a href='https://bit.ly/mpkbegarlist' title='MPK SMAN 2 Magelang' target='_blank'>MPK SMAN 2 Magelang</a>
					  
                  </div>
              </li>
              <li><a href="index.php?p=dashboard"><i class="material-icons">dashboard</i>Dashboard</a></li>
              <li><a href="index.php?p=aspirasi"><i class="material-icons">report</i>Aspirasi</a></li>
              <li><a href="index.php?p=respon"><i class="material-icons">question_answer</i>Respon</a></li>
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
		elseif(@$_GET['p']=="aspirasi"){
			include_once 'aspirasi.php';
		}
		elseif(@$_GET['p']=="aspirasi_hapus"){
      // Mengambil data aspirasi sebelum menghapusnya
      $query = mysqli_query($koneksi, "SELECT * FROM aspirasi WHERE id_aspirasi='".$_GET['id_aspirasi']."'");
      $data = mysqli_fetch_assoc($query);
    
      // Menghapus foto aspirasi jika ada
      if (!empty($data['foto'])) {
        unlink('../img/'.$data['foto']);
      }
    
      // Menghapus aspirasi dari database
      $delete_query = "DELETE FROM aspirasi WHERE id_aspirasi='".$_GET['id_aspirasi']."'";
    
      // Memeriksa status aspirasi
      if ($data['status'] == "proses") {
        $delete = mysqli_query($koneksi, $delete_query);
        if ($delete) {
          header('location:index.php?p=aspirasi');
        } else {
          echo "Error: " . mysqli_error($koneksi);
        }
      } elseif ($data['status'] == "selesai") {
        $delete = mysqli_query($koneksi, $delete_query);
        if ($delete) {
          // Jika aspirasi sudah selesai, juga hapus tanggapan yang terkait
          $delete_tanggapan = mysqli_query($koneksi, "DELETE FROM tanggapan WHERE id_aspirasi='".$_GET['id_aspirasi']."'");
          if ($delete_tanggapan) {
            header('location:index.php?p=aspirasi');
          } else {
            echo "Error: " . mysqli_error($koneksi);
          }
        } else {
          echo "Error: " . mysqli_error($koneksi);
        }
      }
    }
		elseif(@$_GET['p']=="more"){
			include_once 'more.php';
		}
		elseif(@$_GET['p']=="tanggapan"){
			include_once 'tanggapan.php';
		}
		elseif(@$_GET['p']=="respon"){
			include_once 'respon.php';
		}
		elseif(@$_GET['p']=="tanggapan_hapus"){
			
			$query = mysqli_query($koneksi,"DELETE FROM tanggapan WHERE id_tanggapan='".$_GET['id_tanggapan']."'");
			if($query){
				header('location:index.php?p=tanggapan_show');
			}
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