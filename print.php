<?php
include 'config/koneksi.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';
if (!$id) {
    die('ID Transaksi Tidak Ditemukan');
}
// mengambil data detail penjualan
$queryDetail = mysqli_query($koneksi, "SELECT penjualan.id, penjualan.kode_transaksi, penjualan.tanggal_transaksi, barang.nama_barang, detail_penjualan.* FROM detail_penjualan LEFT JOIN penjualan ON penjualan.id = detail_penjualan.id_penjualan LEFT JOIN barang ON barang.id = detail_penjualan.id_barang WHERE detail_penjualan.id_penjualan = '$id'");

// mengambil data kembalian
$row = [];
while ($rowDetail = mysqli_fetch_array($queryDetail)) {
    $row[] = $rowDetail;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Transaksi : </title>
    <style>
        body {
            margin: 20px;
        }

        .struk {
            width: 80mm;
            max-width: 100%;
            border: 1px solid #000;
            padding: 10px;
            margin: 0 auto;
        }

        .struk-header .struk-footer {
            text-align: center;
            margin-bottom: 10px;
        }

        .struk-header h1 {
            font-size: 18px;
            margin: 0;
        }

        .struk-body {
            margin-bottom: 10px;
        }

        .struk-body table {
            border-collapse: collapse;
            width: 100%;
        }

        .struk-body table th,
        .struk-body table td {
            padding: 5px;
            text-align: left;
        }

        .struk-body table th {
            border-bottom: 1px solid #000;
        }

        .total,
        .payment,
        .change {
            display: flex;
            justify-content: space-evenly;
            padding: 5px 0;
            font-weight: bold;
        }

        .total {
            margin-top: 10px;
            border-top: 1px solid #000;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .struk {
                width: auto;
                border: none;
                margin: 0;
                padding: 0;
            }

            .struk-header h1 {
                font-size: 2rem;
                text-align: center;
            }

            .struk-body table th,
            .struk-body table td {
                padding: 2px 0;
            }
        }
    </style>
</head>

<body>

    <div class="struk">
        <div class="struk-header">
            <h1>Yae Market Store</h1>
            <p>Narukami Island</p>
            <p>75954954954954</p>
        </div>
        <div class="struk-body">
            <table>
                <thead>
                    <tr>

                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($row as $key => $rowDetail) : ?>
                        <tr>
                            <td><?php echo $rowDetail['nama_barang'] ?></td>
                            <td><?php echo "Rp" . number_format($rowDetail['jumlah']) ?></td>
                            <td><?php echo "Rp" . number_format($rowDetail['harga']) ?></td>
                            <td><?php echo "Rp" . number_format($rowDetail['sub_total']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="total">
                <span>Total :</span>
                <span><?php echo "Rp" . number_format($rowDetail['total_harga']) ?></span>
            </div>
            <div class="payment">
                <span>bayar :</span>
                <span><?php echo "Rp" . number_format($rowDetail['nominal_bayar']) ?></span>
            </div>
            <div class="change">
                <span>Kembalian :</span>
                <span><?php echo "Rp" . number_format($rowDetail['kembalian']) ?></span>
            </div>
        </div>
        <div class="struk-footer">
            <p>Terima Kasih Telah Berbelanja di Yae Market Store</p>
            <p>Nomor Faktur : <?php echo $rowDetail['kode_transaksi'] ?></p>
            <p>Tanggal : <?php echo $rowDetail['tanggal_transaksi'] ?></p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>