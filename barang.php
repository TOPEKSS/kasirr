

<div class="col-md-6">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                    + Kategori
                   
                </button>
                <a href="?page=barang_tambah" class="btn btn-success"><i class="fa fa-plus"></i>Tambah Barang</a>

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
                                           $kategori = $_POST['kategori'];
                                           $insert = mysqli_query($koneksi, "INSERT INTO kategori(kategori) VALUES('$kategori')");

                                           if($insert) {
                                               echo '<script>alert("Selamat, Kategori berhasil. Silahkan Login"); location.href="?page=user"</script>';
                                           } else {
                                               echo '<script>alert("Kategori gagal, Silahkan ulangi kembali.");</script>;';
                                           }
                                       }
                                       ?>
                                 <form method="post" class="user">
                                    <div class="form-group">
                                        <label>Nama Kategori:</label>
                                            <input type="text" name="kategori" class="form-control form-control-user" placeholder="Masukkan Kategori" required>
                                        </div>
                                       
                                        <br>
                                        <div class="form-group">

                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <button class="btn btn-primary" type="submit" name="register" value="register">tambah</button>
                                        
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



               

<div class="card">
    <div class="card-body">
    <h1 class="mt-4">Barang</h1>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Image</th>
                <th>Aksi</th>
            </tr>
            <?php
            $i = 1;
            $query = mysqli_query($koneksi, "SELECT*FROM barang LEFT JOIN kategori on barang.id_kategori = kategori.id_kategori");
            while($data = mysqli_fetch_array($query)){
                ?>
                <tr>
                    <td><?php echo $i++;?></td>
                    <td><?php echo $data['kategori']; ?></td>
                    <td><?php echo $data['nama']; ?></td>
                    <td><?php echo $data['harga']; ?></td>
                    <td><?php echo $data['stok']; ?></td>
                    <td><img width="200" heighth="500" src="gambaran/<?php echo $data['gambar']; ?>"></td>
                    <td class="col-md-2">
                        <a href="?page=barang_ubah&&id=<?php echo $data['id_barang']; ?>" class="btn btn-info">Ubah</a>
                        <a onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" href="?page=barang_hapus&&id=<?php echo $data['id_barang']; ?>" class="btn btn-danger">Hapus</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
</div>
    </div>
</div>


            