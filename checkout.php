<?php
include 'koneksi.php';

// Proses checkout saat tombol checkout ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checkout'])) {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $jumlah_bayar = (float)$_POST['jumlah_bayar']; // Pastikan jumlah_bayar adalah float
    $tanggal_beli = date('Y-m-d');
    $id_user = $_SESSION['user']['id_user'];

    // Hitung total harga belanjaan
    $total_harga = 0;
    $query_keranjang = "SELECT * FROM keranjang";
    $result_keranjang = mysqli_query($koneksi, $query_keranjang);
    while ($row = mysqli_fetch_assoc($result_keranjang)) {
        $total_harga += $row['sub_total'];
    }

    // Hitung kembalian
    $kembalian = $jumlah_bayar - $total_harga;

    // Masukkan data pemesanan ke dalam tabel order
    $query_order = "INSERT INTO `orders` (nama_pelanggan, tanggal_beli, bayar, kembalian, id_user, total_harga) 
                    VALUES ('$nama_pelanggan', '$tanggal_beli', '$jumlah_bayar', '$kembalian', '$id_user', '$total_harga')";
    $result_order = mysqli_query($koneksi, $query_order);

    if ($result_order) {
        $id_order = mysqli_insert_id($koneksi);

        // Masukkan detail pesanan ke dalam tabel order_detail
        $query_keranjang = "SELECT * FROM keranjang";
        $result_keranjang = mysqli_query($koneksi, $query_keranjang);
        while ($row = mysqli_fetch_assoc($result_keranjang)) {
            $id_barang = $row['id_barang'];
            $jumlah = $row['jumlah'];
            $subtotal = $row['sub_total'];
            $query_order_detail = "INSERT INTO detail_order (id_order, id_barang, jumlah, subtotal) VALUES ('$id_order', '$id_barang', '$jumlah', '$subtotal')";
            mysqli_query($koneksi, $query_order_detail);
        }

        // Kosongkan keranjang setelah pemesanan berhasil
        $query_clear_cart = "DELETE FROM keranjang";
        mysqli_query($koneksi, $query_clear_cart);

        // Alihkan ke halaman detail order dengan menyertakan id order sebagai parameter
        header("Location: ?page=detail_order&id=$id_order");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

// Fungsi untuk mengkonfirmasi pembatalan pesanan
function confirmCancelOrder() {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel'])) {
        echo '<script>';
        echo 'if(confirm("Apakah Anda yakin ingin membatalkan pesanan?")) {';
        echo 'return true;';
        echo '} else {';
        echo 'return false;';
        echo '}';
        echo '</script>';
    }
}

// Fungsi untuk menghapus item pesanan dari keranjang
function deleteCartItem($id_keranjang) {
    global $koneksi;
    $query_delete_item = "DELETE FROM keranjang WHERE id_keranjang = '$id_keranjang'";
    mysqli_query($koneksi, $query_delete_item);
}

// Pengecekan apakah tombol "Hapus" ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['hapus'])) {
    $id_keranjang_to_delete = $_POST['hapus'];
    deleteCartItem($id_keranjang_to_delete);
}

// Inisialisasi variabel jumlah bayar dan kembalian
$jumlah_bayar = 0;
$kembalian = 0;

// Query untuk menghitung total harga dari semua item di keranjang
$query_total_harga = "SELECT SUM(sub_total) AS total_harga FROM keranjang";
$result_total_harga = mysqli_query($koneksi, $query_total_harga);

if ($result_total_harga) {
    $row_total_harga = mysqli_fetch_assoc($result_total_harga);
    $total_harga = $row_total_harga['total_harga'];
} else {
    $total_harga = 0; // Atur nilai default jika query gagal
}


?>

<!-- Formulir untuk checkout -->
<form method="post" id="checkoutForm">
    <div class="form-group">
        <label for="nama_pelanggan">Nama Pelanggan:</label>
        <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" required>
    </div>
    <div class="form-group">
        <label for="jumlah_bayar">Jumlah Bayar (Rp):</label>
        <input type="number" class="form-control" id="jumlah_bayar" name="jumlah_bayar" required>
    </div>
    <!-- Tampilkan kembalian -->
    <div class="form-group">
        <label for="kembalian">Kembalian (Rp):</label>
        <input type="text" class="form-control" id="kembalian" name="kembalian" readonly>
    </div>
    <button type="submit" class="btn btn-primary" name="checkout">Proses Pemesanan</button>
    
