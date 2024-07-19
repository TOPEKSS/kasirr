<?php
// Periksa apakah sesi sudah dimulai
if (session_status() == PHP_SESSION_NONE) {
    // Jika belum, mulai sesi
    session_start();
}
// Sisanya dari kode halaman...



  // Menghubungkan ke database
  $koneksi = mysqli_connect('localhost','root','','kasir');

  // Memeriksa koneksi
  if (mysqli_connect_errno()) {
    echo "Koneksi gagal: " . mysqli_connect_error();
  }


?>