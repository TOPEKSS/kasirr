<?php
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>REGISTER |  KE PERPUSTAKAAN DIGITAL</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head> 

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                        <div class="col-lg-6 d-none d-lg-block">
                            <img src="img/images.png" width="500" height="500" alt="">
                        </div>

                            <div class="col-lg-6">  
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Register Peminjam Perpustakaan Digital</h1>
                                    </div>
                                     <?php
                                        
                                        if(isset($_POST['register'])) {
                                            $nama = $_POST['nama'];
                                            $no_telp = $_POST['no_telp'];
                                            $username = $_POST['username'];
                                            $password = $_POST['password'];
                                            $role = $_POST['peran']; // Ambil nilai peran dari form
                                        
                                            $insert = mysqli_query($koneksi, "INSERT INTO user(nama,no_telp,username,password,role) VALUES('$nama','$no_telp','$username','$password','$role')");
                                        
                                            if($insert) {
                                                echo '<script>alert("Selamat, register berhasil. Silahkan Login"); location.href="login.php"</script>';
                                            } else {
                                                echo '<script>alert("Register gagal, Silahkan ulangi kembali.");</script>';
                                                echo "Error: " . mysqli_error($koneksi);
                                            }
                                        }
                                        
                                               ?>

<form method="post" class="user">
    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control form-control-user" placeholder="Masukkan Nama Lengkap" required>
    </div> 
    <div class="form-group">
        <label>No. Telepon</label>
        <input type="text" name="no_telp" class="form-control form-control-user" placeholder="Masukkan No. Telepon" required>
    </div>
    <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" class="form-control form-control-user" id="InputUsername" placeholder="Masukkan Username" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control form-control-user" id="InputPassword" placeholder="Masukkan Password" required>
    </div>
    <div class="form-group">
        <label>Peran</label><br>
        <input type="radio" name="peran" value="kasir" checked> Kasir<br>
        <input type="radio" name="peran" value="admin"> Admin<br>
    </div>
    <br>
    <div class="form-group">
        <button class="btn btn-primary" type="submit" name="register" value="register">Register</button>
    </div>
</form>

                                    <hr>
                                    <span>Jika Anda sudah punya akun, <a href="login.php">klik disini</a>.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>