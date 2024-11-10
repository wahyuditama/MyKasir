<?php
session_start();
include 'config/koneksi.php';

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Panggil data dari database
  $selectLogin = mysqli_query($koneksi, "SELECT * FROM operator WHERE username='$username' AND email='$email' AND password='$password'");

  if ($selectLogin && mysqli_num_rows($selectLogin) > 0) {
    //  hasil tarikan dari database ke dalam variabel $rowOperator
    $rowOperator = mysqli_fetch_assoc($selectLogin);

    // Cek data yang didapat dari database sesuai dengan input operator
    if ($rowOperator['username'] == $username && $rowOperator['password'] == $password && $rowOperator['email'] == $email) {
      $_SESSION['operator'] = $rowOperator['id'];
      header('Location: tambah-barang.php?selamat=datang');
      exit();
    }
  } else {
    // cek gagal login
    echo "<script>alert('Email atau Password salah!')</script>";
    header('Location: validasi-admin.php?login=gagal');
    exit();
  }
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

  <div class="menu border-bottom border-black">
    <?php include 'inc/navbar.php' ?>
  </div>
  <div class="container my-4">
    <div class="row" style="height:100vh;">
      <div class="col-sm-8 mx-auto">
        <div class="card">
          <div class="card-header">Silahkan Maukan Identitas Anda</div>
          <div class="card-body">
            <form action="" method="post">
              <div class="mb-3">
                <label class="form-label" for="username">Masukan username</label>
                <input type="text" class="form-control" id="username" name="username">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <button type="submit" class="btn btn-primary" name="login">Masuk</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>