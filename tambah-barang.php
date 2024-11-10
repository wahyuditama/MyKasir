<?php
include 'config/koneksi.php';

if (isset($_POST['tambah'])) {
    $nama_barang = $_POST['nama_barang'];
    $satuan = $_POST['satuan'];
    $qty = $_POST['qty'];
    $harga = $_POST['harga'];
    $id_kategori = $_POST['id_kategori'];

    // panggil id kategori
    if ($id_kategori) {
        //tambah data ke tabel barang
        $queryBarang = mysqli_query($koneksi, "INSERT INTO barang (nama_barang, satuan, qty, harga, id_kategori) VALUES ('$nama_barang', '$satuan', '$qty', '$harga', '$id_kategori')");

        if ($queryBarang) {
            header("Location: tambah-barang.php?tambah=berhasil");
            exit();
        } else {
            echo "Datanya Error";
        }
    } else {
        echo "Kategori belum dipilih!";
    }
}



?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Summernote with Bootstrap 5</title>
    <!-- include libraries(jQuery, bootstrap) -->
    <script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
    <script type="text/javascript" src="cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- include summernote css/js-->
    <link href="summernote-bs5.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="summernote-bs5.js"></script>

</head>

<body class="tambah-barang">
    <div class="menu border-bottom border-black">
        <?php include 'inc/navbar.php' ?>
    </div>
    <div class="container mt-5 pt-5">
        <div class="row" style="height:100vh;">
            <div class="col-sm-12">
                <div class="card mx-auto" style="width: 58rem;">
                    <div class="card-header">Tambah Barang</div>
                    <div class="card-body">
                        <form action="" method="post">
                            <label for="" class="form-label">Tambah Kategori barang</label>
                            <select name="id_kategori" id="kategori" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                <?php
                                // Ambil data kategori dari database
                                $queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori_barang");
                                while ($kategori = mysqli_fetch_assoc($queryKategori)) {
                                    echo "<option value='" . $kategori['id'] . "'>" . $kategori['nama_kategori'] . "</option>";
                                }
                                ?>
                            </select>
                            <div class="mb-3">
                                <label for="" class="form-label">Nama Barang</label>
                                <input type="text"
                                    class="form-control"
                                    name="nama_barang"
                                    placeholder="Masukkan nama barang"
                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['nama_barang'] : '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">satuan </label>
                                <input type="text"
                                    class="form-control"
                                    name="satuan"
                                    placeholder="Masukkan satuan barang"
                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['satuan'] : '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">qty </label>
                                <input type="number"
                                    class="form-control"
                                    name="qty"
                                    placeholder="Masukkan qty barang"
                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['qty'] : '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">harga </label>
                                <input type="number"
                                    class="form-control"
                                    name="harga"
                                    placeholder="Masukkan harga barang"
                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['harga'] : '' ?>">
                            </div>
                            <div class="mb-3">
                                <button name="<?php echo isset($_GET['edit']) ? 'edit' : 'tambah' ?>" class="btn btn-primary" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <!--  -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script>
            $('#summernote').summernote({
                placeholder: 'Hello Bootstrap 5',
                tabsize: 2,
                height: 100
            });
        </script>
</body>

</html>