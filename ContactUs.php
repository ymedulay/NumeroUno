<?php
session_start();
require_once "config.php";

// Check if user is logged in (but don't restrict access)
$isLoggedIn = isset($_SESSION['user_id']) && isset($_SESSION['role_id']);
$userRole = $isLoggedIn ? $_SESSION['role_id'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $contact = isset($_POST["contact"]) ? $_POST["contact"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $message = isset($_POST["message"]) ? $_POST["message"] : "";


    $to = "ansatienza@mymail.mapua.edu.ph"; // RECIPIENT
    $subject = "New Contact Form Submission";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $body = "Name: $name\n";
    $body .= "Contact No.: $contact\n";
    $body .= "Email: $email\n";
    $body .= "Message: $message\n";

    if (mail($to, $subject, $body, $headers)) {
        echo "<script>alert('Message sent successfully!');</script>";
    } else {
        echo "<script>alert('Error sending message.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - NumeroUno</title>
    <link rel="icon" href="img/numerouno.png" type="image/x-icon">
    <link rel="icon" href="img/numerouno.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body id="contact-us-page">
    <!-- Navigation Bar -->
    <nav>
        <div class="logo">
            <a href="HomePage.php"><img src="img/numerouno.png" alt="Numero Uno Logo"></a>
        </div>

        <div class="nav-right">
            <!-- Correct Find Jobs Button -->
            <a href="FindJobPage.php" class="find-jobs-btn">Find Jobs</a>

            <!-- Menu Icon -->
            <div class="menu-icon">
                <i class="ph ph-list"></i>
            </div>
        </div>
    </nav>

        <!-- Sidebar (Initially Hidden) --> 
        <div id="sideMenu" class="sidebar">
        <ul>
            <?php
            // Determine the correct dashboard link based on user role
            $dashboardLink = "LoginPage.html"; // Default for guests

            if ($isLoggedIn) {
                switch ($userRole) {
                    case 1:
                        $dashboardLink = "AdminDashboardMain.php"; // Admin Dashboard
                        break;
                    case 2:
                        $dashboardLink = "BusinessDashboard.php"; // Business Dashboard
                        break;
                    case 3:
                        $dashboardLink = "ApplicantDashboard.php"; // Applicant Dashboard
                        break;
                }
            }
            ?>
            
            <!-- Dynamic Dashboard Link -->
            <li><a href="<?= $dashboardLink; ?>">My Dashboard</a></li>
            
            <li><a href="AboutUs.php">About Us</a></li>
            <li><a href="ContactUs.php">Contact Us</a></li>
            <li><a href="FAQs.php">FAQs</a></li>

            <?php if ($isLoggedIn): ?>
                <!-- For logged-in users -->
                <li><a href="logout.php">Log out</a></li>
            <?php else: ?>
                <!-- For guests -->
                <li><a href="LoginPage.html">Login / Sign Up</a></li>
            <?php endif; ?>
        </ul>
    </div> 

    
    <!-- End of Navigation Bar -->

    <h1><b> Get in Touch with Us!</b></h1>
    <div class="contact-map-wrapper">
        <div class="contact-container">
            <h2>Contact Us</h2>
            <p>Got a question?
                Leave us a message below.</p>
            <form action="" method="post">
                <label for="name">Name</label>
                <input type="text" id="name" placeholder="e.g., John Dela Cruz" required>

                <label for="contact">Contact No.</label>
                <input type="text" id="contact" placeholder="e.g., 09123456789" required>

                <label for="email">Email Address</label>
                <input type="email" id="email" placeholder="e.g., example@email.com" required>

                <label for="message">Message</label>
                <textarea id="message" rows="4" placeholder="Type your message here..." required></textarea>

                <button class="btn" type="submit">Submit your message</button>
            </form>
        </div>

        <div class="barangay-container">
            <h2>Call Us</h2>
            <p><i class="ph ph-phone"></i> 091234567</p>
            <h2>Email</h2>
            <p><i class="ph ph-envelope"></i> brgyconcepcionuno@yahoo.com</p>
            <h2>Visit Us</h2>
            <p><i class="ph ph-map-pin"></i> Concepcion Uno Barangay Hall, Molave St, Marikina, 1800 Metro Manila</p>
            <iframe class="embed-map"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3860.0493625715003!2d121.10447520000001!3d14.6531394!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b9bed8201ba1%3A0x113c8c2114eb3b6d!2sConcepcion%20Uno%20Barangay%20Hall%20(Marikina)!5e0!3m2!1sen!2sph!4v1739789587001!5m2!1sen!2sph"
                allowfullscreen="" loading="lazy"></iframe>

            <h2>Office Hours</h2>
            <ul>
                <li>Monday - Friday: 8:00 AM - 4:00 PM</li>
                <li>Saturday - Sunday: CLOSED</li>
            </ul>
        </div>
    </div>

    <footer class="footer">
		<p>Copyright © 2025, NumeroUno | All rights reserved</p>
	</footer>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const inputs = document.querySelectorAll("#contact-us-page .contact-container form input, #contact-us-page .contact-container form textarea");

            inputs.forEach(input => {
                input.addEventListener("focus", function () {
                    this.dataset.placeholder = this.placeholder;
                    this.placeholder = "";
                });

                input.addEventListener("blur", function () {
                    if (this.value.trim() === "") {
                        this.placeholder = this.dataset.placeholder;
                    }
                });
            });
        });
    </script>


    <script src="js/sidebar.js"></script>
</body>

</html>