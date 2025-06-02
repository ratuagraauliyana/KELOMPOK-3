<?php include 'db.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>

    body {
      background-image: url('img/Register.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      height: 85vh;
    }

    .centered-form {
      max-width: 500px;
      margin: 100px auto; 
      padding: 50px;
      border: 1px solid #ccc;
      border-radius: 20px; 
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
      background-color: rgba(255, 255, 255, 0.5);
      backdrop-filter: blur(10px);
    }

    .btn-pink {
    background-color:rgb(117, 72, 132); 
    color: white;
    border: none;
    }

    .btn-pink:hover {
      background-color:rgb(86, 48, 97); 
      color: white;
    }
  </style>
</head>
<body class="bg-light">

  <div class="container">
    <div class="centered-form">
      <div class="pb-3 text-center">
        <img src="img/Logo.jpg" alt="Logo" style="width: 150px; height: auto; margin-bottom: 10px;">
        <h1>Registration</h1>
      </div>
      <form method="POST" action="">
        <div class="mb-3">
          <label for="username" class="form-label"><strong>Username</strong></label>
          <input type="text" class="form-control" name="username" id="username">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label"><strong>Alamat Email</strong></label>
          <input type="email" class="form-control" name="email" id="email">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label"><strong>Password</strong></label>
          <input type="password" class="form-control" name="password" id="password">
        </div>
        <div class="mb-3">
        <label for="tanggal_lahir" class="form-label"><strong>Tanggal Lahir</strong></label>
        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
        </div>
        <button type="submit" class="mb-3 btn btn-pink w-100" name="create"><strong>Create</strong></button>
        <div class="mb-3 text-center">
          <p>Sudah punya akun? <a href="2_login.php">Login</a></p>
        </div>
      </form>
    </div>
  </div>

  <?php
  if (isset($_POST['create'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $tgl_lahir = $_POST['tanggal_lahir'];

    $query = "INSERT INTO user (username, email, password, tgl_lahir) 
              VALUES ('$username', '$email', '$password', '$tgl_lahir')";

    if (mysqli_query($conn, $query)) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
      Swal.fire({
        icon: 'success',
        title: 'Registrasi Berhasil!',
        text: 'Silakan login sekarang',
        confirmButtonColor: '#754884'
      }).then(function() {
        window.location.href = '2_login.php';
      });
    </script>";
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'Registrasi Gagal!',
            text: 'Coba periksa kembali datamu.',
            confirmButtonColor: '#754884'
          });
        </script>";
    }
  }
  ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
