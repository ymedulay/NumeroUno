<?php
session_start();
require_once "config.php";

// Check if user is logged in (but don't restrict access)
$isLoggedIn = isset($_SESSION['user_id']) && isset($_SESSION['role_id']);
$userRole = $isLoggedIn ? $_SESSION['role_id'] : null;


	require_once 'config.php'; // Include database connection

	try {
		$stmt = $pdo->prepare("SELECT jp.id, jp.jobTitle, b.businessName, jp.jobLocation 
							FROM jobposting jp
							JOIN business b ON jp.businessId = b.id
							WHERE jp.status = 'Open'
							ORDER BY jp.datePosted DESC
							LIMIT 3");

		$stmt->execute(); // Execute the query
		$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		die("Database error: " . $e->getMessage());
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>NumeroUno</title>
	<link rel="icon" href="img/numerouno.png" type="image/x-icon">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
	<link href="./styles.css" rel="stylesheet">
</head>

<body id="homePage" class="home-page">
	<!-- Navigation Bar -->
	<nav>
		<div class="logo">
			<a href="HomePage.php"><img src="img/numerouno.png" alt="Numero Uno Logo"></a>
		</div>

		<div class="nav-right">
			<!-- Correct Find Jobs Button -->
			<a href="#homepage-job-postings" class="find-jobs-btn">Find Jobs</a>

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

	<!-- Phosphor Icons CDN -->
	<script src="https://unpkg.com/@phosphor-icons/web"></script>

	<!-- Hero Wrapper (Applies background image to both hero section + 3 box) -->
	<div class="hero-wrapper">
		<!-- Hero Section -->
		<div class="hero-section">
			<!-- Text Section -->
			<div class="hero-text">
				<p class="intro">Introducing</p>
				<h2><span class="green">Numero</span><span class="uno">UNO</span></h2>
				<p class="description">NumeroUno is a user-friendly job search platform designed to connect job seekers
					with opportunities in their local community. Specifically catered to residents of Barangay
					Concepcion Uno, Marikina City,
					NumeroUno aims to provide a seamless and efficient way to explore job listings, apply with ease,
					and stay updated on the latest job openings.Whether you're looking for your first job, a change of
					career, or freelance work,
					our platform makes job hunting more accessible and hassle-free for everyone. Sign up today and
					start your job search journey with NumeroUno!</p>
			</div>
			<!-- Image Section -->
			<div class="hero-image">
				<img src="img/numerouno.png" alt="Job Hunt Image">
			</div>
		</div>

		<!-- Search Box (with form to submit search) -->
		<form id="searchForm" action="FindJobPage.php" method="GET">
			<div class="main-container">
				<div class="search-box-container">
					<i class="ph ph-magnifying-glass"></i>
					<input type="text" class="search-box" name="search" placeholder="What job are you looking for?">
				</div>
				<div class="search-box-container">
					<i class="ph ph-navigation-arrow"></i>
					<input type="text" class="search-box" name="location" placeholder="Location">
				</div>
			</div>
		</form>
	</div>
<!-- End of Search Box -->

	<!-- How It Works Section -->
	<div class="how-it-works">
		<div class="how-it-works-container">
			<h2>How It Works</h2>
			<div class="steps-container">
				<div class="step">
					<i class="ph ph-user-plus"></i>
					<h3>1. Sign Up</h3>
					<p>Create an account to get started.</p>
				</div>
				<div class="step">
					<i class="ph ph-magnifying-glass"></i>
					<h3>2. Search Jobs</h3>
					<p>Browse job listings that match your skills.</p>
				</div>
				<div class="step">
					<i class="ph ph-paper-plane"></i>
					<h3>3. Apply</h3>
					<p>Submit applications to your preferred jobs.</p>
				</div>
				<div class="step">
					<i class="ph ph-handshake"></i>
					<h3>4. Get Hired</h3>
					<p>Connect with employers and start working!</p>
				</div>
			</div>
		</div>
	</div>
	<!-- End of How It Works Section -->


	<!-- Recent Job Postings -->
	<div id="homepage-job-postings" class="homepage-job-postings">
    <h2>Recently Posted Jobs</h2>
    <div class="job-postings-grid">
        <?php if (!empty($jobs)): ?>
            <?php
            // Limit the jobs array to the first 3 elements
            $limitedJobs = array_slice($jobs, 0, 3);
            ?>
            <?php foreach ($limitedJobs as $job): ?>
                <a href="FindJobDetails.php?id=<?= $job['id'] ?>" class="job-card-link">
                    <div class="job-card">
                        <h3><?= htmlspecialchars($job['jobTitle']) ?></h3>
                        <p><?= htmlspecialchars($job['businessName']) ?></p>
                        <p>📍 <?= htmlspecialchars($job['jobLocation']) ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No job postings available.</p>
        <?php endif; ?>
    </div>
    <a href="FindJobPage.php"><button class="view-more">View More Jobs</button></a>
</div>


	<footer class="footer">
		<p>Copyright © 2025, NumeroUno | All rights reserved</p>
	</footer>

	<script src="js/sidebar.js"></script>
	<script src="js/enter.js"></script>
</body>

</html>

