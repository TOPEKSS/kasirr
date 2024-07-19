<h1 class="mt-4">Barang</h1><br>
<div class="card">
    <div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <form method="post" enctype="multipart/form-data">

            <?php
            if(isset($_POST['submit'])) {
                $id_kategori = $_POST['id_kategori'];
                $nama = $_POST['nama'];
                $harga = $_POST['harga'];
                $stok = $_POST['stok'];
                $gambar = $_FILES['gambar']['name'];
                $image_tmp = $_FILES['gambar']['tmp_name'];

                move_uploaded_file($image_tmp,"gambaran/$gambar");

                $query = mysqli_query($koneksi, "INSERT INTO barang(id_kategori,nama,harga,stok,gambar) values('$id_kategori','$nama','$harga','$stok','$gambar')");

                if($query) {
                    echo '<script>alert("Tambah Data Berhasil.");location.href = "index.php?page=barang";</script>';
                }else{
                    echo '<script>alert("Tambah Data Gagal.");</script>';
                }
            }

               
            ?>
                <div class="row mb-3">
                    <div class="col-md-2">Nama Kategori :</div>
                    <div class="col-md-6">
                        <select name="id_kategori" class="form-control">
                            <?php
                            $kat = mysqli_query($koneksi, "SELECT*FROM kategori");
                            while($kategori = mysqli_fetch_array($kat)) {
                                ?>
                                <option value="<?php echo $kategori['id_kategori']; ?>"><?php echo $kategori['kategori'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-2">Nama Barang:</div>
                    <div class="col-md-6"><input class="form-control" type="text" name="nama"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-2">Harga :</div>
                    <div class="col-md-6"><input class="form-control" type="text" name="harga"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-2">Stok :</div>
                    <div class="col-md-6"><input class="form-control" type="text" name="stok"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-2">Foto :</div> 
                    <div class="col-md-6"><input type="file" id="formFileMultiple" name="gambar"><br><br></div>
                     
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