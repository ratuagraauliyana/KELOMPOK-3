<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id_user'])) {
    die("User belum login. Silakan <a href='2_login.php'>login</a> terlebih dahulu.");
}

$id_user = $_SESSION['id_user'];
$id_event = isset($_POST['id_event']) ? (int)$_POST['id_event'] : 0;
$id_kategori_event = trim($_POST['id_kategori_event'] ?? '');
$nama_event = trim($_POST['nama_event'] ?? '');
$deskripsi = trim($_POST['deskripsi'] ?? '');
$tgl_mulai = trim($_POST['tgl_mulai'] ?? '');
$tgl_selesai = trim($_POST['tgl_selesai'] ?? '');
$lokasi = trim($_POST['lokasi'] ?? '');
$contact_person = mysqli_real_escape_string($conn, trim($_POST['contact_person'] ?? ''));

$nama_kategori = $_POST['nama_kategori'] ?? [];
$harga_tiket = $_POST['harga_tiket'] ?? [];
$kuota_tiket = $_POST['kuota_tiket'] ?? [];
$id_kategori_form = $_POST['id_kategori'] ?? [];

// Validasi dasar
if (
    empty($id_kategori_event) || empty($nama_event) || empty($deskripsi) ||
    empty($tgl_mulai) || empty($tgl_selesai) || empty($lokasi) ||
    empty($nama_kategori) || empty($harga_tiket) || empty($kuota_tiket)
) {
    die("Data event tidak lengkap.");
}

$poster_path = null;
$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}

if (!$id_event) {
    // Untuk tambah baru, poster wajib ada
    if (!isset($_FILES['poster']) || $_FILES['poster']['error'] !== 0) {
        die("Poster wajib diunggah untuk event baru.");
    }
}

if (isset($_FILES['poster']) && $_FILES['poster']['error'] === 0) {
    $ext = strtolower(pathinfo($_FILES["poster"]["name"], PATHINFO_EXTENSION));
    $filename = uniqid('poster_') . '.' . $ext;
    $target_file = $target_dir . $filename;
    if (!move_uploaded_file($_FILES["poster"]["tmp_name"], $target_file)) {
        die("Gagal mengupload file poster.");
    }
    $poster_path = $target_file;
}

