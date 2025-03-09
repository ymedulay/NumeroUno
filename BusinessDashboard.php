<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role_id'])) {
    die("Access Denied. Please log in.");
}


// Restrict access based on role
$roleId = $_SESSION['role_id'];
$pageRole = 2; // Change this based on the dashboard (1 = Admin, 2 = Applicant, 3 = Business)

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
    <title>Business Dashboard - NumeroUno</title>
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>
<body id="business-dash-main">
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
                        <li><a href="BusinessDashboard.php">My Dashboard</a></li>
                        <li><a href="BusinessDashManageProfile.php">Manage Profile</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="admin-sidebar">
        <p class="admin-dashb">Business Dashboard</p>
        <ul>
            <li><a href="BusinessDashboard.php">My Dashboard</a></li>
            <li><a href="BusinessDashManageProfile.php">Manage Business Profile</a></li>
            <li><a href="BusinessDashJobPost.php">Post Job Posting</a></li>
            <li><a href="BusinessDashPostManage.php">Post Management</a></li>
        </ul>
    </div>

    <div class="page-content">
        <h1>Welcome, <?php echo $_SESSION['user_name']; ?>!</h1>
        <div class="profile-section">
            <img src="BusinessLogo.jpg" alt="Business Logo">
            <h2><?php echo $businessName; ?></h2>
        </div>
        <div class="info-section">
            <div class="info-box">
                <h2>Business Information</h2>
                <p><strong>Name:</strong> <?php echo $businessName; ?></p>
                <p><strong>Address:</strong> <?php echo $address; ?></p>
                <p><strong>Contact:</strong> <?php echo $contact; ?></p>
                <p><strong>Email:</strong> <?php echo $email; ?></p>
                <p><strong>Type:</strong> <?php echo $businessType; ?></p>
                <p><strong>Description:</strong> <?php echo $description; ?></p>
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

        window.onclick = function (event) {
            if (!event.target.matches('.ph')) {
                document.querySelectorAll(".dropdown-menu").forEach(menu => menu.classList.remove('show'));
            }
        };
    </script>
</body>
</html>
