<?php
session_start();
session_regenerate_id();
date_default_timezone_set('Asia/Jakarta'); //
include 'config/koneksi.php';

//waktu data
$currentTime = date('Y-m-d');

//
function generateTransactionCode()
{
    $kode = date('Ymdhis');
    return $kode;
}

//click_count 
if (empty($_SESSION['click_count'])) {
    $_SESSION['click_count'] = 0;
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
    <div class="container-fluid">
        <div class=" d-flex row row-transaksi justify-content-center">
            <div class="col-12 col-md-8 table-header bg-tertiary">
                <div class="card text-light border-4 shadow-lg p-3 mb-5 bg-transparent rounded">
                    <div class="card-header text-center">
                        <h4 class="fw-bold">Tabel Transaksi</h4>
                    </div>
                    <div class="card-body">
                        <form action="controller/transaksi-store.php" method="post">
                            <div class="mb-3 ">
                                <label for="" class="form-label">Kode Transaksi</label>
                                <input type="text" class="form-control w-50" id="kode_transaksi" name="kode_transaksi" value="<?php echo "TR-" . generateTransactionCode() ?>" readonly>
                            </div>
                            <div class="mb-3 ">
                                <label for="" class="form-label">Tanggal Transaksi</label>
                                <input type="date" class="form-control w-50" id="tanggal_transaksi" name="tanggal_transaksi" value="<?php echo $currentTime ?>" readonly>
                            </div>
                            <div class="mb-3 ">
                                <div class="btn btn-outline-primary" type="button" id="counterBtn">Tambah</div>
                                <!-- <input type="number" name="countDisplay" id="countDisplay" class="visually-hidden" width="100%" value="<?php echo $_SESSION['click_count'] ?>" readonly> -->
                            </div>
                            <div class="table table-responsive rounded-2">
                                <table class=" table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nomor</th>
                                            <th>Nama Kategori</th>
                                            <th>Nama Barang</th>
                                            <th>Qty</th>
                                            <th>Sisa Produk</th>
                                            <th>Harga</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">
                                        <!-- data ditambah disini -->
                                    </tbody>
                                    <tfoot class="text-center">
                                        <tr>
                                            <th colspan="6">Total Harga</th>
                                            <td><input type="number" id="total_harga_keseluruhan" name="total_harga" class="form-control" readonly></td>
                                        </tr>
                                        <tr>
                                            <th colspan="6">Nominal Bayar</th>
                                            <td><input type="text" name="nominal_bayar" class="form-control" id="nominal_bayar_keseluruhan" required></td>
                                        </tr>
                                        <tr>
                                            <th colspan="6">Kembalian</th>
                                            <td><input type="number" id="kembalian_keseluruhan" name="kembalian" class="form-control" readonly></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <br>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-outline-primary" name="simpan" value="Beli Sekarang">
                                <a href="kasir.php" class="btn btn-danger">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $query = mysqli_query($koneksi, "SELECT * FROM kategori_barang");
    $categories = mysqli_fetch_all($query, MYSQLI_ASSOC);
    ?>
    <!--  -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //fungsi tambah baris
            const button = document.getElementById('counterBtn');
            const countDisplay = document.getElementById('countDisplay');
            const tbody = document.getElementById('tbody');
            const table = document.getElementById('table');
            let no = 0;
            button.addEventListener('click', function() {
                no++
                // let currentCount = parseInt(countDisplay.value) || 0;
                // ++currentCount;
                // countDisplay.value = currentCount;

                // Fungsi tambah baris (td)
                let newRow = "<tr>";
                newRow += "<td>" + no + "</td>";
                newRow += "<td><select class='form-control category-select' name='id_kategori[]' required>";
                newRow += "<option value=''>---Pilih Kategori---</option>";

                // PHP bagian ini akan diterjemahkan di sisi server
                <?php foreach ($categories as $category) { ?>
                    newRow += "<option value='<?php echo $category['id']; ?>'><?php echo $category['nama_kategori']; ?></option>";
                <?php } ?>

                newRow += "</select></td>";
                newRow += "<td><select class='form-control item-select' name='id_barang[]' required>";
                newRow += "<option value=''>---Pilih Barang---</option>";
                newRow += "</select></td>";
                newRow += "<td><input type='number' class='form-control jumlah-input' name='jumlah[]' value='0' required></td>";
                newRow += "<td><input type='number' name='sisa_produk[]' class='form-control' readonly></td>";
                newRow += "<td><input type='number' name='harga[]' class='form-control' readonly></td>";
                newRow += "<td><input type='number' name='subtotal[]' class='form-control sub-total' readonly></td>";
                newRow += "</tr>";

                // Menyisipkan HTML ke dalam tbody
                tbody.insertAdjacentHTML('beforeend', newRow);

                attachCategoryChangeListener();
                attachItemChangeListener();
                attachJumlahChangeListener();

            });
            // fungsi untuk menampilkan brang berdasarkan kategori ...
            function attachCategoryChangeListener() {
                const categorySelects = document.querySelectorAll('.category-select');
                categorySelects.forEach(select => {
                    select.addEventListener('change', function() {
                        const categoryId = this.value;
                        const itemSelect = this.closest('tr').querySelector('.item-select');

                        if (categoryId) {
                            fetch('controller/get-product-dari-category.php?id_kategori=' + categoryId)
                                .then(response => response.json())
                                .then(data => {
                                    itemSelect.innerHTML = '<option value="">---Pilih Barang---</option>';
                                    data.forEach(item => {
                                        itemSelect.innerHTML += `<option value="${item.id}">${item.nama_barang}</option>`;

                                    });
                                });
                        } else {
                            itemSelect.innerHTML = '<option value="">---Pilih Barang---</option>';
                        }
                    });

                });
            }

            function attachItemChangeListener() {
                const itemSelects = document.querySelectorAll('.item-select');
                itemSelects.forEach(select => {
                    select.addEventListener('change', function() {
                        const itemId = this.value;
                        const row = this.closest('tr');
                        const sisaProdukInput = row.querySelector('input[name="sisa_produk[]"]');
                        const hargaInput = row.querySelector('input[name="harga[]"]');

                        if (itemId) {
                            fetch('controller/get-barang-details.php?id_barang=' + itemId)
                                .then(response => response.json())
                                .then(data => {
                                    sisaProdukInput.value = data.qty;
                                    hargaInput.value = data.harga;
                                })
                        } else {
                            sisaProdukInput.value = '';
                            hargaInput.value = '';
                        }
                    });
                });
            }

            const totalHargaKeseluruhan = document.getElementById('total_harga_keseluruhan');
            // const subTotal = document.querySelectorAll('.sub-total');
            const nominalBayarKeseluruhanInput = document.getElementById('nominal_bayar_keseluruhan');
            const kembalianKeseluruhanInput = document.getElementById('kembalian_keseluruhan');

            // fungsi untuk membuat alert jumlah > sisaProduk
            function attachJumlahChangeListener() {
                const jumlahInputs = document.querySelectorAll('.jumlah-input');
                jumlahInputs.forEach(input => {
                    input.addEventListener('input', function() {
                        const row = this.closest('tr');
                        const sisaProdukInput = row.querySelector('input[name="sisa_produk[]"]');
                        const totalHargaInput = row.querySelector('input[name="harga[]"]');
                        ('total_harga_keseluruhan');
                        const nominalBayarInput = document.getElementById('nominal_bayar_keseluruhan');
                        const kembalianInput = document.getElementById('kembalian_keseluruhan');

                        const jumlah = parseInt(this.value) || 0;
                        const sisaProduk = parseInt(sisaProdukInput.value) || 0;
                        const harga = parseInt(totalHargaInput.value) || 0;

                        if (jumlah > sisaProduk) {
                            alert("Jumlah tidak boleh melebihi sisa produk");
                            this.value = sisaProduk;
                            return;
                        }
                        updatetTotalKeseluruhan();
                    });
                });
            }

            function updatetTotalKeseluruhan() {
                let total = 0;
                let totalKeseluruhan = 0;
                const jumlahInput = document.querySelectorAll('.jumlah-input');

                jumlahInput.forEach(input => {
                    const row = input.closest('tr');
                    const hargaInput = row.querySelector('input[name="harga[]"]');
                    const harga = parseFloat(hargaInput.value) || 0;
                    const jumlah = parseInt(input.value) || 0;

                    const subTotal = row.querySelector('.sub-total');
                    total = jumlah * harga;
                    subTotal.value = total;
                });
                const subTotal = document.querySelectorAll('.sub-total');
                subTotal.forEach(totalItem => {
                    let subTotal = parseFloat(totalItem.value) || 0;
                    totalKeseluruhan += subTotal;
                })

                totalHargaKeseluruhan.value = totalKeseluruhan;

            }

            // mencari kembalian ..
            nominalBayarKeseluruhanInput.addEventListener('input', function() {
                const nominalBayar = parseFloat(this.value) || 0;
                const totalHarga = parseFloat(totalHargaKeseluruhan.value) || 0;
                // kembalianKeseluruhanInput.value = nominalBayar - totalHarga;
                if (nominalBayar >= totalHarga) {
                    let kembalian = nominalBayar - totalHarga;
                    kembalianKeseluruhanInput.value = kembalian;
                } else if (nominalBayar == 0) {
                    kembalianKeseluruhanInput.value = 0;
                }
            });
        });
    </script>

    <!--  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>