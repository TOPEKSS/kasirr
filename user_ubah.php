<h1 class="mt-4">Ubah Data User</h1><br>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <?php
                // Ambil ID pengguna dari URL
                $id = $_GET['id'];

                // Ambil data pengguna dari database berdasarkan ID
                $query = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = $id");
                $user = mysqli_fetch_assoc($query);

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Proses pembaruan data pengguna
                    // Ambil data yang dikirim dari formulir
                    $nama = $_POST['nama'];
                    $no_telp = $_POST['no_telp'];

                    // Lakukan pembaruan data pengguna di database
                    $update_query = "UPDATE user SET nama = '$nama', no_telp = '$no_telp' WHERE id_user = $id";
                    $result = mysqli_query($koneksi, $update_query);

                    if ($result) {
                        // Jika pembaruan berhasil, tampilkan pesan sukses
                        echo '<div class="alert alert-success" role="alert">Data pengguna berhasil diperbarui.</div>';
                        // Redirect ke halaman user.php setelah 1 detik
                        header("refresh:1; url=?page=user");
                        exit(); // Penting: pastikan tidak ada output sebelum header()
                    } else {
                        // Jika terjadi kesalahan saat pembaruan, tampilkan pesan kesalahan
                        echo '<div class="alert alert-danger" role="alert">Gagal memperbarui data pengguna. Silakan coba lagi.</div>';
                    }
                }
                ?>


<!-- Tampilkan formulir pengeditan -->
<form method="POST" action="">
    <div class="form-group row">
        <label for="nama" class="col-md-2 col-form-label">Nama:</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="nama" name="nama" value="<?= $user['nama']; ?>">
        </div>
    </div>
   
   
    <div class="form-group row">
        <label for="no_telepon" class="col-md-2 col-form-label">No Telepon:</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= $user['no_telp']; ?>">
        </div>
    </div>
  
    <div class="form-group row">
        <div class="col-md-10 offset-md-2">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="?page=user" class="btn btn-danger">Kembali</a>
        </div>
    </div>
</form>


    </div>
</div>
    </div>
</div>