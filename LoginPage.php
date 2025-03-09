<?php
    session_start(); // Start the session if needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="login-signin.css">
</head>
<body id="login-signin-page">
    <div class="container">
        <div class="login-card">
            <div class="top-section">
                <img src="NumeroUnoLogo.png" alt="Numero Uno Logo">
            </div>

            <!-- Display error message if exists -->
            <?php if (isset($_GET['error'])): ?>
                <div class="error-message" style="color: red;">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <form action="process_login.php" method="POST">
                <div class="input-group">
                    <h2 id="login-title">Account Login</h2>
                    <label for="email">EMAIL</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <div class="input-group">
                    <label for="password">PASSWORD</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
            
                <div class="forgot-password">
                    <a href="ForgotPassword.html" id="forgot-password">Forgot Password?</a>
                </div>
            
                <button type="submit" class="submit-btn">LOG IN</button>

                <div class="separator">
                    <hr>
                    <span>or</span>
                    <hr>
                </div>  

                <div class="social-signin-container">
                    <button type="button" class="social-signin google">
                        <img src="GoogleLogo.png" alt="Google logo"> Continue with Google
                    </button>
                    <button type="button" class="social-signin facebook">
                        <img src="FacebookLogo.png" alt="Facebook logo"> Continue with Facebook
                    </button>
                </div>

                <p class="signup-link">Don't have an account? <a href="./AccountSelection.html">SIGN UP</a></p>
            </form>
        </div>
    </div>

    <script>
        document.querySelector("form").addEventListener("submit", function(event) {
            console.log("Form submitted");
        });
    </script>
</body>
</html>
