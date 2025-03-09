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
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="admin-sidebar">
        <p class="admin-dashb">Applicant Dashboard</p>
        <ul>
            <li><a href="ApplicantDashboard.php">My Dashboard</a></li>
            <li><a href="ApplicantDashboardManageProfile.php">Manage My Profile</a></li>
            <li><a href="ApplicantDashboardApplicationStatus.php">Application Status</a></li>
            <li><a href="ApplicantDashboardAccountManagement.php">Account Management</a></li>
        </ul>
    </div>

    <div class="page-content">
        <h1>Welcome, <?php echo $_SESSION['user_name']; ?>!</h1>
        <div class="profile-section">
            <img src="ProfilePic.jpg" alt="User Profile Picture">
            <h2><?php echo $firstName . " " . $lastName; ?></h2>
        </div>
        <div class="info-section">
            <div class="info-box">
                <h2>User Information</h2>
                <p><strong>First Name:</strong> <?php echo $firstName; ?></p>
                <p><strong>Middle Initial:</strong> <?php echo $middleInitial; ?></p>
                <p><strong>Last Name:</strong> <?php echo $lastName; ?></p>
                <p><strong>Email:</strong> <?php echo $email; ?></p>
            </div>
            <div class="info-box">
                <h2>Educational Background</h2>
                <p><strong>Highest Degree:</strong> <?php echo $degree; ?></p>
            </div>
            <div class="info-box">
                <h2>Job Experience</h2>
                <p><strong>Company:</strong> <?php echo $company; ?></p>
                <p><strong>Job Title:</strong> <?php echo $jobTitle; ?></p>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown(id) {
            document.querySelectorAll(".dropdown-menu").forEach(menu => {
                if (menu.id !== id) menu.classList.remove("show");
            });
            document.getElementById(id).classList.toggle("show");
        }
    </script>
</body>
</html>
