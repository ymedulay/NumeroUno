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

    $sql = "SELECT firstName, middle_initial, lastName, email, contact_no FROM user WHERE id = :userId";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $firstName = $user['firstName'];
        $lastName = $user['lastName'];
        $email = $user['email'];
        $middleInitial = $user['middle_initial'] ?? "N/A";
        $applicantNo = $user['contact_no'];
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
    <link rel="icon" href="img/numerouno.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body id="applicant-dash-main">
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
			<li><a href="AboutUs.html">About Us</a></li>
			<li><a href="ContactUs.php">Contact Us</a></li>
			<li><a href="logout.php">Log out</a></li>
		</ul>
	</div>

	<!-- End of Navigation Bar -->

    <div class="sidebar-hover-area"></div>
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
                <h2>
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
                </h2>
            </div>

                <div class="info-section">
                    <div class="info-box">
                        <h2>User Information</h2>
                            <div class="user-info-container">
                            <div class="user-info-left">
                                <p><strong>First Name:</strong> <?php echo htmlspecialchars($firstName); ?></p>
                                <p><strong>Middle Initial:</strong> <?php echo htmlspecialchars($middleInitial); ?></p>
                            </div>
                            <div class="user-info-right">
                                <p><strong>Last Name:</strong> <?php echo htmlspecialchars($lastName); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                                <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($applicantNo); ?></p>
                            </div>
                    </div>
    </div>

    <script src="js/sidebar.js"></script>

</body>

</html>