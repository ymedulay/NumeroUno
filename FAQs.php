<?php
session_start();
require_once "config.php";

// Check if user is logged in (but don't restrict access)
$isLoggedIn = isset($_SESSION['user_id']) && isset($_SESSION['role_id']);
$userRole = $isLoggedIn ? $_SESSION['role_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs - NumeroUno</title>
    <link rel="icon" href="img/numerouno.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body id="faqs-page">
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


    <!-- FAQ Content -->
    <div class="faq-header">
        <div class="faq-icon-container">
            <img src="img/FAQsIcon.png" alt="FAQ Icon">
        </div>

    <div class="faq-container">
        <h2>Frequently Asked Questions</h2>
        <div class="faq-item">
            <div class="faq-question">Can I apply for multiple jobs at the same time? <span>+</span></div>
            <div class="faq-content">Yes, you can apply for multiple jobs at the same time. There are no restrictions on the number of 
                job applications you can submit, allowing you to explore different opportunities that match your skills and interests.</div>
        </div>
        <div class="faq-item">
            <div class="faq-question">How do I delete my account? <span>+</span></div>
            <div class="faq-content">To delete your account, locate the User dropdown menu in the navigation bar, then go to 'My Account'and click 
                'Account Management' in the sidebar. This will direct you to your account recovery and account deletion. 
                Look for 'Account Deletion' and follow the steps.</div>
        </div>
        <div class="faq-item">
            <div class="faq-question">How does the website ensure the credibility of job postings? <span>+</span></div>
            <div class="faq-content">All job postings go through an admin approval process before they are published on the website. 
                This ensures that only legitimate and relevant job opportunities are made available to applicants. 
                Admins review each posting to verify its details and authenticity before approving it. </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">What are the requirements to create an account? <span>+</span></div>
            <div class="faq-content">To create an account, you only need a working email address. 
                After signing up, you can complete your profile by filling in your details through your dashboard.</div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Who do I contact for support? <span>+</span></div>
            <div class="faq-content">For support, you can reach out to us through our Contact Page. 
                Simply fill in the required details and hit <i>Send</i>, and our team will assist you as soon as possible.</div>
        </div>
    </div>

    <footer class="footer">
		<p>Copyright © 2025, NumeroUno | All rights reserved</p>
	</footer>

    <!-- Script for FAQ Expansion -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const faqItems = document.querySelectorAll(".faq-item");

            faqItems.forEach(item => {
                item.addEventListener("click", () => {
                    item.classList.toggle("active");
                    const content = item.querySelector(".faq-content");
                    if (item.classList.contains("active")) {
                        content.style.maxHeight = content.scrollHeight + "px";
                    } else {
                        content.style.maxHeight = "0";
                    }
                });
            });
        });

        function toggleDropdown(id) {
            document.querySelectorAll(".dropdown-menu").forEach(menu => {
                if (menu.id !== id) menu.classList.remove("show");
            });
            document.getElementById(id).classList.toggle("show");
        }

        window.onclick = function (event) {
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

    <script src="js/sidebar.js"></script>
</body>

</html>