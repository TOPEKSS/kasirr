<h1 class="mt-4">Barang</h1><br>
<div class="card">
    <div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <form method="post"  enctype="multipart/form-data">
            <?php
          
           $id = $_GET['id'];
           if(isset($_POST['submit'])) {
               $id_kategori = $_POST['id_kategori'];
               $nama = $_POST['nama'];
               $harga = $_POST['harga'];
               $stok = $_POST['stok'];
               $gambar = $_FILES['gambar']['name'];
               $image_tmp = $_FILES['gambar']['tmp_name'];

               move_uploaded_file($image_tmp,"gambaran/$gambar");
               // Perbaikan sintaks SQL di sini:
               $query = mysqli_query($koneksi, "UPDATE barang SET id_kategori='$id_kategori', nama='$nama', harga='$harga', stok='$stok', gambar='$gambar' WHERE id_barang=$id");
           
               if($query) {
                   echo '<script>alert("Ubah Data Berhasil.");location.href = "index.php?page=barang";</script>';
               }else{
                   echo '<script>alert("Ubah Data Gagal.");</script>';
               }
           }
           $query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang=$id");
           $data = mysqli_fetch_array($query);
           ?>
           

                <div class="row mb-3">
                    <div class="col-md-2">Nama Kategori :</div>
                    <div class="col-md-6">
                        <select name="id_kategori" class="form-control">
                            <?php
                            $kat = mysqli_query($koneksi, "SELECT*FROM kategori");
                            while($kategori = mysqli_fetch_array($kat)) {
                                ?>
                                <option <?php if($kategori['id_kategori'] == $data['id_kategori']) echo 'selected';?> value="<?php echo $kategori['id_kategori']; ?>"><?php echo $kategori['kategori'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-2">Nama Barang :</div>
                    <div class="col-md-6"><input class="form-control" type="text" value="<?php echo $data['nama']; ?>" name="nama"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-2">Harga :</div>
                    <div class="col-md-6"><input class="form-control" type="text"  value="<?php echo $data['harga']; ?>" name="harga"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-2">Stok :</div>
                    <div class="col-md-6"><input class="form-control" type="text"  value="<?php echo $data['stok']; ?>"  name="stok"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-2">Foto :</div>
                    <div class="col-md-6">
                        <img src="gambaran/<?php echo $data['gambar']; ?>" width="80px" height="80px">
                        <input class="form-control" type="file" name="gambar">
                    </div>
                </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <button type="submit" class="btn btn-primary" name="submit" value="submit">Simpan</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <a href="?page=barang" class="btn btn-danger">Kembali</a>
                </div>
            </div>
            </form>
    </div>
</div>
    </div>
</div>