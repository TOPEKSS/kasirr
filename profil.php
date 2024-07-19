<style>
.gradient-custom {
/* fallback for old browsers */
background: #4e73df
}
</style>

    <div class="col-md-12">
  <div class="py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-lg-8 mb-4 mb-lg-0">
        <div class="card mb-4" style="border-radius: .5rem;">
          <div class="row g-0">
            <div class="col-md-4 gradient-custom text-center text-white"
              style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
              <?php
    // Periksa apakah foto profil pengguna telah diunggah
    if(isset($_SESSION['user']['nama_file']) && !empty($_SESSION['user']['nama_file'])) {
        // Tampilkan foto profil pengguna
        echo '<img src="' . $_SESSION['user']['path'] . '" alt="' . $_SESSION['user']['role'] . '" class="img-fluid my-5" style="width: 100px;" />';
        // Tampilkan tombol atau ikon untuk menghapus foto profil
        echo '<a href="hapus_foto.php" ><i class="fas fa-trash"></i></a>';
    } else {
        // Tampilkan gambar default jika foto profil belum diunggah
        echo '<img src="img/profile.jpg" alt="' . $_SESSION['user']['role'] . '" class="img-fluid my-5" style="width: 80px;" />';
    }
    ?>


              <h3><?php echo $_SESSION['user']['nama']; ?></h3>
              <p><?php echo $_SESSION['user']['role']; ?></p>
            <!-- Button trigger modal -->
            <!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
            + Foto
            </button> -->
            

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="exampleModalLabel">Tambah Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div id="pesan" class="alert alert-success" style="display:none;"></div>
                <?php
// Cek apakah tombol submit di klik
if(isset($_POST["submit"])) {
    // Cek apakah user ID tersedia dalam sesi dan memiliki nilai yang valid
    if (isset($_SESSION['user']['id_user']) && $_SESSION['user']['id_user'] != "") {
        // User ID valid, lanjutkan proses penyimpanan foto profil
        $id_user = $_SESSION['user']['id_user'];

        $targetDir = "foto_profil/"; // Direktori penyimpanan foto profil
        $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
        
        // Cek apakah file gambar atau bukan
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File adalah gambar - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File bukan gambar.";
            $uploadOk = 0;
        }

        // Cek apakah file sudah ada
        if (file_exists($targetFile)) {
            echo "Maaf, file sudah ada.";
            $uploadOk = 0;
        }

        // Izinkan format file tertentu
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Maaf, hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
            $uploadOk = 0;
        }

        // Cek jika $uploadOk bernilai 0
        if ($uploadOk == 0) {
            echo "Maaf, file tidak terunggah.";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                echo "File ". basename( $_FILES["fileToUpload"]["name"]). " telah berhasil terunggah.";
                
                // Simpan informasi file ke dalam sesi
                $_SESSION['user']['nama_file'] = basename($_FILES["fileToUpload"]["name"]);
                $_SESSION['user']['path'] = $targetFile;
                
                // Simpan informasi file ke database
                // Misalnya, Anda bisa menyimpan nama file dan path-nya ke dalam tabel foto_profil, serta id_user yang terkait.
                $nama_file = basename($_FILES["fileToUpload"]["name"]);
                $path = $targetFile;
                
                // Query untuk menyimpan informasi foto profil ke dalam tabel foto_profil
                $insert_foto = mysqli_query($koneksi, "INSERT INTO foto_profil (nama_file, path, id_user) VALUES ('$nama_file', '$path', '$id_user')");
                
                if($insert_foto) {
                    echo '<script>tampilkanPesan("Foto profil berhasil disimpan di database.");</script>';
                } else {
                    echo '<script>tampilkanPesan("Gagal menyimpan informasi foto profil di database.");</script>';
                }
            } else {
                echo "Maaf, terjadi kesalahan saat unggah file.";
            }
        }
    } else {
        echo "Maaf, id_user tidak valid.";
    }
}
?>


              <form method="post" enctype="multipart/form-data">
                  <div class="mb-3">
                      <label for="fileInput" class="form-label">Pilih Foto</label>
                      <input type="file" class="form-control" id="fileToUpload" name="fileToUpload">
                  </div>
                  <button type="submit" name="submit" class="btn btn-primary">Unggah</button>
              </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 
                </div>
                </div>
            </div>
            </div>
              
             
            </div>  
           

            <div class="col-md-8">
              <div class="card-body p-4">
                <h6>Information</h6>
                <hr class="mt-0 mb-4">
                <div class="row pt-1">
                  <!-- <div class="col-6 mb-3">
                    <h6>Email :</h6>
                    <p class="text-muted"><?php echo $_SESSION['user']['email']; ?></p>
                  </div> -->
                  <div class="col-6 mb-3">
                    <h6>Phone:</h6>
                    <p class="text-muted"><?php echo $_SESSION['user']['no_telp']; ?></p>
                  </div>
                </div>
                <h6>Projects</h6>
                <hr class="mt-0 mb-4">
                <div class="row pt-1">
                  <!-- <div class="col-6 mb-3">
                    <h6>Alamat :</h6>
                    <p class="text-muted"><?php echo $_SESSION['user']['alamat']; ?></p>
                  </div> -->
                  <div class="col-6 mb-3">
                    <h6>Tanggal Login :</h6>
                    <p class="text-muted"><?php echo date('d-m-Y'); ?></p>
                  </div>
                </div>
                <div class="d-flex justify-content-start">
                  <a href="index.php" class="btn btn-danger me-3 col-3 ">Kembali</a>
                  <a href="#!"><i class="fab fa-facebook-f fa-lg me-3 col-6 "></i></a>
                  <a href="#!"><i class="fab fa-twitter fa-lg me-3 col-6 "></i></a>
                  <a href="#!"><i class="fab fa-instagram fa-lg col-6 "></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  
 
 