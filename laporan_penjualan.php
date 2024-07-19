<?php
include 'koneksi.php';

// Query untuk mengambil data pesanan
$query_orders = "
    SELECT 
        orders.id_order, 
        orders.tanggal_beli, 
        orders.nama_pelanggan, 
        orders.total_harga, 
        orders.kembalian,
        user.nama as nama_petugas
    FROM 
        orders
    INNER JOIN 
        user ON orders.id_user = user.id_user";

$result_orders = mysqli_query($koneksi, $query_orders);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
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
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        button.print:hover {
            background-color: #45a049;
        }

        @media print {
            .button-container {
                display: none;
            }
        }
    </style>
</head>

<body>
    <h1>Laporan Penjualan</h1>

    <table>
        <thead>
            <tr>
                <th>ID Order</th>
                <th>Tanggal Beli</th>
                <th>Nama Pelanggan</th>
                <th>Nama Petugas</th>
                <th>Total Harga</th>
                <th>Kembalian</th>
                <th>Detail Item</th>
                <th>Cetak</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result_orders) > 0) {
                while ($row_order = mysqli_fetch_assoc($result_orders)) {
                    $id_order = $row_order['id_order'];
                    $tanggal_beli = $row_order['tanggal_beli'];
                    $nama_pelanggan = $row_order['nama_pelanggan'];
                    $nama_petugas = $row_order['nama_petugas'];
                    $total_harga = $row_order['total_harga'];
                    $kembalian = $row_order['kembalian'];

                    $total_harga_formatted = "Rp " . number_format($total_harga, 0, ',', '.');
                    $kembalian_formatted = "Rp " . number_format($kembalian, 0, ',', '.');

                    // Query untuk mendapatkan detail item yang dipesan
                    $query_detail_order = "
                        SELECT 
                            barang.nama, 
                            detail_order.jumlah, 
                            detail_order.subtotal 
                        FROM 
                            detail_order 
                        INNER JOIN 
                            barang ON detail_order.id_barang = barang.id_barang 
                        WHERE 
                            detail_order.id_order = $id_order";
                    $result_detail_order = mysqli_query($koneksi, $query_detail_order);
                    ?>
                    <tr>
                        <td><?php echo $id_order; ?></td>
                        <td><?php echo $tanggal_beli; ?></td>
                        <td><?php echo $nama_pelanggan; ?></td>
                        <td><?php echo $nama_petugas; ?></td>
                        <td><?php echo $total_harga_formatted; ?></td>
                        <td><?php echo $kembalian_formatted; ?></td>
                        <td>
                            <ul>
                                <?php
                                if (mysqli_num_rows($result_detail_order) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_detail_order)) {
                                        $nama_barang = $row['nama'];
                                        $jumlah = $row['jumlah'];
                                        $subtotal = $row['subtotal'];
                                        $subtotal_formatted = "Rp " . number_format($subtotal, 0, ',', '.');
                                        echo "<li>$nama_barang - $jumlah pcs - $subtotal_formatted</li>";
                                    }
                                } else {
                                    echo "<li>Tidak ada item yang dipesan</li>";
                                }
                                ?>
                            </ul>
                        </td>
                        <td><a href="?page=cetak_detail_order&&id=<?php echo $id_order; ?>" target="_blank">Cetak</a></td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='8'>Tidak ada data penjualan</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="button-container">
        <button class="print" onclick="window.print()">Cetak Laporan</button>
    </div>
</body>

</html>
