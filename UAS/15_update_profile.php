<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['id_user'];
$username = mysqli_real_escape_string($conn, $_POST['username']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$tgl_lahir = $_POST['tgl_lahir'];

$query = "UPDATE user SET username='$username', email='$email', tgl_lahir='$tgl_lahir' WHERE id_user='$id_user'";

if (mysqli_query($conn, $query)) {
    echo "<script>
        alert('Profile updated successfully!');
        window.location.href='7_profile.php';
    </script>";
} else {
    echo "<script>
        alert('Failed to update profile.');
        window.location.href='7_profile.php';
    </script>";
}
?>
