<?php
ob_start();
include "koneksi.php";
if(!isset($_SESSION['user'])){
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    
    
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .header-with-background-image {
            background-image: url('img/pg.jpg'); /* Replace 'img/bg.jpg' with the actual path to your image */
            background-size: cover;

            background-repeat: no-repeat;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

       <!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-book-open"></i>
    </div>
    <div class="sidebar-brand-text mx-3">MidLane Cafe</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="index.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Navigasi
</div>

<?php
// Cek apakah pengguna adalah petugas atau peminjam
if ($_SESSION['user']['role'] == 'admin') {
    ?>
    <!-- Nav Item - Peminjaman -->
    <li class="nav-item">
        <a class="nav-link" href="?page=user">
            <i class="fas fa-book-open"></i>
            <span>Data Petugas</span></a>
    </li>
   
<?php
}

// // Hanya tampilkan untuk level peminjam
// if ($_SESSION['user']['role'] == 'kasir') {
//     ? >
//     <!-- Nav Item - Ulasan -->
//     <li class="nav-item">
//         <a class="nav-link" href="?page=ulasan">
//             <i class="fas fa-comment"></i>
//             <span>Ulasan</span></a>
//     </li>
//     <li class="nav-item">
//         <a class="nav-link" href="?page=koleksi">
//         <i class="fas fa-bookmark"></i>
//             <span>Koleksi</span></a>
//     </li>
// <?php
// }
// // ? >
// Nav Item - Tables
// <?php if ($_SESSION['user']['role'] != 'admin') { ? >
//     <li class="nav-item">
//         <a class="nav-link" href="?page=kategori">
//             <i class="fas fa-fw fa-table"></i>
//             <span>Kategori</span>
//         </a>
//     </li>
// <?php } ?>

<!-- Nav Item - Buku -->
<?php if ($_SESSION['user']['role'] != 'kasir') { ?>
    <li class="nav-item">
        <a class="nav-link" href="?page=barang">
            <i class="fas fa-book"></i>
            <span>Barang</span>
        </a>
    </li>
<?php } ?>


<!-- Nav Item - Laporan Peminjaman -->
<?php
// Hanya tampilkan untuk level admin
if ($_SESSION['user']['role'] == 'admin') {
    ?>
    <!-- Nav Item - Laporan Peminjaman -->
    <li class="nav-item">
        <a class="nav-link" href="?page=laporan_penjualan">
            <i class="fas fa-book"></i>
            <span>Laporan Penjualan</span></a>
    </li>
   
<?php
}
?>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
                <!-- <div class="text-light lead text-center" id="DisplayClock" class="clock" onload="showTime()"></div> -->
            </div>

           
        </ul>

     
        
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
           


                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow header-with-background-image">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                   
                   

                    <!-- Topbar Search -->
                    <form method="get" action="search.php" role="search" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">          
                            <input type="search" name="keyword" class="form-control bg-light border-0 small" placeholder="Cari buku Disini..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" value="search">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                     


                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small text-light"><?php echo $_SESSION['user']['nama'];?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/profile.jpg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="?page=profil">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                
                                <a class="dropdown-item" href="logout.php">
                                    <i class="fas fa-power-off fa-sm fa-fw mr-2 text-gray-400"></i>
                                     Logout
                                </a>
                               
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?php
                    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
                    if(file_exists($page . '.php')){
                        include $page . '.php';
                    }else{
                        include '404.php';
                    }?>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Taufiq kasir 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>