<?php 
session_start();
include 'db.php';

$result = mysqli_query($conn, "SELECT id_tiket FROM tiket_reservasi WHERE booking_code IS NULL OR booking_code = ''");

while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id_tiket'];
    $code = strtoupper(substr(md5(uniqid($id, true)), 0, 10));
    mysqli_query($conn, "UPDATE tiket_reservasi SET booking_code = '$code' WHERE id_tiket = '$id'");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Ticket Detail</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f2f2f2;
      font-family: 'Segoe UI', sans-serif;
    }
    .ticket-container {
      background-color: #fff;
      transition: all 0.3s ease;
      border-radius: 20px;
      padding: 30px;
      max-width: 720px;
      margin: 50px auto;
    }
    .ticket-header img {
      width: 90px;
      height: 90px;
      object-fit: cover;
      border-radius: 12px;
    }
    .ticket-header h5 {
      font-weight: 600;
    }
    .ticket-info {
    background-color: #fff;
    padding: 15px 25px;
    border-radius: 12px;
    margin-top: 25px;
    border: 1px solid #ddd; 
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); 
    }
    .ticket-info small {
      color: #ccc;
    }
    .ticket-info strong {
      color:rgb(236, 187, 72);
    }
    .ticket-footer {
      background-color: #fff;
      border: 1px solid #ddd; 
      padding: 15px 25px;
      border-radius: 12px;
      margin-top: 15px;
    }
    .text-purple {
      color: #b67be3;
    }
    .text-success {
      color: #4fe29a !important;
    }
    .cancel-link {
      text-align: center;
      color: gray;
      font-size: 0.85rem;
      margin-top: 25px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="3_home.php">
        <img src="img/Logo.jpg" alt="Logo" style="height: 40px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="3_home.php">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="8_your_ticket.php">Ticket</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="9_manage_event.php">Event</a>
                    </li>
                </ul>
            </div>
            <li class="nav-item dropdown me-2">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Profile
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="7_profile.php">Profile</a></li>
                <li><a class="dropdown-item" href="4_make_event.php">Make Event</a></li>
                <li><a class="dropdown-item" href="5_find_event.php">Find Event</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
            </ul>
            </li>
        </ul>
        </div>
    </div>
    </nav>

    <div class="ticket-container shadow-lg">
    <?php
        $id_tiket = $_GET['id'];
        $query = "SELECT r.*, e.nama_event, e. deskripsi, e.poster, e.tgl_mulai, e.tgl_selesai, e.lokasi, k.harga_tiket, k.nama_kategori
                FROM tiket_reservasi r 
                JOIN event e ON r.id_event = e.id_event 
                JOIN tiket_kategori k ON r.id_kategori = k.id_kategori 
                WHERE r.id_tiket = '$id_tiket'";
        $result = mysqli_query($conn, $query);

  if ($row = mysqli_fetch_assoc($result)):
    $harga = isset($row['harga_tiket']) ? $row['harga_tiket'] : 0;
    $kuantitas = isset($row['tiket_kuantitas']) ? $row['tiket_kuantitas'] : 1;
    $service_fee = 10000;
    $total_payment = ($harga + $service_fee) * $kuantitas;
    $booking_code = strtoupper(substr(md5($id_tiket), 0, 10));
  ?>
  
  <div class="d-flex ticket-header gap-3">
    <img src="<?= $row['poster'] ?>" alt="Poster">
    <div>
      <h5><?= $row['nama_event'] ?></h5>
      <p class="text-muted small mb-1"><?= nl2br($row['deskripsi']) ?></p>
      <div class="d-flex justify-content-between small">
        <span>
        <strong>
            <?= date('d', strtotime($row['tgl_mulai'])) ?>–<?= date('d M Y', strtotime($row['tgl_selesai'])) ?>
        </strong>
        </span>
        <span><strong><?= $row['lokasi'] ?></strong></span>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-between align-items-center ticket-info mt-4">
    <div>
       <small>Seat</small><br>
       <strong class="text-warning"><?= htmlspecialchars($row['nama_kategori']) ?></strong>
    </div>
    <div class="text-end">
      <small>Booking Code</small><br>
      <strong class="text-warning"><?= $row['booking_code'] ?></strong>
    </div>
  </div>

  <div class="ticket-footer mt-3">
    <div class="d-flex justify-content-between mb-2">
      <span>ORDER NUMBER</span>
      <span><?= $row['id_tiket'] ?></span>
    </div>
    <div class="d-flex justify-content-between mb-2">
      <span>REGULAR SEAT</span>
      <span>IDR <?= number_format($harga, 0, ',', '.') ?> × <?= $kuantitas ?></span>
    </div>
    <div class="d-flex justify-content-between mb-2">
      <span>SERVICE FEE</span>
      <span>IDR <?= number_format($service_fee * $kuantitas, 0, ',', '.') ?></span>
    </div>
    <div class="d-flex justify-content-between mb-2">
      <span>PAYMENT METHOD</span>
      <span><?= $row['metode_pembayaran'] ?? 'Transfer Bank' ?></span>
    </div>
    <div class="d-flex justify-content-between fw-bold text-purple mt-3">
      <span>TOTAL PAYMENT</span>
      <span>IDR <?= number_format($total_payment, 0, ',', '.') ?></span>
    </div>
  </div>

  <div class="cancel-link">
  <a href="11_cancel_request.php?id=<?= $row['id_tiket'] ?>" class="text-decoration-none text-muted">CANCELLATION REQUEST</a>
  </div>

  <?php else: ?>
    <div class="text-center">Tiket tidak ditemukan.</div>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
