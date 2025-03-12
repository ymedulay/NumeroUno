<?php
session_start();
require_once "config.php";

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role_id'])) {
    die("Access Denied. Please log in.");
}

// Restrict access based on role
$roleId = $_SESSION['role_id'];
$pageRole = 3; // Role ID for applicants

if ($roleId != $pageRole) {
    echo "Access denied.";
    exit();
}

// Fetch user data from the database
$userId = $_SESSION['user_id'];

// Fetch applied jobs for the logged-in user
$stmt = $pdo->prepare("
    SELECT ja.id, jp.jobTitle, b.businessName, ja.status
    FROM jobapplication ja
    JOIN jobposting jp ON ja.jobPostingId = jp.id
    JOIN business b ON jp.businessId = b.id
    WHERE ja.applicantId = ?
    ORDER BY ja.dateApplied DESC
");
$stmt->execute([$userId]);
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en" id="application-status-page">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status - NumeroUno</title>
    <link rel="icon" href="img/numerouno.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body>
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
    <nav>
	<div id="sideMenu" class="sidebar">
		<ul>
			<li><a href="AboutUs.php">About Us</a></li>
			<li><a href="ContactUs.php">Contact Us</a></li>
            <li><a href="FAQs.php">FAQs</a></li>
			<li><a href="logout.php">Log out</a></li>
		</ul>
	</div>
	</nav>

	<!-- End of Navigation Bar -->

    <!-- Sidebar -->
    <div class="admin-sidebar">
        <p class="admin-dashb">Applicant Dashboard</p>
        <ul>
            <li><a href="ApplicantDashboard.php">My Dashboard</a></li>
            <li><a href="ApplicantDashboardManageProfile.php">Manage My Profile</a></li>
            <li><a href="ApplicantDashboardApplicationStatus.php">Application Status</a></li>
            <li><a href="ApplicantDashboardAccountManagement.php">Account Management</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content-wrapper">
        <h2>Applied Jobs</h2>

        <?php if (count($applications) > 0): ?>
            <?php foreach ($applications as $app): ?>
                <div class="application-card">
                    <div class="job-image-placeholder"></div>
                    <div class="job-info">
                        <p class="job-title"><?= htmlspecialchars($app['jobTitle']) ?></p>
                        <p class="business-name"><?= htmlspecialchars($app['businessName']) ?></p>
                        <div class="application-status">
                            <p>Application Status</p>
                            <span class="status-indicator <?= strtolower($app['status']) ?>">● <?= strtoupper($app['status']) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No applications found.</p>
        <?php endif; ?>
    </div>

    <script src="js/sidebar.js"></script>
</body>

</html>