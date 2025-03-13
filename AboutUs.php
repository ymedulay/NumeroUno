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
    <title>About Us - NumeroUno</title>
    <link rel="icon" href="img/numerouno.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
    <!-- Add AOS (Animate On Scroll) library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>

<body id="About-us-page">
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

    <section class="about-content">
        <div class="what-is">
            <img src="img/About us page-amico.png" alt="Illustration of people discussing" class="about-img"
                data-aos="fade-right" data-aos-duration="1200">
            <div class="text-1" data-aos="fade-left" data-aos-duration="1200" data-aos-delay="300">
                <h2>What is <span class="green-text">Numero</span><span class="yellow-text">UNO</span>?</h2>
                <p>Finding the right job can be challenging, especially when you're searching for opportunities close to
                    home. That's where
                    NumeroUno comes in—a user-friendly and community-focused job search platform designed to connect job
                    seekers with local
                    employment opportunities in Barangay Concepcion Uno, Marikina City.</p>
            </div>
        </div>
    </section>



    <section class="what-we-do">
        <div class="container">
            <h2 data-aos="fade-up" data-aos-duration="800">What We Do</h2>
            <p data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">At NumeroUno, we simplify the <b>job
                    hunting process</b> by providing an organized and accessible
                platform
                where job seekers can:</p>
            <div class="grid-container">
                <div class="grid-item" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="100">
                    <i class="ph ph-briefcase"></i>
                    <h3>Explore Job Listings</h3>
                    <p>Find jobs that match your skills, experience, and preferences.</p>
                </div>
                <div class="grid-item" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="300">
                    <i class="ph ph-file-arrow-up"></i>
                    <h3>Seamless Applications</h3>
                    <p>Apply for jobs with ease—just a few clicks and you're set.</p>
                </div>
                <div class="grid-item" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="500">
                    <i class="ph ph-bell"></i>
                    <h3>Stay Updated</h3>
                    <p>Get real-time notifications on the latest job openings.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="who-can-benefit">
        <div class="container">
            <h2>Who Can Benefit?</h2>
            <div class="steps-container">

                <!-- Left Side (Images) -->
                <div class="steps-images">
                    <img src="img/jobseek.png" alt="New Job Seekers">
                    <img src="img/worker.png" alt="Experienced Workers">
                    <img src="img/freelance.png" alt="Freelancers & Part-Timers">
                </div>

                <!-- Right Side (Step Text) -->
                <div class="steps-text">
                    <div class="step-box">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h3>New Job Seekers</h3>
                            <p>Fresh graduates looking to start their careers with local job opportunities.</p>
                        </div>
                    </div>

                    <div class="step-box">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h3>Experienced Workers</h3>
                            <p>Professionals searching for better career growth within their community.</p>
                        </div>
                    </div>

                    <div class="step-box">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h3>Freelancers & Part-Timers</h3>
                            <p>Individuals seeking flexible and remote job options for extra income.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="why-choose">
        <div class="container">
            <h2 data-aos="fade-up" data-aos-duration="1000">Why Choose <span class="green-text">Numero</span><span
                    class="yellow-text">Uno?</span></h2>
            <div class="grid-gallery">
                <div class="grid-item" data-aos="flip-up" data-aos-duration="800" data-aos-delay="100">
                    <img src="img/job.gif" alt="Local Jobs" class="animated-icon">
                    <h3>Local-Focused</h3>
                    <p>We bring <strong>Marikina-based</strong> job opportunities straight to you.</p>
                </div>
                <div class="grid-item" data-aos="flip-up" data-aos-duration="800" data-aos-delay="300">
                    <img src="img/application.gif" alt="Easy Applications" class="animated-icon">
                    <h3>Hassle-Free Applications</h3>
                    <p>Apply for jobs quickly, without unnecessary steps.</p>
                </div>
                <div class="grid-item" data-aos="flip-up" data-aos-duration="800" data-aos-delay="500">
                    <img src="img/Mail.gif" alt="Notifications" class="animated-icon">
                    <h3>Real-Time Updates</h3>
                    <p>Get notified about <strong>new job openings</strong> in your area.</p>
                </div>
                <div class="grid-item" data-aos="flip-up" data-aos-duration="800" data-aos-delay="700">
                    <img src="img/employer.gif" alt="Employer Support" class="animated-icon">
                    <h3>Support for Employers</h3>
                    <p>Businesses can post job openings and connect with qualified applicants efficiently.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="About-us-page">
        <div class="creator-info">
            <h2 data-aos="fade-up" data-aos-duration="1000">Who Made <span class="green-text">Numero</span><span
                    class="yellow-text">UNO</span>?</h2>
            <div class="team-grid">
                <div class="team-member" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                    <img src="img/NumeroUno_Dulay.jpg" alt="Team Member 1" class="profile-pic">
                    <h3>Ylanna Dulay</h3>
                </div>
                <div class="team-member" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    <img src="img/NumeroUno_Cruz.jpg" alt="Team Member 2" class="profile-pic">
                    <h3>Samantha Cruz</h3>
                </div>
                <div class="team-member" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                    <img src="img/NumeroUno_Sagadal.jpg" alt="Team Member 3" class="profile-pic">
                    <h3>Princess Sagadal</h3>
                </div>
                <div class="team-member" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                    <img src="img/NumeroUno_Atienza.jpg" alt="Team Member 4" class="profile-pic">
                    <h3>Arriane Atienza</h3>
                </div>
                <div class="team-member" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
                    <img src="img/NumeroUno_Maglalang.jpg" alt="Team Member 5" class="profile-pic">
                    <h3>Thomas Maglalang</h3>
                </div>
                <div class="team-member" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">
                    <img src="img/NumeroUno_De La Llave.jpg" alt="Team Member 6" class="profile-pic">
                    <h3>Kyle De La Llave</h3>
                </div>
            </div>
            <p class="team-description" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="700">
                We are students from <b>Mapúa University</b>, passionate about technology and innovation.
                Our goal is to create meaningful solutions that help our community.
                <b>NumeroUno</b> was developed with the vision of connecting job seekers with local opportunities
                in Marikina City.
            </p>
        </div>
    </section>

    <footer class="footer">
        <p>Copyright © 2025, NumeroUno | All rights reserved</p>
    </footer>

    <script src="js/sidebar.js"></script>
    <script src="js/whocanbenefit.js"></script>

    <!-- Animation initialization script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
            AOS.init({
                once: true // whether animation should happen only once
            });

            // Add custom animations for icons
            const icons = document.querySelectorAll('#About-us-page .grid-item i');
            icons.forEach(icon => {
                icon.classList.add('pulse-icon');
            });

            // Add hover animation to team member profiles
            const profilePics = document.querySelectorAll('.profile-pic');
            profilePics.forEach(pic => {
                pic.addEventListener('mouseenter', function() {
                    this.classList.add('rotate-profile');
                });
                pic.addEventListener('mouseleave', function() {
                    this.classList.remove('rotate-profile');
                });
            });
        });
    </script>

</body>

</html>