if ($id_event) {
    // MODE EDIT EVENT
    if ($poster_path) {
        $sql = "UPDATE event SET id_kategori_event=?, nama_event=?, deskripsi=?, tgl_mulai=?, tgl_selesai=?, lokasi=?, poster=?, contact_person=? WHERE id_event=? AND id_user=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssssii", $id_kategori_event, $nama_event, $deskripsi, $tgl_mulai, $tgl_selesai, $lokasi, $poster_path, $contact_person, $id_event, $id_user);
    } else {
        $sql = "UPDATE event SET id_kategori_event=?, nama_event=?, deskripsi=?, tgl_mulai=?, tgl_selesai=?, lokasi=?, contact_person=? WHERE id_event=? AND id_user=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssssii", $id_kategori_event, $nama_event, $deskripsi, $tgl_mulai, $tgl_selesai, $lokasi, $contact_person, $id_event, $id_user);
    }

    if ($stmt->execute()) {
        // Tiket Kategori - Update & Insert
        $existing = [];
        $res1 = $conn->query("SELECT id_kategori FROM tiket_kategori WHERE id_event = $id_event");
        while ($row = $res1->fetch_assoc()) {
            $existing[] = $row['id_kategori'];
        }

        $reserved = [];
        if ($existing) {
            $ids = implode(',', $existing);
            $res2 = $conn->query("SELECT DISTINCT id_kategori FROM tiket_reservasi WHERE id_kategori IN ($ids)");
            while ($r = $res2->fetch_assoc()) {
                $reserved[] = $r['id_kategori'];
            }
        }

        $form_ids = [];

        for ($i = 0; $i < count($nama_kategori); $i++) {
    $id_kat = isset($id_kategori_form[$i]) ? (int)$id_kategori_form[$i] : 0;
    $nama = mysqli_real_escape_string($conn, trim($nama_kategori[$i]));
    $harga = (int)$harga_tiket[$i];
    $kuota = (int)$kuota_tiket[$i];

    if ($id_kat > 0 && in_array($id_kat, $existing)) {
        // Update kategori tiket yang sudah ada
        $q = $conn->query("SELECT kuota_tiket, sisa_tiket FROM tiket_kategori WHERE id_kategori = $id_kat");
        if ($q && $q->num_rows > 0) {
            $d = $q->fetch_assoc();
            $selisih = $kuota - $d['kuota_tiket'];
            $sisa_baru = max(0, $d['sisa_tiket'] + $selisih);

            $stmt2 = $conn->prepare("UPDATE tiket_kategori SET nama_kategori=?, harga_tiket=?, kuota_tiket=?, sisa_tiket=? WHERE id_kategori=?");
            $stmt2->bind_param("siiii", $nama, $harga, $kuota, $sisa_baru, $id_kat);
            $stmt2->execute();
            $stmt2->close();
            $form_ids[] = $id_kat;
        }
    } else if ($id_kat === 0) {
        // Pastikan kategori baru dengan nama yang unik, tidak ada di event yang sama
        $nama_check = $conn->real_escape_string($nama);
        $cek = $conn->query("SELECT COUNT(*) as count FROM tiket_kategori WHERE id_event = $id_event AND nama_kategori = '$nama_check'");
        $cek_data = $cek->fetch_assoc();
        if ($cek_data['count'] == 0) {
            $stmt3 = $conn->prepare("INSERT INTO tiket_kategori (id_event, nama_kategori, harga_tiket, kuota_tiket, sisa_tiket) VALUES (?, ?, ?, ?, ?)");
            $sisa = $kuota;
            $stmt3->bind_param("isiii", $id_event, $nama, $harga, $kuota, $sisa);
            $stmt3->execute();
            $stmt3->close();
        }
        
    }
}


        foreach ($existing as $eid) {
            if (!in_array($eid, $form_ids) && !in_array($eid, $reserved)) {
                $conn->query("DELETE FROM tiket_kategori WHERE id_kategori = $eid");
            }
        }

        echo "<script>alert('Event berhasil diperbarui!');window.location.href = '3_home.php';</script>";
        exit;
    } else {
        die("Gagal memperbarui event: " . $stmt->error);
    }
} else {
    // MODE TAMBAH EVENT
    $sql = "INSERT INTO event (id_user, id_kategori_event, nama_event, deskripsi, tgl_mulai, tgl_selesai, lokasi, poster, contact_person) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisssssss", $id_user, $id_kategori_event, $nama_event, $deskripsi, $tgl_mulai, $tgl_selesai, $lokasi, $poster_path, $contact_person);

    if ($stmt->execute()) {
        $id_event = $stmt->insert_id;
        $stmt2 = $conn->prepare("INSERT INTO tiket_kategori (id_event, nama_kategori, harga_tiket, kuota_tiket, sisa_tiket) VALUES (?, ?, ?, ?, ?)");
        for ($i = 0; $i < count($nama_kategori); $i++) {
            $nama = mysqli_real_escape_string($conn, trim($nama_kategori[$i]));
            $harga = (int)$harga_tiket[$i];
            $kuota = (int)$kuota_tiket[$i];
            $sisa = $kuota;
            $stmt2->bind_param("isiii", $id_event, $nama, $harga, $kuota, $sisa);
            $stmt2->execute();
        }
        $stmt2->close();

        echo "<script>alert('Event berhasil ditambahkan!');window.location.href = '3_home.php';</script>";
        exit;
    } else {
        die("Gagal menambahkan event: " . $stmt->error);
    }
}
?>
