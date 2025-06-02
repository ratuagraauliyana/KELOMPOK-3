<?php 
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
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
        <h1>Login</h1>
      </div>
      <form method="POST" action="">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label"><strong>Alamat Email</strong></label>
          <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label"><strong>Password</strong></label>
          <input type="password" class="form-control" name="password" id="exampleInputPassword1">
        </div>
        <button type="submit" name="login" class="btn btn-pink w-100 mb-3"><strong>Login</strong></button>
        <div class="mb-3 text-center">
          <p>Belum punya akun? <a href="1_register.php">Registration</a></p>
        </div>
      </form>
    </div>
  </div>

  <?php
  if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['id_user'] = $user['id_user']; 
            $_SESSION['username'] = $user['username'];

            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
              Swal.fire({
                icon: 'success',
                title: 'Login Berhasil!',
                text: 'Selamat datang, " . $user['username'] . "',
                confirmButtonColor: '#754884'
              }).then(function() {
                window.location.href = '3_home.php';
              });
            </script>";
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
              Swal.fire({
                icon: 'error',
                title: 'Login Gagal!',
                text: 'Password salah.',
                confirmButtonColor: '#754884'
              });
            </script>";
        }
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'Login Gagal!',
            text: 'Email tidak ditemukan.',
            confirmButtonColor: '#754884'
          });
        </script>";
    }
    }
  ?>

</body>
</html>
