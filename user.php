<?php
// Sertakan file koneksi database

// Query untuk mengambil data pengguna berdasarkan perannya
$query_admin = "SELECT * FROM user WHERE role = 'admin'";
$result_admin = mysqli_query($koneksi, $query_admin);

$query_kasir = "SELECT * FROM user WHERE role = 'kasir'";
$result_kasir = mysqli_query($koneksi, $query_kasir);


?>

<?php
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo '<div class="alert alert-success" role="alert">Data berhasil dihapus.</div>';
    // Redirect ke halaman tanpa parameter URL setelah menampilkan pesan
    header("Refresh:2; url=index.php?page=user");
    exit();
} elseif (isset($_GET['error']) && $_GET['error'] == 1) {
    echo '<div class="alert alert-danger" role="alert">Terjadi kesalahan saat menghapus data.</div>';
    // Redirect ke halaman tanpa parameter URL setelah menampilkan pesan
    header("Refresh:2; url=index.php?page=user");
    exit();
}
?>
    
<!-- Tabel untuk admin -->
<div class="card">
    <div class="card-body"><div class="col-md-6">
    <h1 class="mt-4">Daftar Admin</h1>
    </div>
       
        <div class=" text-right">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                    + Data
                </button></div><br>
                     <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="exampleModalLabel">Tambah Data Petugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-left">
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
                                       
                                        <label>No. Telepon</label>
                                        <div class="form-group">
                                            <input type="text" name="no_telp" class="form-control form-control-user" placeholder="Masukkan No. Telepon" required>
                                        </div>
                                        
                                        <label>Username</label>
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user"
                                                id="InputUsername" placeholder="Masukkan Username" required>
                                        </div>
                                        <label>Password</label>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="InputPassword" 
                                                placeholder="Masukkan Password" required>
                                        </div>
                                        <div class="form-group">
        <label>Peran</label><br>
        <input type="radio" name="peran" value="kasir" checked> Kasir<br>
        <input type="radio" name="peran" value="admin"> Admin<br>
    </div>
                                        <br>
                                        <div class="form-group">

                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <button class="btn btn-primary" type="submit" name="register" value="register">Register</button>
                                        
                                        </div>
                                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 
                </div>
                </div>
            </div>
            </div>
           
        <div class="row">
            <div class="col-md-12">
            
                <table class="table table-bordered" id="adminTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <!-- <th>Password</th> -->
                            <th>No Telepon</th>
                            <th>Level</th>
                            <th>Aksi</th>
                            <!-- Tambahkan kolom lain sesuai kebutuhan -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php while ($row = mysqli_fetch_assoc($result_admin)) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $row['nama']; ?></td>
                                <td><?= $row['username']; ?></td>
                                <!-- <td>< ?= str_repeat('*', strlen($row['password'])); ?></td> -->
                                <td><?= $row['no_telp']; ?></td>
                                <td><?= $row['role']; ?></td>
                                <td class="col-md-2">
                                <a href="?page=user_ubah&&id=<?= $row['id_user']; ?>"><i class="fas fa-edit fa-lg"></i></a>
                                </td>


                                <!-- Tambahkan data lain sesuai kebutuhan -->
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<br>
<!-- Tabel untuk petugas -->
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h1 class="mt-4 ">Daftar Kasir</h1>
            </div>
            <div class="col-md-6 text-right">
                <!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                    + Data Petugas
                </button> -->
                <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="exampleModalLabel">Tambah Data Petugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-left">
                < ?php
                                       

                                       if(isset($_POST['register'])) {
                                           $nama = $_POST['nama'];
                                           $no_telp = $_POST['no_telp'];
                                           $username = $_POST['username'];
                                           $password = $_POST['password'];
                                           // Set the level directly to "peminjam"
                                           $level = "kasir";

                                           $insert = mysqli_query($koneksi, "INSERT INTO user(nama,no_telp,username,password,role) VALUES('$nama','$no_telp','$username','$password','$role')");

                                           if($insert) {
                                               echo '< script>alert("Selamat, register berhasil. Silahkan Login"); location.href="?page=user"</>';
                                           } else {
                                               echo '< script>alert("Register gagal, Silahkan ulangi kembali.");</>;';
                                           }
                                       }
                                       ?>
                                 <form method="post" class="user">
                                    <div class="form-group">
                                    <label>Nama</label>
                                            <input type="text" name="nama" class="form-control form-control-user" placeholder="Masukkan Nama Lengkap" required>
                                        </div>
                                        <label>Email</label>
                                        <div class="form-group">
                                            <input type="text" name="email" class="form-control form-control-user" placeholder="Masukkan Email" required>
                                        </div>
                                        <label>No. Telepon</label>
                                        <div class="form-group">
                                            <input type="text" name="no_telepon" class="form-control form-control-user" placeholder="Masukkan No. Telepon" required>
                                        </div>
                                        <label>Alamat</label>
                                        <div class="form-group">
                                            <textarea  name="alamat" rows="2" class="form-control form-control-user" placeholder="Masukkan Alamat" required></textarea>
                                        </div>
                                        <label>Username</label>
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user"
                                                id="InputUsername" placeholder="Masukkan Username" required>
                                        </div>
                                        <label>Password</label>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="InputPassword" 
                                                placeholder="Masukkan Password" required>
                                        </div>
                                        <br>
                                        <div class="form-group">

                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <button class="btn btn-primary" type="submit" name="register" value="register">Register</button>
                                        
                                        </div>
                                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 
                </div>
                </div>
            </div>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered" id="petugasTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <!-- <th>Password</th> -->
                            <th>No Telepon</th>
                            <th>Level</th>
                            <th>Aksi</th>
                            <!-- Tambahkan kolom lain sesuai kebutuhan -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php while ($row = mysqli_fetch_assoc($result_kasir)) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $row['nama']; ?></td>
                                <td><?= $row['username']; ?></td>
                                <!-- <td>< ?= str_repeat('*', strlen($row['password'])); ?></td> -->
                                <td><?= $row['no_telp']; ?></td>
                                <td><?= $row['role']; ?></td>
                                <td class="col-md-2">
                                    <a href="?page=user_ubah&&id=<?= $row['id_user']; ?>"><i class="fas fa-edit fa-lg"></i></a>
                                    <!-- <a onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" href="?page=user_hapus&&id=<?= $row['id_user']; ?>" ><i class="fas fa-trash fa-lg text-danger"></i></a> -->
                                </td>
                                <!-- Tambahkan data lain sesuai kebutuhan -->
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
