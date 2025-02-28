<?php
// Start the session (if needed for user authentication later)
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Sign-Up</title>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/login-signin.css">
</head>

<body id="login-signin-page">
    <div class="container">
        <div class="signup-card">
            <div class="top-section">
                <img src="assets/images/NumeroUnoLogo.png" alt="Numero Uno Logo">
            </div>

            <form action="process_signup.php" method="POST">
                <h2 class="form-title">Create Applicant Account</h2>

                <div class="input-group">
                    <label for="fullname">FULL NAME</label>
                    <input type="text" name="fullname" id="fullname" placeholder="Enter your full name" required>
                </div>

                <div class="input-group">
                    <label for="email">EMAIL ADDRESS</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" required>
                </div>

                <div class="input-group">
                    <label for="password">PASSWORD</label>
                    <input type="password" name="password" id="password" placeholder="Create a password" required>
                </div>

                <button type="submit" class="submit-btn">CREATE ACCOUNT</button>

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

                <p class="login-link">Already have an account? <a href="=LoginPage.php">LOG IN</a></p>
            </form>
        </div>
    </div>
</body>

</html>