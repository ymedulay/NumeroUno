<?php
session_start();
require_once "config.php"; // Ensure database connection is included

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role_id'])) {
    die("Access Denied. Please log in.");
}

// Restrict access based on role
$roleId = $_SESSION['role_id'];
$pageRole = 2;

if ($roleId != $pageRole) {
    echo "Access denied.";
    exit();
}

// Fetch business details
$user_id = $_SESSION['user_id'];
$sql = "SELECT businessName, contactEmail, phoneNumber, address, businessType, description  
        FROM business 
        WHERE userId = :userId";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":userId", $user_id, PDO::PARAM_INT);
$stmt->execute();
$business = $stmt->fetch(PDO::FETCH_ASSOC);

// Assign fetched values to variables
$businessName = $business['businessName'] ?? "Unknown";
$address = $business['address'] ?? "Not provided";
$contact = $business['phoneNumber'] ?? "Not provided";
$email = $business['contactEmail'] ?? "Not provided";
$businessType = $business['businessType'] ?? "N/A";
$description = $business['description'] ?? "No description available";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Dashboard - NumeroUno</title>
    <link rel="icon" href="img/numerouno.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body id="business-dash-main">
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
			<li><a href="AboutUs.php">About Us</a></li>
			<li><a href="ContactUs.php">Contact Us</a></li>
            <li><a href="FAQs.php">FAQs</a></li>
			<li><a href="logout.php">Log out</a></li>
		</ul>
	</div>
	</nav>

	<!-- End of Navigation Bar -->

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
        <h1>Welcome, <?php echo htmlspecialchars($businessName); ?>!</h1>
        <div class="info-section">
            <div class="info-box">
                <h2>Business Information</h2>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($businessName); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>
                <p><strong>Contact:</strong> <?php echo htmlspecialchars($contact); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Type:</strong> <?php echo htmlspecialchars($businessType); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($description); ?></p>
            </div>
        </div>
    </div>

    <footer class="footer">
		<p>Copyright © 2025, NumeroUno | All rights reserved</p>
	</footer>

    <script src="js/sidebar.js"></script>
    
</body>

</html>