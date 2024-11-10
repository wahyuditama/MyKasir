<?php

include 'config/koneksi.php';

if (isset($_POST['register'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $nama_pengguna = $_POST['nama_pengguna'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $insertUser = mysqli_query($koneksi, "INSERT INTO user (nama_lengkap, nama_pengguna, password, email) VALUES ('$nama_lengkap', '$nama_pengguna', '$password', '$email')");
    header("Location: index.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container my-4">
        <div class="row" style="height:100vh;">
            <div class="col-sm-8 mx-auto">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Nama Pengguna</label>
                                <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <button type="submit" name="register">Register Disini</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--  -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>