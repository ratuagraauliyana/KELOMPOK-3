<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FindUrTicket - Login</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body,
    html {
      height: 100%;
      font-family: Arial, sans-serif;
    }

    .container {
      display: flex;
      height: 100vh;
    }

    .logo {
      position: fixed;
      right: 30px;
      top: 30px;
      width: 120px;
      z-index: 999;
    }

    .left {
      flex: 1;
      background: url('image/Register.jpeg') no-repeat center center/cover;
    }

    .right {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 40px;
      background-color: #fff;
    }

    .form {
      width: 100%;
      max-width: 320px;
    }

    .form h2 {
      margin-bottom: 24px;
      text-align: center;
      color: #222;
      font-weight: 600;
      font-size: 24px;
    }

    .google-btn {
      background: #f1f1f1;
      color: #000;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      padding: 10px;
      border: none;
      border-radius: 15px;
      cursor: pointer;
      margin-bottom: 24px;
      font-size: 15px;
      width: 100%;
      transition: background-color 0.3s ease;
    }

    .google-btn:hover {
      background-color: #e2e2e2;
    }

    .google-btn img {
      width: 20px;
      height: 20px;
    }

    .separator {
      display: flex;
      align-items: center;
      text-align: center;
      color: #888;
      font-size: 13px;
      margin-bottom: 24px;
    }

    .separator::before,
    .separator::after {
      content: "";
      flex: 1;
      border-bottom: 1px solid #ccc;
    }

    .separator:not(:empty)::before {
      margin-right: 12px;
    }

    .separator:not(:empty)::after {
      margin-left: 12px;
    }

    .form input {
      width: 100%;
      padding: 12px 15px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 20px;
      font-size: 15px;
      transition: border-color 0.3s ease;
    }

    .form input:focus {
      border-color: #1a73e8;
      outline: none;
    }

    .btn {
      width: 100%;
      padding: 12px;
      background-color: black;
      color: white;
      border: none;
      border-radius: 20px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: #444;
    }

    .small-text {
      font-size: 13px;
      margin-top: 15px;
      text-align: center;
      color: #555;
    }

    .link-blue {
      color: #1a73e8;
      text-decoration: none;
      font-weight: 500;
    }

    .link-blue:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .left,
      .right {
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
      <div class="form">
        <h2>Hi, Welcome Back!</h2>

        <button class="google-btn">
          <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google logo" />
          <span>Continue with Google</span>
        </button>

        <div class="separator">OR</div>

        <input type="email" placeholder="Email address" required />

        <input type="password" placeholder="Password" required />

        <button class="btn" onclick="goToVerify()">Sign In</button>

        <p class="small-text">
          By signing in you agree to FindUrTicket's
          <a href="#" class="link-blue">Terms of Service</a> &amp;
          <a href="#" class="link-blue">Privacy Policy</a>.
        </p>

        <p class="small-text">
          Don't have an account?
          <a href="#" class="link-blue">Sign Up</a>
        </p>
      </div>
    </div>
  </div>

  <script>
    function goToVerify() {
      window.location.href = "home.html";
    }
  </script>
</body>

</html>
