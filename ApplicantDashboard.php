<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role_id'])) {
    die("Access Denied. Please log in.");
}

// Restrict access based on role
$roleId = $_SESSION['role_id'];
$pageRole = 3; // Change this based on the dashboard (1 = Admin, 2 = Applicant, 3 = Business)

if ($roleId != $pageRole) {
    echo "Access denied.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Dashboard - NumeroUno</title>
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body id="applicant-dash-main">
    <!-- Navigation Bar -->
    <nav>
        <div class="logo">
            <a href="HomePage.php"><img src="numerouno.png" alt="Numero Uno Logo"></a>
        </div>

        <div class="nav-right">
            <!-- Find Jobs Button -->
            <a href="#homepage-job-postings" class="find-jobs-btn">Find Jobs</a>

            <!-- Menu Icon -->
            <div class="menu-icon">
                <i class="ph ph-list"></i>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div id="sideMenu" class="sidebar">
        <ul>
            <li><a href="AboutUs.php">About Us</a></li>
            <li><a href="ContactUs.php">Contact Us</a></li>
            <li><a href="#">FAQs</a></li>
        </ul>
    </div>

    <!-- Applicant Dashboard Sidebar -->
    <div class="admin-sidebar">
        <p class="admin-dashb">Applicant Dashboard</p>
        <ul>
            <li><a href="ApplicantDashboard.php">My Dashboard</a></li>
            <li><a href="ApplicantDashboardManageProfile.php">Manage My Profile</a></li>
            <li><a href="ApplicantDashboardApplicationStatus.php">Application Status</a></li>
            <li><a href="ApplicantDashboardAccountManagement.php">Account Management</a></li>
        </ul>
    </div>

    <!-- Page Content -->
    <div class="page-content">
        <h1>Applicant Dashboard</h1>
        <div class="profile-section">
            <img src="ProfilePic.jpg" alt="User Profile Picture">
            <h2>
                <?php
                // Display user name if session is set, otherwise show default
                echo isset($_SESSION['username']) ? $_SESSION['username'] : 'User Name';
                ?>
            </h2>
        </div>

        <div class="info-section">
            <div class="info-box">
                <h2>User Information</h2>
                <div class="user-info-container">
                    <div class="user-info-left">
                        <p><strong>First Name:</strong> <?php echo $_SESSION['first_name'] ?? '[User First Name]'; ?></p>
                        <p><strong>Middle Initial:</strong> <?php echo $_SESSION['middle_initial'] ?? '[User Middle Initial]'; ?></p>
                    </div>
                    <div class="user-info-right">
                        <p><strong>Last Name:</strong> <?php echo $_SESSION['last_name'] ?? '[User Last Name]'; ?></p>
                        <p><strong>Email:</strong> <?php echo $_SESSION['email'] ?? '[User Email]'; ?></p>
                    </div>
                </div>
            </div>

            <div class="info-box">
                <h2>Educational Background</h2>
                <p><strong>Highest Degree:</strong> <?php echo $_SESSION['degree'] ?? '[User Degree]'; ?></p>
            </div>

            <div class="info-box">
                <h2>Job Experience</h2>
                <div class="user-info-container">
                    <div class="user-info-left">
                        <p><strong>Company:</strong> <?php echo $_SESSION['company'] ?? '[Company Name]'; ?></p>
                    </div>
                    <div class="user-info-right">
                        <p><strong>Job Title:</strong> <?php echo $_SESSION['job_title'] ?? '[Job Title]'; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="sidebar.js"></script>
</body>

</html>