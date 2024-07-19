<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_barang = $_POST['id_barang'];
    $action = $_POST['action'];

    $query = "SELECT keranjang.jumlah, barang.harga FROM keranjang INNER JOIN barang ON keranjang.id_barang = barang.id_barang WHERE keranjang.id_keranjang = '$id_barang'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $jumlah = $row['jumlah'];
        $harga = $row['harga'];

        if ($action == 'increment') {
            $jumlah++;
        } elseif ($action == 'decrement' && $jumlah > 1) {
            $jumlah--;
        }

        $subtotal = $jumlah * $harga;

        $query_update = "UPDATE keranjang SET jumlah = '$jumlah', sub_total = '$subtotal' WHERE id_keranjang = '$id_barang'";
        mysqli_query($koneksi, $query_update);

        $query_total = "SELECT SUM(sub_total) AS total_harga FROM keranjang";
        $result_total = mysqli_query($koneksi, $query_total);
        $row_total = mysqli_fetch_assoc($result_total);
        $total_harga = $row_total['total_harga'];

        $response = array(
            'jumlah' => $jumlah,
            'subtotal' => number_format($subtotal, 0, ',', '.'),
            'total_harga' => number_format($total_harga, 0, ',', '.')
        );
        echo json_encode($response);
    } else {
        echo json_encode(array('error' => 'Item not found'));
    }
} else {
    echo json_encode(array('error' => 'Invalid request method'));
}
?>
