<?php

include 'config/koneksi.php';
session_start();
session_regenerate_id();

$queryDetail = mysqli_query($koneksi, "SELECT * FROM penjualan");

// hapus
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM penjualan  WHERE id ='$id'");
    header("location:kasir.php?hapus=berhasil");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <div class="menu border-bottom border-black">
        <?php include 'inc/navbar.php' ?>
    </div>
    <div class="container-fluid justify-content-center">
        <div class="row" style="height:100vh;">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="card card-kasir bg-transparent" style="backdrop-filter:blur (18px);">
                    <div class="card-header text-center">
                        <h1 class="text-light fw-bold ">Manage Kasir</h1>
                    </div>
                    <div class="card-body">
                        <div class="table table-responsive">
                            <div class="mt-2">
                                <a href="tambah-transaksi.php" class="btn btn-primary btn-sm">Kasir</a>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Transaksi</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Struk Pembayaran</th>
                                        <!-- <th>Satus Pembayaran</th>
                                        <th>Setting</th> -->
                                    </tr>
                                </thead>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($rowDetail = mysqli_fetch_assoc($queryDetail)) { ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $rowDetail['kode_transaksi'] ?></td>
                                            <td><?php echo $rowDetail['tanggal_transaksi'] ?></td>
                                            <td>
                                                <a class="btn btn-outline-primary" href="print.php?id=<?php echo $rowDetail['id'] ?>">Print Struk</a>
                                                <a href="kasir.php?delete=<?php echo $rowDetail['id'] ?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2"></div>
        </div>
    </div>

    <!--  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>