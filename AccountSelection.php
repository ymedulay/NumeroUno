<?php
session_start();
require_once 'config.php'; // Include database connection

// Redirect if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: HomePage.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Type Selection - NumeroUno</title>
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body id="account-selection-page">

    <h1>WHAT ARE YOU APPLYING FOR?</h1>

    <div class="container">
        <div class="option-box">
            <a href="SignUpApplicant.php" class="option">
                <img src="Applicant.png" alt="Job Seeker">
            </a>
            <div class="label">I am a job seeker.</div>
        </div>

        <div class="option-box">
            <a href="SignUpBusiness.php" class="option">
                <img src="BusinessOwner.png" alt="Business Owner">
            </a>
            <div class="label">I am a business owner.</div>
        </div>
    </div>

    <script>
        function toggleDropdown(id) {
            document.querySelectorAll(".dropdown-menu").forEach(menu => {
                if (menu.id !== id) menu.classList.remove("show");
            });
            document.getElementById(id).classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.ph')) {
                let dropdowns = document.getElementsByClassName("dropdown-menu");
                for (let i = 0; i < dropdowns.length; i++) {
                    let openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        };
    </script>

</body>

</html>
