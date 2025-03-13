<?php
// Start session to access user data
session_start();

// Include database configuration
require_once "config.php"; // Ensure this file correctly sets up $pdo

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Initialize variables
$jobTitle = $businessName = $description = $jobLocation = $salaryRange = $qualifications = $employmentType = "";
$requireResume = false;
$categories = isset($categories) ? $categories : "";
$categoryOther = isset($categoryOther) ? $categoryOther : "";
$success_message = $error_message = "";

// Get user ID from session
$userId = intval($_SESSION['user_id']);
$businessId = null;

// Debug: Check session ID
if ($userId == 0) {
    die("Error: Invalid session ID.");
}

try {
    // First, get the business ID associated with this user
    $stmt = $pdo->prepare("SELECT id, businessName FROM Business WHERE userId = :userId");
    $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $businessId = $row['id']; // Get the actual business ID
        $businessName = $row['businessName'];
    } else {
        $businessName = "No Business Profile Found";
        $error_message = "You need to create a business profile before posting jobs.";
        echo "Debug: No business found for user ID: " . $userId;
    }
} catch (PDOException $e) {
    $businessName = "Error retrieving business information";
    echo "Database Error: " . $e->getMessage();
}

// Process form when submitted
// Process form when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && $businessId !== null) {
    // Sanitize inputs
    $jobTitle = sanitize_input($_POST["jobTitle"]);
    $description = sanitize_input($_POST["description"]);
    $jobLocation = sanitize_input($_POST["jobLocation"]);
    $salaryRange = sanitize_input($_POST["salaryRange"]);
    $qualifications = sanitize_input($_POST["qualifications"]);
    $employmentType = sanitize_input($_POST["employmentType"]);
    $requireResume = isset($_POST["cvRequired"]) ? 1 : 0;

    // Process job categories (checkboxes)
    $categories = isset($_POST['jobCategories']) ? implode(",", $_POST['jobCategories']) : "";

    // Handle "Other" category
    $categoryOther = isset($_POST["categoryOther"]) ? sanitize_input($_POST["categoryOther"]) : "";

    // Validate required fields
    if (empty($jobTitle) || empty($description) || empty($qualifications)) {
        $error_message = "Job title, description, and qualifications are required.";
    } else {
        try {
            // Insert job posting into database
            $stmt = $pdo->prepare("
                INSERT INTO JobPosting (businessId, jobTitle, jobDescription, requirements, requireResume, status, 
                                       jobLocation, salaryRange, employmentType, category, categoryOther) 
                VALUES (:businessId, :jobTitle, :description, :qualifications, :requireResume, 'Pending Approval',
                       :jobLocation, :salaryRange, :employmentType, :category, :categoryOther)
            ");
            $stmt->bindParam(":businessId", $businessId, PDO::PARAM_INT);
            $stmt->bindParam(":jobTitle", $jobTitle, PDO::PARAM_STR);
            $stmt->bindParam(":description", $description, PDO::PARAM_STR);
            $stmt->bindParam(":qualifications", $qualifications, PDO::PARAM_STR);
            $stmt->bindParam(":requireResume", $requireResume, PDO::PARAM_BOOL);
            $stmt->bindParam(":jobLocation", $jobLocation, PDO::PARAM_STR);
            $stmt->bindParam(":salaryRange", $salaryRange, PDO::PARAM_STR);
            $stmt->bindParam(":employmentType", $employmentType, PDO::PARAM_STR);
            $stmt->bindParam(":category", $categories, PDO::PARAM_STR);
            $stmt->bindParam(":categoryOther", $categoryOther, PDO::PARAM_STR);
            $stmt->execute();

            header("Location: BusinessDashboard.php");
        } catch (PDOException $e) {
            $error_message = "Error posting job: " . $e->getMessage();
        }
    }
}


