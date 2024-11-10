<?php
session_start();
include '../config/koneksi.php';


if (isset($_POST['simpan'])) {


    $id_user = $_SESSION['ID'] ? $_SESSION['ID'] : '';

    $kode_transaksi = $_POST['kode_transaksi'];
    $tanggal_transaksi = $_POST['tanggal_transaksi'];
    $total_harga = $_POST['total_harga'];
    $nominal_bayar = $_POST['nominal_bayar'];
    $kembalian = $_POST['kembalian'];

    $queryPenjualan = mysqli_query($koneksi, " INSERT INTO penjualan (id_user, kode_transaksi, tanggal_transaksi) VALUES ('$id_user','$kode_transaksi','$tanggal_transaksi')");

    $id_penjualan = mysqli_insert_id($koneksi);

    foreach ($_POST['id_barang'] as $key => $id_barang) {
        $jumlah = $_POST['jumlah'][$key];
        $harga = $_POST['harga'][$key];
        $sub_total = $_POST['subtotal'][$key];

        // // ambil stok dan harga barang (This is a difficult or complicated method)
        // $barang = mysqli_query($koneksi, "SELECT harga, qty FROM barang WHERE id = '$id_barang'");
        // $barangData = mysqli_fetch_assoc($barang);

        // $harga = $barangData['harga'];
        // $qty = $barangData['qty'];

        // $total_harga_detail = $jumlah * $harga;

        $detailPenjualan = mysqli_query($koneksi, "INSERT INTO detail_penjualan (sub_total,id_penjualan, id_barang, jumlah, harga, total_harga, nominal_bayar, kembalian) 
        VALUES ('$sub_total','$id_penjualan', '$id_barang', '$jumlah', '$harga', '$total_harga', '$nominal_bayar', '$kembalian')");


        $updateQty = mysqli_query($koneksi, "UPDATE barang SET qty = qty - $jumlah WHERE id= '$id_barang'");
    }
    header("Location:../kasir.php?id= . id_penjualan");
    exit();
}
