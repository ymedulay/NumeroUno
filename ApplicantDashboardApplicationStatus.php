<?php
session_start();
require 'config.php'; // Database connection

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header(header: "Location: LoginPage.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch applied jobs for the logged-in user
$stmt = $pdo->prepare(query: "
    SELECT a.id, j.job_title, j.business_name, a.status
    FROM applications a
    JOIN jobs j ON a.job_id = j.id
    WHERE a.user_id = ?
    ORDER BY a.created_at DESC
");
$stmt->execute(params: [$user_id]);
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en" id="application-status-page">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status - NumeroUno</title>
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body>
    <!-- Navbar -->
    <nav>
        <div class="logo">
            <img src="NumeroUnoLogo.png" alt="Numero Uno Logo">
        </div>
        <div class="nav-left">
            <ul class="nav-links">
                <li><a href="HomePage.php">Home</a></li>
                <li><a href="FindJobPage.php">Find Job</a></li>
            </ul>
        </div>
        <div class="nav-right">
            <ul class="nav-links">
                <li class="dropdown">
                    <i class="ph ph-user" onclick="toggleDropdown('userDropdown')"></i>
                    <ul class="dropdown-menu" id="userDropdown">
                        <li><a href="ApplicantDashboard.php">My Dashboard</a></li>
                        <li><a href="ApplicantDashboardAccountManagement.php">Account Management</a></li>
                        <li><a href="Logout.php">Logout</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <i class="ph ph-gear" onclick="toggleDropdown('settingsDropdown')"></i>
                    <ul class="dropdown-menu" id="settingsDropdown">
                        <li><a href="AboutUs.php">About Us</a></li>
                        <li><a href="ContactUs.php">Contact Us</a></li>
                        <li><a href="FAQs.php">FAQs</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

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
                        <p class="job-title"><?= htmlspecialchars($app['job_title']) ?></p>
                        <p class="business-name"><?= htmlspecialchars($app['business_name']) ?></p>
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

    <script>
        function toggleDropdown(id) {
            let dropdown = document.getElementById(id);
            let allDropdowns = document.querySelectorAll('.dropdown-menu');
            allDropdowns.forEach(menu => {
                if (menu !== dropdown) menu.classList.remove("show");
            });
            dropdown.classList.toggle("show");
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
