<?php
include 'koneksi.php';


// Pastikan parameter id_order tersedia
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Alihkan jika parameter tidak valid
    header("Location: index.php");
    exit;
}

$id_order = $_GET['id'];

$tanggal_beli = date('Y-m-d H:i:s');

// Query untuk mendapatkan detail pesanan
$query_order_detail = "SELECT * FROM orders WHERE id_order = $id_order";
$result_order_detail = mysqli_query($koneksi, $query_order_detail);

if (mysqli_num_rows($result_order_detail) > 0) {
    $row_order_detail = mysqli_fetch_assoc($result_order_detail);
    // Ambil data detail pesanan
    $tanggal_beli = $row_order_detail['tanggal_beli'];
    $nama_pelanggan = $row_order_detail['nama_pelanggan'];
    $total_harga = $row_order_detail['total_harga'];
    $bayar = $row_order_detail['bayar'];
    $kembalian = $row_order_detail['kembalian'];

    // Format nilai uang
    $total_harga_formatted = "Rp " . number_format($total_harga, 0, ',', '.');
    $bayar_formatted = "Rp " . number_format($bayar, 0, ',', '.');
    $kembalian_formatted = "Rp " . number_format($kembalian, 0, ',', '.');
} else {
    // Alihkan jika pesanan tidak ditemukan
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
        }

        .button-container {
            margin-top: 20px;
            text-align: center;
        }

        button {
            padding: 10px 20px;
            margin: 0 5px;
            cursor: pointer;
        }

        button.print {
            background-color: #4caf50;
            color: white;
            border: none;
        }

        button.print:hover {
            background-color: #45a049;
        }

        button.back {
            background-color: #f44336;
            color: white;
            border: none;
        }

        button.back:hover {
            background-color: #da190b;
        }

        @media print {
            .button-container {
                display: none;
            }
        }
    </style>
</head>

<body>
    <h1 style="text-align:center;">MidLane Cafe</h1>
    <h2 style="text-align:center;">Detail Pesanan</h2>

    <p>Kasir: <?php echo $_SESSION['user']['nama']; ?></p>
    <p>Nama Pelanggan: <?php echo $nama_pelanggan; ?></p>
    <p>Tanggal Beli: <?php echo $tanggal_beli; ?></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query untuk mendapatkan detail item yang dipesan
            $query_detail_order = "SELECT barang.nama, detail_order.jumlah, detail_order.subtotal 
                                   FROM detail_order 
                                   INNER JOIN barang ON detail_order.id_barang = barang.id_barang 
                                   WHERE detail_order.id_order = $id_order";
            $result_order_items = mysqli_query($koneksi, $query_detail_order);

            $nomor_urut = 1;

            if (mysqli_num_rows($result_order_items) > 0) {
                while ($row = mysqli_fetch_assoc($result_order_items)) {
                    $nama_barang = $row['nama'];
                    $jumlah = $row['jumlah'];
                    $subtotal = $row['subtotal'];
                    $subtotal_formatted = "Rp " . number_format($subtotal, 0, ',', '.');
            ?>
                    <tr>
                        <td><?php echo $nomor_urut; ?></td>
                        <td><?php echo $nama_barang; ?></td>
                        <td><?php echo $jumlah; ?></td>
                        <td><?php echo $subtotal_formatted; ?></td>
                    </tr>
                <?php
                    $nomor_urut++;
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada item yang dipesan</td></tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr class="total">
                <td colspan="3">Total Harga:</td>
                <td><?php echo $total_harga_formatted; ?></td>
            </tr>
            <tr class="total">
                <td colspan="3">Bayar:</td>
                <td><?php echo $bayar_formatted; ?></td>
            </tr>
            <tr class="total">
                <td colspan="3">Kembali:</td>
                <td><?php echo $kembalian_formatted; ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="button-container">
        <button class="print" onclick="window.print()">Cetak</button>
        <button class="back" onclick="back()">Kembali</button>
    </div>

    <script>
        function back() {
            window.location.href = 'index.php';
        }
    </script>

</body>

</html>
