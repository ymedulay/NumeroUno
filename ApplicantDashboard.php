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
	</nav>

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
                <img src="ProfilePic.jpg" alt="User Profile Picture">
                <h2>
                    <?php
                    // Display user name if session is set, otherwise show default
                    echo isset($_SESSION['username']) ? $_SESSION['username'] : 'User Name';
                    ?>
                </h2>
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
                <div class="profile-section">
                    <img src="ProfilePic.jpg" alt="User Profile Picture">
                    <h2><?php echo htmlspecialchars($firstName . " " . $lastName); ?></h2>
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
                <p><strong>First Name:</strong> <?php echo htmlspecialchars($firstName); ?></p>
                <p><strong>Middle Initial:</strong> <?php echo htmlspecialchars($middleInitial); ?></p>
                <p><strong>Last Name:</strong> <?php echo htmlspecialchars($lastName); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            </div>
    </div>

    <script src="js/sidebar.js"></script>
    <script src="js/scroll.js"></script>

</body>

</html>