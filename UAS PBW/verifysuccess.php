<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FindUrTicket - Verify Success</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
      font-family: Arial, sans-serif;
    }

    .logo {
      position: fixed;
      right: 30px;
      width: 120px;
      z-index: 999;
    }
    
    .container {
      display: flex;
      height: 100vh;
      width: 100%;
    }

    .left {
      flex: 1;
      background: url('image/Register.jpeg') no-repeat center center / cover;
    }

    .right {
      flex: 1;
      background-color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 40px;
      text-align: center;
      gap: 15px;
    }

    .check-icon {
      width: 90px;
      height: 90px;
      margin-bottom: 20px;
      stroke: #28a745;
      stroke-width: 5;
    }

    .right h2 {
      font-size: 24px;
      color: black;
    }

    .right p {
      font-size: 14px;
      color: #555;
      margin-bottom: 30px;
    }

    .btn-login {
      padding: 12px 40px;
      background-color: black;
      color: white;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      font-size: 14px;
      transition: background-color 0.2s ease-in-out;
    }

    .btn-login:hover {
      background-color: #333;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }
      .left, .right {
        flex: none;
        width: 100%;
        height: 50vh;
      }
    }
  </style>
</head>
<body>
  <img src="image/Logo.png" alt="Logo" class="logo" />
  <div class="container">
    <div class="left"></div>
    <div class="right">
      <svg class="check-icon" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="50" cy="50" r="45" />
        <path d="M30 52L45 65L70 40" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>

      <h2>Successful</h2>
      <p>You have successfully created your account.</p>
      <button class="btn-login" onclick="location.href='login.html'">Login</button>
    </div>
  </div>
</body>
</html>
