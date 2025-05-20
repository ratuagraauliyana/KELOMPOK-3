<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Detail Event - Taylor Swift</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet"/>
  <style>
    body {
      background-color: black;
      color: white;
    }
    .event-container-wrapper {
      background-color: #8a63d2;
      padding: 40px 0;
    }
    .event-container {
      background: #8a63d2;
      padding: 20px;
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }
    .event-img {
      width: 300px;
      border-radius: 20px;
    }
    .event-info {
      background-color: black;
      border-radius: 15px;
      padding: 20px;
      flex: 1;
    }
    .event-info h4 {
      margin-bottom: 10px;
    }
    .status-available {
      color: #28a745;
      font-weight: bold;
    }
    .ticket-button {
      background-color: white;
      color: black;
      border: none;
      padding: 8px 20px;
      border-radius: 30px;
      margin-right: 10px;
    }
    .notification {
      background-color: #333;
      color: #ccc;
      padding: 8px 12px;
      border-radius: 8px;
      font-size: 14px;
      margin-top: 10px;
    }

    #ticketPopup {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      backdrop-filter: blur(5px);
      background-color: rgba(0, 0, 0, 0.6);
      z-index: 9999;
      align-items: center;
      justify-content: center;
    }

    #ticketPopup.show {
      display: flex !important;
    }

    .Popup-content {
      background-color: white;
      padding: 30px;
      border-radius: 20px;
      width: 90%;
      max-width: 500px;
      position: relative;
      color: black;
    }

    .close-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      background: none;
      border: none;
      font-size: 24px;
      color: black;
    }

    .popup-form {
      background-color: black;
      color: white;
      border-radius: 20px;
      padding: 20px;
      text-align: left;
    }
    .popup-form label {
      flex: 1;
    }
    .popup-form input,
    .popup-form select {
      background-color: #1a1a1a;
      color: white;
      border: none;
      border-radius: 5px;
    }

  </style>
</head>
<body>

<div class="event-container-wrapper">
  <div class="container py-4">
    <div class="d-flex align-items-center mb-3 gap-2">
      <a href="home.html" class="text-black text-decoration-none fs-5">←</a>
      <h5 class="mb-0 text-black fw-medium">Detail Event</h5>
    </div>

    <div class="event-container">
      <img src="image/taylor swift the eras tour.jpeg" alt="Taylor Swift – The Eras Tour" class="event-img" />
      <div class="event-info">
        <h4>
          Taylor Swift – The Eras Tour
          <i class="bi bi-heart ms-2"></i>
          <span>12687</span>
        </h4>
        <p>A spectacular concert from Taylor Swift, featuring songs from every era of her music.</p>
        <p><strong>Event date:</strong> 17–18 Mei 2025</p>
        <p><strong>Location:</strong> Gelora Bung Karno, Jakarta</p>
        <button class="ticket-button" onclick="openPopup()">Get ticket</button>
        <span class="status-available">Available</span>
        <div class="notification mt-3">****gy44 has purchased a VIP ticket <strong>Taylor Swift – The Eras Tour</strong> 1 minute ago</div>
      </div>
    </div>
  </div>
</div>

<div id="ticketPopup">
  <div class="Popup-content text-center">
    <button class="close-btn" onclick="closePopup()">&times;</button>
    <h5 class="fw-bold mb-1">Ticket Reservation <span class="fw-normal">Taylor Swift – The Eras Tour</span></h5>
    <p class="mb-4">Please fill out the ticket reservation form below:</p>

    <div class="popup-form">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <label for="quantity" class="mb-0">Ticket quantity :</label>
        <input type="number" id="quantity" class="form-control w-50 ms-2" placeholder="Input number" min="1" max="10" />
      </div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <label for="category" class="mb-0">Ticket categories :</label>
        <select id="category" class="form-select w-50 ms-2">
          <option value="">Select categories</option>
          <option value="Regular">Regular</option>
          <option value="VIP" disabled>VIP (Sold Out)</option>
          <option value="Festival" disabled>Festival (Sold Out)</option>
        </select>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <label class="mb-0">Total :</label>
        <div id="totalDisplay" class="fw-bold w-50 text-end">IDR 0</div>
      </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
    <label for="payment">Payment Method :</label>
    <select id="payment" class="form-select w-50 ms-2">
      <option value="">Select payment</option>
      <option value="Credit Card">Credit Card</option>
      <option value="Bank Transfer">Bank Transfer</option>
      <option value="QRIS">QRIS</option>
    </select>
  </div>
