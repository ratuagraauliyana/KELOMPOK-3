<?php 
include 'db.php';
session_start();

$id_event = $_GET['id_event'] ?? null;

$edit_mode = false;
$event_data = [];
$tiket_data = [];
$kategori_event_result = mysqli_query($conn, "SELECT id_kategori_event, nama_kategori_event FROM kategori_event");

if ($id_event) {
    $edit_mode = true;

    $event_query = mysqli_query($conn, "SELECT * FROM event WHERE id_event = '$id_event'");
    if ($event_query && mysqli_num_rows($event_query) > 0) {
        $event_data = mysqli_fetch_assoc($event_query);

        $tiket_query = mysqli_query($conn, "SELECT * FROM tiket_kategori WHERE id_event = '$id_event'");
        while ($row = mysqli_fetch_assoc($tiket_query)) {
            $tiket_data[] = $row;
        }
    } else {
        echo "<script>alert('Event tidak ditemukan'); window.location.href='9_manage_event.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $edit_mode ? "Edit Event" : "Make Event" ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .btn-purple {
            background-color: rgb(117, 72, 132);
            color: white;
            border: none;
        }
        .btn-purple:hover {
            background-color: rgb(86, 48, 97);
            color: white;
        }
        .btn-grey {
            background-color: rgb(155, 155, 155);
            color: white;
            border: none;
        }
        .btn-grey:hover {
            background-color: rgb(116, 116, 116);
            color: white;
        }
        .form-control, .form-select {
            background-color: #f3e9f8; /* soft purple */
            border: 1px solid rgb(181, 181, 181);
            color: #4b355c;
        }
        .form-control:focus, .form-select:focus {
            background-color: #f3e9f8;
            border-color: rgb(181, 181, 181);
            box-shadow: 0 0 0 0.2rem rgba(161, 116, 200, 0.25);
            color: #4b355c;
        }
        .removeTiket {
            height: 38px;
            line-height: 0;
            padding: 0 8px;
            margin-top: 32px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
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

    <section id="MakeEvent" class="py-5 bg-light">
        <div class="container">
            <div class="row mb-3">
                <div class="col">
                    <div
                        class="mx-auto bg-white p-4 rounded shadow"
                        style="max-width: 720px; border-radius: 1.5rem !important;"
                    >
                        <h2 class="text-center mb-4"><?= $edit_mode ? "Edit Event" : "Make Event" ?></h2>
                        
                        <form action="12_proses_event.php" method="POST" enctype="multipart/form-data">
                            <?php if ($edit_mode): ?>
                                <input type="hidden" name="id_event" value="<?= htmlspecialchars($id_event) ?>">
                            <?php endif; ?>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="id_kategori_event" class="form-label">Kategori Event</label>
                                    <select class="form-select" id="id_kategori_event" name="id_kategori_event" required>
                                        <option value="" disabled <?= !$edit_mode ? 'selected' : '' ?>>-- Pilih Kategori Event --</option>
                                        <?php 
                                      
                                        mysqli_data_seek($kategori_event_result, 0);
                                        while ($kategori = mysqli_fetch_assoc($kategori_event_result)) : 
                                        ?>
                                        <option value="<?= $kategori['id_kategori_event']; ?>"
                                            <?= ($edit_mode && $kategori['id_kategori_event'] == $event_data['id_kategori_event']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($kategori['nama_kategori_event']); ?>
                                        </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="nama_event" class="form-label">Nama Event</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="nama_event" 
                                        name="nama_event" 
                                        required 
                                        value="<?= $edit_mode ? htmlspecialchars($event_data['nama_event']) : '' ?>" 
                                    />
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea
                                    class="form-control"
                                    id="deskripsi"
                                    name="deskripsi"
                                    rows="3"
                                    required
                                ><?= $edit_mode ? htmlspecialchars($event_data['deskripsi']) : '' ?></textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                                    <input 
                                        type="date" 
                                        class="form-control" 
                                        id="tgl_mulai" 
                                        name="tgl_mulai" 
                                        required
                                        value="<?= $edit_mode ? $event_data['tgl_mulai'] : '' ?>"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                                    <input 
                                        type="date" 
                                        class="form-control" 
                                        id="tgl_selesai" 
                                        name="tgl_selesai" 
                                        required
                                        value="<?= $edit_mode ? $event_data['tgl_selesai'] : '' ?>"
                                    />
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="lokasi" class="form-label">Lokasi</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="lokasi" 
                                    name="lokasi" 
                                    required
                                    value="<?= $edit_mode ? htmlspecialchars($event_data['lokasi']) : '' ?>"
                                />
                            </div>

                            <div class="mb-3">
                                <label for="contact_person" class="form-label">Contact Person</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="contact_person" 
                                    name="contact_person" 
                                    required
                                    value="<?= $edit_mode ? htmlspecialchars($event_data['contact_person']) : '' ?>"
                                />
                            </div>

                            <div class="mb-3">
                                <label for="poster" class="form-label">Poster Event</label>
                                <?php if ($edit_mode && !empty($event_data['poster'])): ?>
                                    <div class="mb-2">
                                        <img src="<?= htmlspecialchars($event_data['poster']) ?>" alt="Poster Event" style="max-width: 150px;">
                                    </div>
                                    <input 
                                        type="file" 
                                        class="form-control" 
                                        id="poster" 
                                        name="poster" 
                                        accept="image/*" 
                                    />
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengganti poster</small>
                                <?php else: ?>
                                    <input 
                                        type="file" 
                                        class="form-control" 
                                        id="poster" 
                                        name="poster" 
                                        accept="image/*" 
                                        required
                                    />
                                <?php endif; ?>
                            </div>

                            <hr />
                            <h5 class="mb-3">Kategori Tiket</h5>

                            <div id="tiketWrapper">
                                <?php if ($edit_mode && count($tiket_data) > 0): ?>
                                    <?php foreach ($tiket_data as $tiket): ?>
                                        <div class="row mb-3 tiket-group">
                                            <input type="hidden" name="id_tiket[]" value="<?php echo isset($tiket['id_tiket']) ? htmlspecialchars($tiket['id_tiket']) : ''; ?>">
                                            <div class="col-md-4">
                                                <label class="form-label">Nama Kategori Tiket</label>
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="nama_kategori[]" 
                                                    required 
                                                    value="<?= htmlspecialchars($tiket['nama_kategori']) ?>" 
                                                />
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Harga Tiket</label>
                                                <input 
                                                    type="number" 
                                                    class="form-control" 
                                                    name="harga_tiket[]" 
                                                    required 
                                                    value="<?= htmlspecialchars($tiket['harga_tiket']) ?>" 
                                                />
                                            </div>
                                            <div class="col-md-4 d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Kuota Tiket</label>
                                                    <input 
                                                        type="number" 
                                                        class="form-control" 
                                                        name="kuota_tiket[]" 
                                                        required 
                                                        value="<?= htmlspecialchars($tiket['kuota_tiket']) ?>" 
                                                    />
                                                </div>
                                                <button 
                                                    type="button" 
                                                    class="btn btn-danger btn-sm ms-2 mt-4 removeTiket" 
                                                    title="Hapus tiket" 
                                                    style="height: 38px; line-height: 0; padding: 0 8px;"
                                                >×</button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="row mb-3 tiket-group">
                                        <div class="col-md-4">
                                            <label class="form-label">Nama Kategori Tiket</label>
                                            <input type="text" class="form-control" name="nama_kategori[]" required />
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Harga Tiket</label>
                                            <input type="number" class="form-control" name="harga_tiket[]" required />
                                        </div>
                                        <div class="col-md-4 d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <label class="form-label">Kuota Tiket</label>
                                                <input type="number" class="form-control" name="kuota_tiket[]" required />
                                            </div>
                                            <button 
                                                type="button" 
                                                class="btn btn-danger btn-sm ms-2 mt-4 removeTiket" 
                                                title="Hapus tiket" 
                                                style="height: 38px; line-height: 0; padding: 0 8px;"
                                            >×</button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-purple" id="addTiket">Tambah Kategori Tiket</button>
                                <button type="submit" class="btn btn-purple"><?= $edit_mode ? 'Update' : 'Submit' ?></button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('addTiket').addEventListener('click', function() {
            const tiketWrapper = document.getElementById('tiketWrapper');
            const newTiket = document.createElement('div');
            newTiket.classList.add('row', 'mb-3', 'tiket-group');
            newTiket.innerHTML = `
                <div class="col-md-4">
                    <label class="form-label">Nama Kategori Tiket</label>
                    <input type="text" class="form-control" name="nama_kategori[]" required />
                </div>
                <div class="col-md-4">
                    <label class="form-label">Harga Tiket</label>
                    <input type="number" class="form-control" name="harga_tiket[]" required />
                </div>
                <div class="col-md-4 d-flex align-items-center">
                    <div class="flex-grow-1">
                        <label class="form-label">Kuota Tiket</label>
                        <input type="number" class="form-control" name="kuota_tiket[]" required />
                    </div>
                    <button type="button" class="btn btn-danger btn-sm ms-2 mt-4 removeTiket" title="Hapus tiket" style="height: 38px; line-height: 0; padding: 0 8px;">×</button>
                </div>
            `;
            tiketWrapper.appendChild(newTiket);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeTiket')) {
                const tiketGroup = e.target.closest('.tiket-group');
                if (tiketGroup) {
                    tiketGroup.remove();
                }
            }
        });
    </script>
</body>
</html>
