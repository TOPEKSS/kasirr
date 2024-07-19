<?php
// Include database connection file
include 'koneksi.php'; // Adjust this path according to your project structure

// Get the id from the URL
$id = $_GET['id'];

// Start transaction
mysqli_begin_transaction($koneksi);

try {
    // Delete related records from detail_order
    $deleteDetailOrderQuery = "DELETE FROM detail_order WHERE id_barang=?";
    $stmtDeleteDetailOrder = mysqli_prepare($koneksi, $deleteDetailOrderQuery);
    mysqli_stmt_bind_param($stmtDeleteDetailOrder, "i", $id);
    mysqli_stmt_execute($stmtDeleteDetailOrder);
    mysqli_stmt_close($stmtDeleteDetailOrder);

    // Delete record from barang
    $deleteBarangQuery = "DELETE FROM barang WHERE id_barang=?";
    $stmtDeleteBarang = mysqli_prepare($koneksi, $deleteBarangQuery);
    mysqli_stmt_bind_param($stmtDeleteBarang, "i", $id);
    mysqli_stmt_execute($stmtDeleteBarang);
    mysqli_stmt_close($stmtDeleteBarang);

    // Commit transaction
    mysqli_commit($koneksi);

    // Success message and redirect
    echo "<script>
        alert('Hapus Data Berhasil');
        location.href = 'index.php?page=barang';
    </script>";

} catch (Exception $e) {
    // Rollback transaction in case of error
    mysqli_rollback($koneksi);

    // Error message
    echo "<script>
        alert('Hapus Data Gagal: " . $e->getMessage() . "');
        location.href = 'index.php?page=barang';
    </script>";
}

// Close connection
mysqli_close($koneksi);
?>
