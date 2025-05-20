<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FindUrTicket - Create Account</title>
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
    }

    .left {
      flex: 1;
      background: url('image/Register.jpeg') no-repeat center center / cover;
    }

    .right {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 40px;
    }

    .form {
      width: 100%;
      max-width: 300px;
    }

    .form h2 {
      margin-bottom: 20px;
      text-align: center;
    }

    .google-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      background: #f1f1f1;
      color: #000;
      border: none;
      border-radius: 15px;
      padding: 10px;
      cursor: pointer;
      margin-bottom: 20px;
      font-size: 14px;
      width: 100%;
    }

    .google-btn img {
      width: 18px;
      height: 18px;
    }

    .separator {
      display: flex;
      align-items: center;
      text-align: center;
      color: #888;
      font-size: 12px;
      margin-bottom: 20px;
    }

    .separator::before,
    .separator::after {
      content: "";
      flex: 1;
      border-bottom: 1px solid #ccc;
    }

    .separator::before {
      margin-right: 10px;
    }

    .separator::after {
      margin-left: 10px;
    }

    .form input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 20px;
    }

    .btn {
      width: 100%;
      padding: 10px;
      background-color: black;
      color: white;
      border: none;
      border-radius: 20px;
      cursor: pointer;
      margin-top: 10px;
    }

    .btn:hover {
      background-color: #444;
    }

    .small-text {
      font-size: 12px;
      margin-top: 16px;
      text-align: center;
      line-height: 1.6;
    }

    .link-blue {
      color: #1a73e8;
      text-decoration: none;
    }

    .link-blue:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <img src="image/Logo.png" alt="Logo" class="logo" />

  <div class="container">
    <div class="left"></div>
    <div class="right">
      <div class="form">
        <h2>Create Account</h2>

        <button class="google-btn">
          <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google logo" />
          <span>Google</span>
        </button>

        <div class="separator">OR</div>

        <input type="email" placeholder="Email address" />
        <input type="password" placeholder="Password" />
        <button class="btn" onclick="goToVerify()">Sign Up</button>

        <p class="small-text">
          By creating an account you agree to FindUrTicket's
          <a href="#" class="link-blue">Terms of Services</a> &amp; 
          <a href="#" class="link-blue">Privacy Policy</a>.
        </p>

        <p class="small-text">
          Already have an account? 
          <a href="#" class="link-blue">Sign In</a>
        </p>
      </div>
    </div>
  </div>

  <script>
    function goToVerify() {
      window.location.href = "verify.html";
    }
  </script>
</body>
</html>
