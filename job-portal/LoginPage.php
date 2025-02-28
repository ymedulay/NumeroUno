<?php
$pageTitle = "Login Page";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle; ?></title>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/login-signin.css">
    <script>
        function switchLogin(type) {
            document.getElementById("login-title").textContent = type === 'applicant' ? "Applicant Login" : "Business Login";
            document.getElementById("forgot-password").href = type === 'applicant' ? "ApplicantForgotPassword.php" : "BusinessForgotPassword.php";

            document.querySelectorAll(".toggle-btn").forEach(btn => btn.classList.remove("active"));
            document.querySelector(`.toggle-btn[data-type='${type}']`).classList.add("active");
        }
    </script>
</head>

<body id="login-signin-page">
    <div class="container">
        <div class="login-card">
            <div class="top-section">
                <img src="assets/images/NumeroUnoLogo.png" alt="Numero Uno Logo">
            </div>
            <div class="toggle-buttons">
                <button onclick="switchLogin('applicant')" class="toggle-btn" data-type="applicant">Applicant Login</button>
                <button onclick="switchLogin('business')" class="toggle-btn" data-type="business">Business Login</button>
            </div>
            <form action="process_login.php" method="POST">
                <div class="input-group">
                    <h2 id="login-title">Welcome Back!</h2>
                    <label for="email">EMAIL</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="input-group">
                    <label for="password">PASSWORD</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="forgot-password">
                    <a id="forgot-password" href="#">Forgot Password?</a>
                </div>

                <button type="submit" class="submit-btn">LOG IN</button>

                <div class="separator">
                    <hr>
                    <span>or</span>
                    <hr>
                </div>

                <div class="social-signin-container">
                    <button type="button" class="social-signin google">
                        <img src="assets/images/GoogleLogo.png" alt="Google logo"> Continue with Google
                    </button>
                    <button type="button" class="social-signin facebook">
                        <img src="assets/images/FacebookLogo.png" alt="Facebook logo"> Continue with Facebook
                    </button>
                </div>

                <p class="signup-link">Don't have an account? <a href="AccountSelection.php">SIGN UP</a></p>
            </form>
        </div>
    </div>
</body>

</html>