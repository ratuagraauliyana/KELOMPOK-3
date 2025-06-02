<?php
include 'db.php';

session_start();
header('Content-Type: application/json');

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Debug log
file_put_contents('debug.log', date('Y-m-d H:i:s') . " POST: " . print_r($_POST, true) . "\n", FILE_APPEND);

$id_user = $_SESSION['id_user'] ?? null;
$id_event = $_POST['id_event'] ?? null;
$id_kategori = $_POST['id_kategori'] ?? null;
$kuantitas = $_POST['kuantitas'] ?? null;
$id_metode = $_POST['id_metode'] ?? null;
$total_harga_raw = $_POST['total_harga'] ?? '';
$total_harga = preg_replace('/[^\d]/', '', $total_harga_raw);

file_put_contents('debug.log', "id_event=$id_event, id_kategori=$id_kategori, kuantitas=$kuantitas, id_metode=$id_metode, total_harga_raw=$total_harga_raw, total_harga=$total_harga\n", FILE_APPEND);

if (!$id_user || !$id_event || !$id_kategori || !$kuantitas || !$id_metode || !$total_harga) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    exit;
}

// Cek sisa tiket
$stmtCek = $conn->prepare("SELECT sisa_tiket FROM tiket_kategori WHERE id_kategori = ?");
$stmtCek->bind_param("i", $id_kategori);
$stmtCek->execute();
$result = $stmtCek->get_result();
if ($result->num_rows == 0) {
    echo json_encode(['status' => 'error', 'message' => 'Kategori tiket tidak ditemukan']);
    exit;
}
$row = $result->fetch_assoc();

if ($kuantitas > $row['sisa_tiket']) {
    echo json_encode(['status' => 'error', 'message' => 'Jumlah tiket melebihi sisa tiket']);
    exit;
}

$kode_bayar = rand(10000000, 99999999);

// Insert reservasi
$stmt = $conn->prepare("INSERT INTO tiket_reservasi (id_user, id_event, id_kategori, tiket_kuantitas, id_metode, total_harga, booking_code, kode_bayar) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iiiiisi", $id_user, $id_event, $id_kategori, $kuantitas, $id_metode, $total_harga, $booking_code, $kode_bayar);

if ($stmt->execute()) {
    // Update sisa tiket
    $update = $conn->prepare("UPDATE tiket_kategori SET sisa_tiket = sisa_tiket - ? WHERE id_kategori = ?");
    $update->bind_param("ii", $kuantitas, $id_kategori);
    $update->execute();

    echo json_encode([
        'status' => 'success',
        'kode_bayar' => $kode_bayar
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => $conn->error
    ]);
}
