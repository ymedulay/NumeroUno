<?php
session_start();
require_once 'config.php'; // Ensure this connects to your database

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: LoginPage.php"); // Redirect if not logged in
    exit();
}

$user_id = intval($_SESSION['user_id']);
$business_id = null;
$job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($job_id === 0) {
    die("Error: Job ID is missing.");
}

try {
    // Fetch the business ID associated with the logged-in user
    $stmt = $pdo->prepare("SELECT id, businessName FROM business WHERE userId = :user_id");
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $business_id = $row['id'];
        $_SESSION['business_id'] = $business_id;
    } else {
        die("Error: No business profile found. You need to create a business profile first.");
    }
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

// Fetch job details for editing
try {
    $stmt = $pdo->prepare("SELECT jobTitle, jobDescription, requirements, jobLocation, salaryRange, employmentType FROM jobposting WHERE id = :job_id AND businessId = :business_id");
    $stmt->bindParam(":job_id", $job_id, PDO::PARAM_INT);
    $stmt->bindParam(":business_id", $business_id, PDO::PARAM_INT);
    $stmt->execute();
    
    if ($stmt->rowCount() == 0) {
        die("Error: Job not found.");
    }

    $job = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching job details: " . $e->getMessage());
}

// Handle job update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jobTitle = trim($_POST['jobTitle']);
    $jobDescription = trim($_POST['description']);
    $jobLocation = trim($_POST['jobLocation']);
    $salaryRange = trim($_POST['salaryRange']);
    $qualifications = trim($_POST['qualifications']);
    $employmentType = trim($_POST['employmentType']);

    if (empty($jobTitle) || empty($jobDescription) || empty($qualifications)) {
        $error_message = "Job title, description, and qualifications are required.";
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE JobPosting SET jobTitle = :jobTitle, jobDescription = :description, requirements = :qualifications, jobLocation = :jobLocation, salaryRange = :salaryRange, employmentType = :employmentType WHERE id = :job_id AND businessId = :business_id");
            $stmt->bindParam(":jobTitle", $jobTitle, PDO::PARAM_STR);
            $stmt->bindParam(":description", $jobDescription, PDO::PARAM_STR);
            $stmt->bindParam(":qualifications", $qualifications, PDO::PARAM_STR);
            $stmt->bindParam(":jobLocation", $jobLocation, PDO::PARAM_STR);
            $stmt->bindParam(":salaryRange", $salaryRange, PDO::PARAM_STR);
            $stmt->bindParam(":employmentType", $employmentType, PDO::PARAM_STR);
            $stmt->bindParam(":job_id", $job_id, PDO::PARAM_INT);
            $stmt->bindParam(":business_id", $business_id, PDO::PARAM_INT);
            $stmt->execute();
            header("Location: BusinessDashPostManage.php");
            exit();
        } catch (PDOException $e) {
            $error_message = "Error updating job: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" id="edit-job-page">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job Posting - NumeroUno</title>
    <link rel="icon" href="img/numerouno.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

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

    <!-- Sidebar -->
    <div class="admin-sidebar">
        <p class="admin-dashb">Business Dashboard</p>
        <ul>
            <li><a href="BusinessDashboard.php">My Dashboard</a></li>
            <li><a href="BusinessDashManageProfile.php">Manage Business Profile</a></li>
            <li><a href="BusinessDashJobPost.php">Post Job Posting</a></li>
            <li><a href="BusinessDashPostManage.php">Post Management</a></li>
        </ul>
    </div>

    <!-- Main Content -->
     
<body>
    <div class="main-content-wrapper">
        <div class="page-content">
            <h1>Edit Job Posting</h1>
            <?php if (!empty($error_message)): ?>
                <div class="alert error">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
        </div>

<form class="profile-form" method="POST">
    <div class="form-section-container">
        <h3>Job Information</h3>
        <div class="form-grid">
            <div class="form-column">
                <div class="form-group">
                    <label for="jobTitle">Job Title</label>
                    <input type="text" id="jobTitle" name="jobTitle" value="<?php echo htmlspecialchars($job['jobTitle']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="jobLocation">Job Location</label>
                    <input type="text" id="jobLocation" name="jobLocation" value="<?php echo htmlspecialchars($job['jobLocation']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="salaryRange">Salary Range</label>
                    <input type="text" id="salaryRange" name="salaryRange" value="<?php echo htmlspecialchars($job['salaryRange']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="employmentType">Employment Type</label>
                    <select id="employmentType" name="employmentType" required>
                        <option value="Full-Time" <?php echo $job['employmentType'] == 'Full-Time' ? 'selected' : ''; ?>>Full-Time</option>
                        <option value="Part-Time" <?php echo $job['employmentType'] == 'Part-Time' ? 'selected' : ''; ?>>Part-Time</option>
                        <option value="Contract" <?php echo $job['employmentType'] == 'Contract' ? 'selected' : ''; ?>>Contract</option>
                    </select>
                </div>
            </div>
            <div class="form-column">
                <div class="form-group">
                    <label for="description">Job Description</label>
                    <textarea id="description" name="description" required><?php echo htmlspecialchars($job['jobDescription']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="qualifications">Qualifications</label>
                    <textarea id="qualifications" name="qualifications" required><?php echo htmlspecialchars($job['requirements']); ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="save-button">Update Job</button>
</form>
    </div>

    <footer class="footer">
		<p>Copyright © 2025, NumeroUno | All rights reserved</p>
	</footer>

    <script src="js/sidebar.js"></script>
</body>
</html>
