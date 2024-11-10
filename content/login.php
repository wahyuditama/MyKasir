<?php
session_start();
include 'config/koneksi.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $selectLogin = mysqli_query($koneksi, "SELECT * FROM user WHERE email='$email'");

    if (mysqli_num_rows($selectLogin) > 0) {
        $row = mysqli_fetch_assoc($selectLogin);

        if ($row['email'] == $email && $row['password'] == $pass) {
            $_SESSION['ID'] = $row['id'];

            $_SESSION['NAMALENGKAP'] = $row['nama_lengkap'];
            header("Location: kasir.php");
            exit();
        }
    }
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
    <div class="container justify-content-center">
        <div class="row" style="height:100vh;">
            <div class="col-6 offset-3 mt-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h1>login</h1>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group mt-2">
                                <label for="email">email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="password">password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="card-footer border-0 border-top">
                                <div class="form-group mt-3" align="right">
                                    <a href="register.php"> Apakah Kamu belum punya akun ?</a>
                                    <button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</body>

</html>