<?php 
include 'db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .card {
        position: relative;
    }
    .card-text {
        margin-bottom: 0.25rem; 
    }
    .card-title {
        margin-top: 0.25rem; 
    }
    .card-body {
        padding-bottom: 4rem;
    }
    .btn-purple {
        background-color:rgb(117, 72, 132); 
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
    }
    .btn-purple:hover {
        background-color:rgb(86, 48, 97); 
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.8);
        color: white;
    }
    .btn-lg-custom {
        width: 140px;
        height: 40px;
        line-height: 27px;
        border-radius: 2rem;
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

    <section id="Home">
    <div class="container">
        <div class="row align-items-center">
        <div class="col-md-6 text-center">
            <img src="img/Band Icon.jpg" alt="FindUrTicket" class="img-fluid" width="500"/>
        </div>
        <div class="col-md-6">
            <h1 class="display-4">Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p class="lead">Mulai dari mencari tiket hingga membuat event sendiri, semua bisa kamu lakukan di FindUrTicket.</p>
            <a href="4_make_event.php" class="btn btn-purple btn-lg-custom me-2"><strong>Make Event</strong></a>
            <a href="5_find_event.php" class="btn btn-purple btn-lg-custom"><strong>Find Event</strong></a>
        </div>
        </div>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#563061" fill-opacity="1" d="M0,160L48,186.7C96,213,192,267,288,250.7C384,235,480,149,576,133.3C672,117,768,171,864,202.7C960,235,1056,245,1152,234.7C1248,224,1344,192,1392,176L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
    </section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>