<?php
// Pastikan sesi dimulai jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user'])) {
    // Jika tidak ada sesi pengguna, arahkan ke halaman login atau tampilkan pesan error
    header("Location: login.php");
    exit;
}

// Ambil ID pengguna dari sesi
$id_user = $_SESSION['user']['id_user'];

// Sambungkan ke database
include 'koneksi.php';

// Periksa apakah pesanan dibatalkan
if (isset($_GET['cancel']) && $_GET['cancel'] === 'true') {
    // Hapus data keranjang
    $query_clear_cart = "DELETE FROM keranjang WHERE id_user = $id_user";
    mysqli_query($koneksi, $query_clear_cart);
}

// Periksa apakah metode permintaan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah ID barang telah diterima dari permintaan POST
    if (isset($_POST['id_barang'])) {
        // Tangkap ID barang dari permintaan POST
        $id_barang = $_POST['id_barang'];

        // Query untuk memeriksa apakah barang sudah ada di keranjang
        $check_cart_query = "SELECT * FROM keranjang WHERE id_barang = $id_barang AND id_user = $id_user";
        $check_cart_result = mysqli_query($koneksi, $check_cart_query);

        // Jika barang sudah ada di keranjang
        if (mysqli_num_rows($check_cart_result) > 0) {
            echo '<script>alert("Item sudah ada di keranjang, silahkan anda checkout.");</script>';
        } else {
            // Query untuk mendapatkan detail barang berdasarkan ID
            $query_barang = "SELECT * FROM barang WHERE id_barang = $id_barang";
            $result_barang = mysqli_query($koneksi, $query_barang);

            // Periksa apakah barang dengan ID yang diberikan ada dalam database
            if (mysqli_num_rows($result_barang) > 0) {
                // Ambil data barang dari hasil query
                $barang = mysqli_fetch_assoc($result_barang);

                // Masukkan barang ke dalam tabel keranjang
                $insert_query = "INSERT INTO keranjang (id_barang, id_user, jumlah, sub_total) 
                                 VALUES ($id_barang, $id_user, 1, {$barang['harga']})";
                $result_insert = mysqli_query($koneksi, $insert_query);

                if ($result_insert) {
                    // Barang berhasil ditambahkan ke keranjang, arahkan pengguna kembali ke halaman yang sama
                    header("Location: ".$_SERVER['PHP_SELF']);
                    exit;
                } else {
                    // Gagal menambahkan barang ke keranjang, tampilkan pesan
                    echo '<script>alert("Gagal menambahkan barang ke keranjang.");</script>';
                }
            } else {
                // Barang tidak ditemukan dalam database, tampilkan pesan
                echo '<script>alert("Barang tidak ditemukan dalam database.");</script>';
            }
        }
    }
}

// Query untuk menghitung jumlah item di keranjang
$query_count = "SELECT COUNT(*) AS total FROM keranjang WHERE id_user = $id_user";
$result_count = mysqli_query($koneksi, $query_count);

// Periksa apakah query berhasil dieksekusi
if ($result_count) {
    // Ambil hasil query
    $row_count = mysqli_fetch_assoc($result_count);
    
    // Tampilkan jumlah item di keranjang
    $total_item_keranjang = $row_count['total'];
} else {
    // Jika query gagal, tampilkan pesan error
    echo "Gagal mengambil data keranjang.";
}
?>

<!-- Content Row -->
<div class="row">
    <!-- Semua kategori ini muncul pada Dashboard admin saja -->
    <!-- dengan session din=bawah ini -->
    <?php if ($_SESSION['user']['role'] != 'kasir') { ?>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                <?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kategori")); ?>&nbsp;
                                Total Kategori</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-table fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                <?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang")); ?>&nbsp;
                                Total Barang</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                <?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM orders")); ?>&nbsp;
                                Total Penjualan</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto"></div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comment fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                <?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user")); ?>&nbsp;
                                Total User</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="card col-xl-12 col-md-6 mb-4">
        <div class="card-body">
            <h2 class="mt-4">Daftar barang :</h2>
            <div class="col-xl-12 col-md-6 mb-4 text-right">
                <!-- Tombol "Checkout" dengan jumlah item di keranjang -->
                <a href="?page=checkout" type="button" class="checkout-btn btn-danger btn-lg fas fa-shopping-cart" onclick="checkout()">
                    Checkout (<?= $total_item_keranjang ?> items)
                </a>
            </div>
            <hr>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php
                // Query untuk mendapatkan data-data buku dari tabel "buku"
                $books_query = "SELECT * FROM barang LEFT JOIN kategori ON barang.id_kategori = kategori.id_kategori";
                $books_result = mysqli_query($koneksi, $books_query);

                // Loop untuk menampilkan data-data buku dalam bentuk kartu
                while ($data = mysqli_fetch_array($books_result)) {
                ?>
                    <div class="col">
                        <div class="card h-100">
                            <img src="gambaran/<?php echo isset($data['gambar']) && $data['gambar'] !== '' ? $data['gambar'] : 'default.jpg'; ?>" class="card-img-top" alt="..." height="350px">
                            <div class="card-body">
                                <h5 class="card-title text-center"><b><?php echo isset($data["nama"]) ? $data["nama"] : ''; ?></b></h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Kategori : <?php echo $data["kategori"]; ?></li>
                                <li class="list-group-item">Harga : <?php echo 'Rp ' . number_format($data['harga'], 0, ',', '.'); ?></li>
                                <li class="list-group-item">Stok : <?php echo $data["stok"]; ?></li>
                            </ul>
                            <div class="card-body">
                                <!-- Tombol "Keranjang" pada setiap item -->
                                <form method="post">
                                    <input type="hidden" name="id_barang" value="<?php echo $data['id_barang']; ?>">
                                    <!-- Tombol "Keranjang" -->
                                    <button type="submit" class="add-to-cart-btn btn-lg btn-primary">+ Keranjang</button>
                                </form>     
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>  
        </div>
    </div>
    <br>
    <div class="card col-xl-12 col-md-6 mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <td width="200">Nama</td>
                    <td width="1">:</td>
                    <td><?php echo $_SESSION['user']['nama']; ?></td>
                </tr>
                <tr>
                    <td width="200">Level User</td>
                    <td width="1">:</td>
                    <td><?php echo $_SESSION['user']['role']; ?></td>
                </tr>
                <tr>
                    <td width="200">Tanggal Login</td>
                    <td width="1">:</td>
                    <td><?php echo date('d-m-Y'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>