</div>

   <button class="btn mt-4 px-4 py-2" id="continueBtn" style="background-color: #8a63d2; color: white; border-radius: 20px;">
      Continue to Payment
    </button>
  </div>
</div>

<div style="background-color: black; min-height: 100vh; padding: 40px 20px;">
  <div class="text-center mb-4">
    <h4 style="color: white; font-weight: 600;">
      Taylor Swift – The Eras Tour &nbsp;&nbsp; Seating Plan & Price
    </h4>
  </div>

  <div class="d-flex flex-wrap justify-content-center align-items-start gap-4">
    <div style="background-color: #5e3ca5; border-radius: 20px; padding: 20px 24px; width: 300px;">
      <div style="background-color: #2b2b2b; border-radius: 12px; padding: 12px 16px; margin-bottom: 12px; color: white; display: flex; justify-content: space-between; align-items: center;">
        <div>
          <div style="font-weight: 500;">VIP</div>
          <div style="color: red; font-size: 14px;">Sold out</div>
        </div>
        <div>IDR 5,000,000</div>
      </div>

      <div style="background-color: rgba(43, 43, 43, 0.6); border-radius: 12px; padding: 12px 16px; margin-bottom: 12px; color: white; display: flex; justify-content: space-between; align-items: center;">
        <div>
          <div style="font-weight: 500;">Regular</div>
          <div style="color: rgb(12, 207, 61); font-size: 14px;">Available</div>
        </div>
        <div>IDR 2,000,000</div>
      </div>

      <div style="background-color: #2b2b2b; border-radius: 12px; padding: 12px 16px; color: white; display: flex; justify-content: space-between; align-items: center;">
        <div>
          <div style="font-weight: 500;">Festival</div>
          <div style="color: red; font-size: 14px;">Sold out</div>
        </div>
        <div>IDR 3,500,000</div>
      </div>
    </div>

    <div>
      <img src="image/Seating Plan.png" style="max-width: 100%; border-radius: 20px;" alt="Seating Plan" />
    </div>
  </div>
</div>

<script>
  function openPopup() {
    document.getElementById("ticketPopup").classList.add("show");
    resetForm();
  }

  function closePopup() {
    document.getElementById("ticketPopup").classList.remove("show");
  }

  function resetForm() {
    document.getElementById("quantity").value = '';
    document.getElementById("category").value = '';
    document.getElementById("payment").value = '';
    document.getElementById("totalDisplay").textContent = "IDR 0";
  }

  document.addEventListener("DOMContentLoaded", function () {
    const continueBtn = document.getElementById("continueBtn");
    const quantityInput = document.getElementById("quantity");
    const categorySelect = document.getElementById("category");
    const paymentSelect = document.getElementById("payment");
    const totalDisplay = document.getElementById("totalDisplay");

    const prices = {
      "Regular": 2000000,
      "VIP": 5000000,
      "Festival": 3500000
    };

    function updateTotal() {
      const qty = parseInt(quantityInput.value) || 0;
      const category = categorySelect.value;
      const price = prices[category] || 0;
      const total = qty * price;
      totalDisplay.textContent = `IDR ${total.toLocaleString("id-ID")}`;
    }

    quantityInput.addEventListener("input", updateTotal);
    categorySelect.addEventListener("change", updateTotal);

    continueBtn.addEventListener("click", function () {
      const quantity = parseInt(quantityInput.value.trim());
      const category = categorySelect.value.trim();
      const payment = paymentSelect.value.trim();

      if (!quantity || quantity <= 0) {
        alert("Please enter a valid quantity of at least 1.");
        return;
      }

      if (quantity > 10) {
        alert("You can only purchase up to 10 tickets at once.");
        return;
      }

      if (!category) {
        alert("Please select a ticket category.");
        return;
      }

      if (category === "VIP" || category === "Festival") {
        alert("Sorry, the selected ticket category is sold out.");
        return;
      }

      if (!payment) {
        alert("Please select a payment method.");
        return;
      }

      window.location.href = "payment.html";
    });
  });
</script>
</body>
</html>