</form>

<!-- Daftar barang di keranjang -->
<table class="table">
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Subtotal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php
$query_keranjang = "SELECT keranjang.id_keranjang, barang.nama, barang.stok, keranjang.jumlah, barang.harga, (keranjang.jumlah * barang.harga) AS subtotal FROM keranjang INNER JOIN barang ON keranjang.id_barang = barang.id_barang";
$result_keranjang = mysqli_query($koneksi, $query_keranjang);

if (mysqli_num_rows($result_keranjang) > 0) {
    while ($row = mysqli_fetch_assoc($result_keranjang)) {
        $id_keranjang = $row['id_keranjang'];
        $nama = $row['nama'];
        $stok = $row['stok']; // Ambil stok barang
        $jumlah = $row['jumlah'];
        $harga = $row['harga'];
        $subtotal = $row['subtotal'];

        // Tambahkan validasi stok di sini
        $disabled = $stok == 0 ? 'disabled' : '';
         // Jika stok habis, tombol akan dinonaktifkan
?>
        <tr>
            <td><?php echo $nama; ?></td>
            <td>
                <div class="quantity" style="margin-top:20px;">
                    <?php if ($jumlah > 0) : ?>
                        <button class="quantity-btn minus" style="background-color: #dc3545;" data-id="<?php echo $id_keranjang; ?>">-</button>
                        <span class="quantity-value" data-id="<?php echo $id_keranjang; ?>"><?php echo $jumlah; ?></span>
                        <button class="quantity-btn plus" style='background-color: #28a745;' data-id="<?php echo $id_keranjang; ?>" <?php echo $disabled; ?>>+</button>
                    <?php else : ?>
                        <span class="text-danger">Stok Habis</span>
                    <?php endif; ?>
                </div>
            </td>
            <td>Rp <?php echo number_format($harga, 0, ',', '.'); ?></td>
            <td id="subtotal_<?php echo $id_keranjang; ?>">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
            <td>
                <form method="post">
                    <button type="submit" class="btn btn-sm btn-danger" name="hapus" value="<?php echo $id_keranjang; ?>">Hapus</button>
                </form>
            </td>
        </tr>
<?php
    }
} else {
    echo '<tr><td colspan="5">Keranjang kosong</td></tr>';
}
?>

    </tbody>
</table>

<h5 class="text-right" id="total_harga">Total Harga: Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></h5>

<button type="button" class="btn btn-danger" name="cancel" onclick="confirmCancellation()">Batalkan Pesanan</button>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var totalHarga = <?php echo $total_harga; ?>;

        function calculateKembalian() {
            var jumlahBayar = parseFloat($('#jumlah_bayar').val());
            var kembalian = jumlahBayar - totalHarga;
            if (Number.isInteger(kembalian)) {
                $('#kembalian').val(kembalian.toFixed(0)); // Tanpa desimal jika kembalian adalah bilangan bulat
            } else {
                $('#kembalian').val(kembalian.toFixed(2)); // Dengan desimal jika kembalian bukan bilangan bulat
            }
        }

        $('#jumlah_bayar').on('input', calculateKembalian);

        $('.quantity-btn').click(function() {
            var idBarang = $(this).data('id');
            var action = $(this).hasClass('plus') ? 'increment' : 'decrement';
            edit(action, idBarang);
        });

        function edit(action, idBarang) {
            $.ajax({
                url: 'update_quantity.php',
                method: 'POST',
                data: {
                    action: action,
                    id_barang: idBarang
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    $('.quantity-value[data-id="' + idBarang + '"]').text(data.jumlah);
                    $('#subtotal_' + idBarang).text('Rp ' + data.subtotal);
                    totalHarga = parseFloat(data.total_harga.replace(/,/g, ''));
                    $('#total_harga').text('Total Harga: Rp ' + data.total_harga);
                    calculateKembalian();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        <?php confirmCancelOrder(); ?>
    });

    function confirmCancelOrder() {
        return confirm("Apakah Anda yakin ingin membatalkan pesanan?");
    }

    function confirmCancellation() {
        if (confirmCancelOrder()) {
            window.location.href = '?page=home&cancel=true'; // Arahkan ke dashboard dengan parameter cancel
        }
    }

    $(document).ready(function() {
        var totalHarga = <?php echo $total_harga; ?>;
        // ...
        // Bagian lain dari skrip JavaScript
        // ...
    });
</script>

