<?php
include 'db.php';
session_start();

if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan login terlebih dahulu'); window.location.href='login.php';</script>";
    exit;
}

$id_user = $_SESSION['id_user'];

// Proses delete jika ada parameter id_event di GET
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Hapus file poster jika ada
    $poster_query = mysqli_query($conn, "SELECT poster FROM event WHERE id_event = '$delete_id'");
    if ($poster_data = mysqli_fetch_assoc($poster_query)) {
        $poster_file = 'uploads/' . $poster_data['poster'];
        if (file_exists($poster_file)) {
            unlink($poster_file); // hapus file poster dari server
        }
    }

    // Hapus data di tiket_kategori dulu karena ada foreign key constraint
    $delete_kategori_query = "DELETE FROM tiket_kategori WHERE id_event = '$delete_id'";
    mysqli_query($conn, $delete_kategori_query);

    // Hapus data event
    $delete_query = "DELETE FROM event WHERE id_event = '$delete_id'";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Event berhasil dihapus'); window.location.href='9_manage_event.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menghapus event');</script>";
    }
}

// Ambil data event dari database + total tiket sold & cancel request
$query = "SELECT 
            e.id_event, 
            e.nama_event, 
            e.poster,
            COALESCE(SUM(CASE WHEN tr.status_tiket = 'paid' THEN tr.tiket_kuantitas ELSE 0 END), 0) AS sold,
            COALESCE(SUM(CASE WHEN tr.status_tiket = 'cancelled' THEN tr.tiket_kuantitas ELSE 0 END), 0) AS cancel_request
          FROM event e
          LEFT JOIN tiket_reservasi tr ON e.id_event = tr.id_event
          WHERE e.id_user = '$id_user'
          GROUP BY e.id_event, e.nama_event, e.poster
          ORDER BY e.id_event DESC";
$result = mysqli_query($conn, $query);


$edit_mode = false;
if (isset($_GET['id_event'])) {
    $edit_mode = true;
    $id_event = $_GET['id_event'];

    // Ambil data event dari database berdasarkan id_event
    $query = "SELECT * FROM event WHERE id_event = '$id_event'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $event_data = mysqli_fetch_assoc($result);
        // Data event sudah siap untuk diisi ke form
    } else {
        echo "<script>alert('Event tidak ditemukan'); window.location.href='9_manage_event.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .event-card {
            background-color: white;
            border-radius: 1rem;
            padding: 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .event-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .event-info img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 0.5rem;
        }
        .event-actions button {
            margin-left: 0.5rem;
        }
        .container-custom {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            border-radius: 1rem;
        }
        .btn-purple {
            background-color: rgb(117, 72, 132);
            color: white;
            border: none;
        }
        .btn-purple:hover {
            background-color: rgb(86, 48, 97);
        }
    </style>
</head>
<body>
    <?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

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
                            <a class="nav-link <?= ($current_page == '3_home.php') ? 'active' : '' ?>" href="3_home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == '8_your_ticket.php') ? 'active' : '' ?>" href="8_your_ticket.php">Ticket</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == '9_manage_event.php') ? 'active' : '' ?>" href="9_manage_event.php">Event</a>
                        </li>
                    </ul>
                </div>
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle <?= in_array($current_page, ['7_profile.php', '4_make_event.php', '5_find_event.php']) ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Profile
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item <?= ($current_page == '7_profile.php') ? 'active' : '' ?>" href="7_profile.php">Profile</a></li>
                        <li><a class="dropdown-item <?= ($current_page == '4_make_event.php') ? 'active' : '' ?>" href="4_make_event.php">Make Event</a></li>
                        <li><a class="dropdown-item <?= ($current_page == '5_find_event.php') ? 'active' : '' ?>" href="5_find_event.php">Find Event</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>


    <div class="container my-5">
        <div class="mx-auto p-4" style="max-width: 720px; border-radius: 1.5rem !important;"></div>
        <h3 class="fw-bold mb-4">Event List</h3>

        <?php while($event = mysqli_fetch_assoc($result)) : ?>
            <div class="event-card">
                <div class="event-info">
                    <img src="<?= htmlspecialchars($event['poster']) ?>" alt="Poster">
                    <div>
                        <strong><?= htmlspecialchars($event['nama_event']) ?></strong><br>
                        Sold: <?= $event['sold'] ?> &nbsp;|&nbsp;
                        Cancellation Request: <?= $event['cancel_request'] ?>
                    </div>
                </div>
                <div class="event-actions">
                    <a href="4_make_event.php?id_event=<?= $event['id_event'] ?>" class="btn btn-sm btn-purple">Edit</a>
                    <a href="9_manage_event.php?delete_id=<?= $event['id_event'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus event ini?')">Delete</a>
                </div>
            </div>
        <?php endwhile; ?>

        <div class="mt-4">
            <a href="4_make_event.php" class="btn btn-purple">Add Event</a>
        </div>
    </div>

    <!-- Section: Cancel Requests -->
    <div class="container my-5">
        <h3 class="fw-bold mb-4">Cancellation Requests</h3>

        <?php
        // Ambil event yang memiliki tiket status 'cancelled'
        $cancel_query = "SELECT 
                    tr.id_tiket,
                    e.id_event, 
                    e.nama_event, 
                    e.poster,
                    tr.tiket_kuantitas,
                    tr.status_tiket,
                    tr.keterangan
                FROM tiket_reservasi tr
                JOIN event e ON tr.id_event = e.id_event
                WHERE tr.status_tiket = 'cancelled' AND e.id_user = '$id_user'
                ORDER BY tr.id_tiket DESC";
                
        $cancel_result = mysqli_query($conn, $cancel_query);
        ?>

        <?php if (mysqli_num_rows($cancel_result) > 0): ?>
            <?php while($event = mysqli_fetch_assoc($cancel_result)) : ?>
                <div class="event-card">
                    <div class="event-info">
                        <img src="<?= htmlspecialchars($event['poster']) ?>" alt="Poster">
                        <div>
                            <strong><?= htmlspecialchars($event['nama_event']) ?></strong><br>
                            Pending Cancel Request: <?= $event['tiket_kuantitas'] ?>
                        </div>
                    </div>
                    <div class="event-actions">
                        <a href="10_manage_cancel.php?id_tiket=<?= $event['id_tiket'] ?>" class="btn btn-sm btn-warning">Review</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-muted">Tidak ada permintaan pembatalan saat ini.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