// Function to sanitize form inputs
function sanitize_input($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Job Postings - NumeroUno</title>
    <link rel="icon" href="img/numerouno.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body id="business-dash-job-post">

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
    <div class="main-content-wrapper">
        <div class="page-content">
            <h1>Post Job Postings</h1>

            <?php if (!empty($success_message)): ?>
                <div class="alert success">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
                <div class="alert error">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
        </div>

        <form class="profile-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-section-container">
                <h2>Job Information</h2>
                <div class="form-grid two-columns">
                    <div>
                        <label for="jobTitle">Job Title</label>
                        <input type="text" id="jobTitle" name="jobTitle" placeholder="Job Title" value="<?php echo $jobTitle; ?>" required>
                    </div>
                    <div>
                        <label for="businessName">Business Name</label>
                        <input type="text" id="businessName" name="businessName" placeholder="Business Name" value="<?php echo $businessName; ?>" required readonly>
                    </div>
                    <div>
                        <label for="description">Job Description:</label>
                        <textarea id="description" name="description" placeholder="Type your Job description here..." rows="4" required><?php echo $description; ?></textarea>
                        <label for="cvRequired">Check if CV is required</label>
                        <input type="checkbox" id="cvRequired" name="cvRequired" <?php echo $requireResume ? 'checked' : ''; ?>>
                    </div>
                    <div> <!-- pls edit styling-->
                        <label for="jobCategories">Category</label><br>

                        <input type="checkbox" id="Service" name="jobCategories[]" value="Service"
                            <?php echo (strpos($categories, 'Service') !== false) ? 'checked' : ''; ?>>
                        <label for="service">Service</label><br>

                        <input type="checkbox" id="Housework" name="jobCategories[]" value="Housework"
                            <?php echo (strpos($categories, 'Housework') !== false) ? 'checked' : ''; ?>>
                        <label for="housework">Housework</label><br>


                        <input type="checkbox" id="Others" name="jobCategories[]" value="Others"
                            <?php echo (strpos($categories, 'Others') !== false) ? 'checked' : ''; ?>>
                        <label for="others">Others</label><br>

                        <input type="text" id="categoryOther" name="categoryOther" placeholder="Specify other category"
                            value="<?php echo htmlspecialchars($categoryOther); ?>">
                    </div>

                </div>
            </div>

            <div class="form-section-container">
                <div class="form-grid two-columns">
                    <div>
                        <label for="jobLocation">Job Location</label>
                        <input type="text" id="jobLocation" name="jobLocation" placeholder="e.g Barangay Concepcion Uno, Marikina City" value="<?php echo $jobLocation; ?>" required>
                    </div>
                    <div>
                        <label for="salaryRange">Salary Range</label>
                        <input type="text" id="salaryRange" name="salaryRange" placeholder="₱10,000 - ₱15,000" value="<?php echo $salaryRange; ?>" required>
                    </div>
                    <div>
                        <label for="qualifications">Qualifications</label>
                        <textarea id="qualifications" name="qualifications" placeholder="Type your Job qualifications here..." rows="3" required><?php echo $qualifications; ?></textarea>
                    </div>
                    <div>
                        <label for="employmentType">Employment Type</label>
                        <select id="employmentType" name="employmentType" required>
                            <option value="" <?php echo empty($employmentType) ? 'selected' : ''; ?>>Select</option>
                            <option value="Full-Time" <?php echo $employmentType == 'Full-Time' ? 'selected' : ''; ?>>Full-Time</option>
                            <option value="Part-Time" <?php echo $employmentType == 'Part-Time' ? 'selected' : ''; ?>>Part-Time</option>
                            <option value="Contract" <?php echo $employmentType == 'Contract' ? 'selected' : ''; ?>>Contract</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="submit-btn">Post</button>
        </form>
    </div>

    <footer class="footer">
		<p>Copyright © 2025, NumeroUno | All rights reserved</p>
	</footer>

    <script src="js/sidebar.js"></script>
    <script src="js/scroll.js"></script>

</body>

</html>