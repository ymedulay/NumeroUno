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

$sql = "SELECT firstName, middle_initial, lastName, email FROM user WHERE id = :userId";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $firstName = $user['firstName'];
    $lastName = $user['lastName'];
    $email = $user['email'];
    $middleInitial = $user['middleInitial'] ?? "N/A";
    $degree = $user['degree'] ?? "N/A";
    $company = $user['company'] ?? "N/A";
    $jobTitle = $user['jobTitle'] ?? "N/A";
} else {
    die("User not found.");
}

// Store full name in session for display in the UI
$_SESSION['user_name'] = $firstName . " " . $lastName;
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
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
        <div class="profile-section">
            <img src="ProfilePic.jpg" alt="User Profile Picture">
            <h2><?php echo htmlspecialchars($firstName . " " . $lastName); ?></h2>
        </div>
        <div class="info-section">
            <div class="info-box">
                <h2>User Information</h2>
                <p><strong>First Name:</strong> <?php echo htmlspecialchars($firstName); ?></p>
                <p><strong>Middle Initial:</strong> <?php echo htmlspecialchars($middleInitial); ?></p>
                <p><strong>Last Name:</strong> <?php echo htmlspecialchars($lastName); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
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
