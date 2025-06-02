<?php 
session_start();
include 'db.php';

$id_tiket = $_GET['id_tiket'] ?? null;

if (!$id_tiket) {
    echo "<div class='alert alert-danger text-center mt-5'>Ticket ID not found.</div>";
    exit;
}

// Handle refund decision
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['id_tiket'])) {
    $action = $_POST['action'];
    $id_tiket = $_POST['id_tiket'];

    if ($action === 'accept' || $action === 'reject') {
        // Langsung hapus dari tabel sebagai tanda "done"
        mysqli_query($conn, "DELETE FROM tiket_reservasi WHERE id_tiket = '$id_tiket'");

        $msg = $action === 'accept' ? 'Refund approved successfully.' : 'Refund rejected.';
        echo "<script>alert('$msg'); window.location.href='9_manage_event.php';</script>";
        exit;
    }
}

// Ambil detail tiket
$query = "SELECT r.*, e.nama_event, e.deskripsi, e.poster, e.tgl_mulai, e.tgl_selesai, e.lokasi, k.harga_tiket, k.nama_kategori
          FROM tiket_reservasi r 
          JOIN event e ON r.id_event = e.id_event 
          JOIN tiket_kategori k ON r.id_kategori = k.id_kategori 
          WHERE r.id_tiket = '$id_tiket'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<div class='alert alert-warning text-center mt-5'>Ticket not found.</div>";
    exit;
}

// Ambil data
$row = mysqli_fetch_assoc($result);
$status_tiket = $row['status_tiket'];
$status_refund = $row['status_refund'] ?? '';
$keterangan = trim($row['keterangan'] ?? '');

// Tentukan status display
if ($status_refund === 'Refund Success') {
    $status_text = 'Refund Successful';
    $status_class = 'text-accepted';
} elseif ($status_refund === 'Refund Rejected') {
    $status_text = 'Refund Rejected';
    $status_class = 'text-rejected';
} elseif ($status_tiket === 'cancelled' && $keterangan !== '') {
    $status_text = 'Cancel Request';
    $status_class = 'text-warning';
} else {
    $status_text = 'Accepted';
    $status_class = 'text-success';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Ticket Detail</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body { background-color: #f2f2f2; font-family: 'Segoe UI', sans-serif; }
    .container-cancel {
      max-width: 720px; margin: 30px auto; background: #fff;
      padding: 30px 40px; border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    .ticket-header img { width: 90px; height: 90px; object-fit: cover; border-radius: 12px; }
    .ticket-info, .ticket-footer {
      background-color: #fff; padding: 15px 25px;
      border-radius: 12px; margin-top: 25px;
      border: 1px solid #ddd;
      display: flex; justify-content: space-between; align-items: center;
    }
    .text-purple { color: #b67be3; }
    .text-success { color: rgb(13, 115, 155) !important;}
    .text-rejected { color: #dc3545; font-weight: bold; }
    .text-accepted { color: #28a745; font-weight: bold; }
    .text-warning { color: #e67e22; font-weight: bold; }
    .btn-secondary { width: 400px; font-weight: 600; border-radius: 50px; }
    .btn-success { width: 140px; font-weight: 600; border-radius: 50px; }
    .btn-danger { width: 140px; font-weight: 600; border-radius: 50px; }
    .btn-container { text-align: center; margin-top: 30px; }
    @media (max-width: 576px) {
      .container-cancel { margin: 20px 15px; padding: 25px 20px; }
      .btn-secondary { width: 100%; }
    }
    
  </style>
</head>
<body>

<div class="container-cancel">
  <div class="d-flex ticket-header gap-3">
    <img src="<?= htmlspecialchars($row['poster']) ?>" alt="Poster">
    <div>
      <h5><?= htmlspecialchars($row['nama_event']) ?></h5>
      <p class="text-muted small mb-1"><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></p>
      <div class="d-flex justify-content-between small">
        <span><strong><?= date('d', strtotime($row['tgl_mulai'])) ?>–<?= date('d M Y', strtotime($row['tgl_selesai'])) ?></strong></span>
        <span><strong><?= htmlspecialchars($row['lokasi']) ?></strong></span>
      </div>
    </div>
  </div>

  <?php 
    $harga = (int)$row['harga_tiket'];
    $kuantitas = (int)$row['tiket_kuantitas'];
    $service_fee = 10000;
    $total = ($harga + $service_fee) * $kuantitas;
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
      <strong class="text-purple">Rp <?= number_format($total, 0, ',', '.') ?></strong>
    </div>
  </div>

  <div class="ticket-footer mt-3">
    <div>
      <p><strong>Ticket Status:</strong> <span class="<?= $status_class ?>"><?= $status_text ?></span></p>
      <p><strong>Remarks:</strong><br><?= nl2br(htmlspecialchars($keterangan ?: 'No remarks')) ?></p>
    </div>
  </div>

  <?php if ($status_tiket === 'cancelled' && $keterangan !== ''): ?>
    <div class="text-center mt-4">
      <form method="post" class="d-flex justify-content-center gap-3">
        <input type="hidden" name="id_tiket" value="<?= $id_tiket ?>">
        <button name="action" value="accept" class="btn btn-success">Accept</button>
        <button name="action" value="reject" class="btn btn-danger">Reject</button>
      </form>
    </div>
  <?php endif; ?>

  <div class="btn-container">
    <a href="9_manage_event.php" class="btn btn-secondary">Back to Event</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
