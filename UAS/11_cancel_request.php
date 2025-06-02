<?php 
session_start();
include 'db.php';

$id_tiket = $_GET['id'] ?? '';

if (!$id_tiket) {
    echo "<div class='alert alert-danger text-center mt-5'>ID tiket tidak ditemukan.</div>";
    exit;
}

$query = "SELECT r.*, e.nama_event, e.deskripsi, e.poster, e.tgl_mulai, e.tgl_selesai, e.lokasi, k.harga_tiket, k.nama_kategori
          FROM tiket_reservasi r 
          JOIN event e ON r.id_event = e.id_event 
          JOIN tiket_kategori k ON r.id_kategori = k.id_kategori 
          WHERE r.id_tiket = '$id_tiket'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<div class='alert alert-warning text-center mt-5'>Tiket tidak ditemukan.</div>";
    exit;
}

$row = mysqli_fetch_assoc($result);

$cancel_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $update = "UPDATE tiket_reservasi SET status_tiket = 'cancelled', keterangan = '$keterangan' WHERE id_tiket = '$id_tiket'";

    if (mysqli_query($conn, $update)) {
        $cancel_msg = '<div class="alert alert-success text-center mt-3">Pengajuan pembatalan berhasil dikirim.</div>';
        $row['status_tiket'] = 'cancelled'; // update status lokal setelah berhasil update db
        $row['keterangan'] = $keterangan;
    } else {
        $cancel_msg = "<div class='alert alert-danger text-center mt-3'>Gagal mengajukan pembatalan: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Detail Tiket & Pengajuan Pembatalan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f2f2f2;
      font-family: 'Segoe UI', sans-serif;
    }
    .container-cancel {
      max-width: 720px;
      margin: 30px auto;
      background: #fff;
      padding: 30px 40px;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    .ticket-header img {
      width: 90px;
      height: 90px;
      object-fit: cover;
      border-radius: 12px;
    }
    .ticket-header h5 {
      font-weight: 600;
      margin-bottom: 0.2rem;
    }
    .ticket-info {
      background-color: #fff;
      padding: 15px 25px;
      border-radius: 12px;
      margin-top: 25px;
      border: 1px solid #ddd; 
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); 
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .ticket-info small {
      color: #999;
    }
    .ticket-footer {
        background-color: #fff;
        padding: 15px 25px;
        border-radius: 12px;
        margin-top: 25px;
        border: 1px solid #ddd; 
        display: flex;
        justify-content: space-between;
        align-items: center; 
    }

    .text-purple {
      color: #b67be3;
    }
    .text-warning {
      color: #eca200;
    }
    .text-success {
      color:rgb(13, 115, 155) !important;
    }
    form {
      margin-top: 10px;
    }
    label.form-label {
      font-weight: 600;
      color: #495057;
    }
    textarea.form-control {
      resize: vertical;
      font-size: 1rem;
      padding: 12px 15px;
      border-radius: 10px;
      border: 1.5px solid #ced4da;
      transition: border-color 0.3s ease;
    }
    textarea.form-control:focus {
      border-color: #dc3545;
      box-shadow: 0 0 5px rgba(220,53,69,.25);
    }
    .btn-danger {
      width: 160px;
      font-weight: 600;
      border-radius: 50px;
      transition: background-color 0.3s ease;
    }
    .btn-danger:hover {
      background-color: #b02a37;
    }
    .btn-secondary {
      width: 140px;
      font-weight: 600;
      border-radius: 50px;
    }
    .d-flex.gap-2 {
      justify-content: center;
      gap: 1rem;
    }
    /* Responsive */
    @media (max-width: 576px) {
      .container {
        margin: 20px 15px;
        padding: 25px 20px;
      }
      .btn-danger, .btn-secondary {
        width: 100%;
      }
      .d-flex.gap-2 {
        flex-direction: column;
        gap: 15px !important;
      }
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

<div class="container-cancel shadow-lg">

  <div class="d-flex ticket-header gap-3">
    <img src="<?= htmlspecialchars($row['poster']) ?>" alt="Poster">
    <div>
      <h5><?= htmlspecialchars($row['nama_event']) ?></h5>
      <p class="text-muted small mb-1"><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></p>
      <div class="d-flex justify-content-between small">
        <span>
          <strong>
            <?= date('d', strtotime($row['tgl_mulai'])) ?>–<?= date('d M Y', strtotime($row['tgl_selesai'])) ?>
          </strong>
        </span>
        <span><strong><?= htmlspecialchars($row['lokasi']) ?></strong></span>
      </div>
    </div>
  </div>

  <?php 
  $harga = isset($row['harga_tiket']) ? (int)$row['harga_tiket'] : 0;
  $kuantitas = isset($row['tiket_kuantitas']) ? (int)$row['tiket_kuantitas'] : 1;
  $service_fee = 10000;
  $total_payment = ($harga + $service_fee) * $kuantitas;
  ?>

  <div class="ticket-info mt-4">
    <div>
      <div><small>Category</small></div>
      <strong class="text-purple"><?= htmlspecialchars($row['nama_kategori']) ?></strong>
    </div>
    <div>
      <div><small>Ticket Price</small></div>
      <strong>Rp <?= number_format($harga, 0, ',', '.') ?></strong>
    </div>
    <div>
      <div><small>Quantity</small></div>
      <strong><?= $kuantitas ?></strong>
    </div>
    <div>
      <div><small>Service Fee</small></div>
      <strong>Rp <?= number_format($service_fee, 0, ',', '.') ?></strong>
    </div>
    <div>
      <div><small>Total Payment</small></div>
      <strong class="text-purple">Rp <?= number_format($total_payment, 0, ',', '.') ?></strong>
    </div>
  </div>

<div class="ticket-footer mt-3">
  <p><strong>Ticket Status:</strong> 
    <strong class="text-success">
      <?= ucfirst(str_replace('_', ' ', $row['status_tiket'])) ?>
    </strong>
  </p>

  <?php if ($row['status_tiket'] === 'cancelled'): ?>
    <p><strong>Cancellation Reason:</strong> <?= nl2br(htmlspecialchars($row['keterangan'])) ?></p>
  <?php endif; ?>
</div>

  <?php if ($row['status_tiket'] !== 'cancelled' && $row['status_tiket'] !== 'cancelled') : ?>
    <form method="post" onsubmit="return confirm('Yakin ingin mengajukan pembatalan tiket ini?');">
      <div class="mb-3">
        <label for="keterangan" class="form-label">Cancellation Reason</label>
        <textarea class="form-control" id="keterangan" name="keterangan" rows="4" required></textarea>
      </div>
      <div class="d-flex gap-2 justify-content-center">
        <button type="submit" class="btn btn-danger">Submit</button>
        <a href="8_your_ticket.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  <?php else: ?>
    <div class="text-center mt-4">
      <a href="8_your_ticket.php" class="btn btn-secondary">Back to Ticket List</a>
    </div>
  <?php endif; ?>

  <?= $cancel_msg ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
