<?php
// Include your database configuration
require_once "config.php";

// Get application ID from the URL
if (isset($_GET['id'])) {
    $application_id = $_GET['id'];

    try {
        // SQL query to fetch application details, job details, and applicant details.
        $sql = "SELECT 
                    ja.*, 
                    jp.jobTitle AS jobTitle, 
                    jp.jobDescription AS jobDescription,
                    u.firstName AS firstName,
                    u.lastName AS lastName,
                    u.middle_initial AS mi,
                    u.email AS email,
                    u.contact_no AS contact_no,
                    u.gender AS gender,
                    u.address AS address
                FROM jobapplication ja
                JOIN jobposting jp ON ja.jobPostingId = jp.id
                JOIN user u ON ja.applicantId = u.id
                WHERE ja.id = :application_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':application_id', $application_id, PDO::PARAM_INT);
        $stmt->execute();

        $application = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$application) {
            echo "Application not found.";
            exit;
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }

} else {
    echo "Application ID not provided.";
    exit;
}

// Handle status update if action is provided in the URL
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // Validate action
    if ($action !== 'accept' && $action !== 'reject') {
        echo "Invalid action.";
        exit;
    }

    try {
        // Update the status in the database
        $status = ($action === 'accept') ? 'Accepted' : 'Rejected';
        $update_sql = "UPDATE jobapplication SET status = :status WHERE id = :application_id";
        $update_stmt = $pdo->prepare($update_sql);
        $update_stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $update_stmt->bindParam(':application_id', $application_id, PDO::PARAM_INT);

        if ($update_stmt->execute()) {
            // Redirect to the same page with a success message
            header("Location: view_application.php?id=$application_id&status_updated=true");
            exit;
        } else {
            echo "Error updating application status.";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Display status update message
if (isset($_GET['status_updated']) && $_GET['status_updated'] == 'true') {
    echo '<p class="success-message">Application status updated successfully.</p>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Application - NumeroUno</title>
    <link rel="icon" href="img/numerouno.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body id="view-application">

<!-- NEW NAV BAR -->
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
<!-- END OF NEW NAV BAR -->

<!-- SIDE BAR (RIGHT) -->
    <div id="sideMenu" class="sidebar">
        <ul>
            <li><a href="AboutUs.html">About Us</a></li>
            <li><a href="ContactUs.html">Contact Us</a></li>
            <li><a href="#">FAQS</a></li>
        </ul>
    </div>
<!-- END OF SIDE BAR (RIGHT) -->

<!-- SIDE BAR (LEFT) -->
    <div class="admin-sidebar">
        <p class="admin-dashb">Business Dashboard</p>
        <ul>
            <li><a href="BusinessDashboard.php">My Dashboard</a></li>
            <li><a href="BusinessDashManageProfile.php">Manage Business Profile</a></li>
            <li><a href="BusinessDashJobPost.php">Post Job Posting</a></li>
            <li><a href="BusinessDashPostManage.php">Post Management</a></li>
        </ul>
    </div>
<!-- END OF SIDE BAR (LEFT) -->

<!-- MAIN CONTENT -->
<div class="page-content">
        <h1>View Application</h1>
        
        <!-- APPLICANT INFO SECTION -->
        <div class="info-box">
            <h2>Applicant Information</h2>

            <div class="form-container">
                <!-- First Row -->
                <div class="form-row">
                    <label>First Name:</label>
                    <div class="input-line first-name"><?php echo htmlspecialchars($application['firstName']); ?></div>
                    <label class="second-label">Last Name:</label>
                    <div class="input-line last-name"><?php echo htmlspecialchars($application['lastName']); ?></div>
                    <label class="mi">MI:</label>
                    <div class="input-line mi"><?php echo htmlspecialchars($application['mi']); ?></div>
                </div>

                <!-- Second Row (Aligned Birthdate & Gender with Email & Phone Number) -->
                <div class="form-row">
                    <label>Birthdate:</label>
                    <div class="input-line"><?php echo isset($application['birthdate']) ? htmlspecialchars($application['birthdate']) : ''; ?></div>
                    <label class="second-label">Gender:</label>
                    <div class="input-line"><?php echo htmlspecialchars($application['gender']); ?></div>
                </div>

                <!-- Third Row -->
                <div class="form-row">
                    <label>Email Address:</label>
                    <div class="input-line"><?php echo htmlspecialchars($application['email']); ?></div>
                    <label class="second-label">Phone Number:</label>
                    <div class="input-line"><?php echo htmlspecialchars($application['contact_no']); ?></div>
                </div>

                <!-- Fourth Row (Retain Address) -->
                <div class="form-row">
                    <label>Address:</label>
                    <div class="input-line full"><?php echo htmlspecialchars($application['address']); ?></div>
                </div>
            </div>
        </div>

        <!-- APPLICATION DETAILS SECTION -->
        <div class="info-box">
            <h2>Application Details</h2>
            <p><strong>Job Applied:</strong> <?php echo htmlspecialchars($application['jobTitle']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($application['status']); ?></p>

            <!-- CENTERED Download Applicant's CV BUTTON -->
            <div class="button-container single-btn">
            <?php if (!empty($application['resume'])): ?>
                <a href="<?php echo htmlspecialchars($application['resume']); ?>" class="action-btn download" download>Download Applicant's CV</a>
            <?php endif; ?>
            </div>
        </div>

        

        <!-- ACCEPT AND REJECT BUTTON SECTION (WITH WHITE CONTAINER) -->
        <div class="decision-container">
            <p class="decision-text">Do you want to Accept or Reject the applicant?</p>
            <div class="button-container">
                <a href="view_application.php?id=<?php echo $application['id']; ?>&action=accept" class="action-btn accept">Accept</a>
                <a href="view_application.php?id=<?php echo $application['id']; ?>&action=reject" class="action-btn reject">Reject</a>
            </div>
        </div>
    </div>
<!-- END OF MAIN CONTENT -->

<footer class="footer">
		<p>Copyright © 2025, NumeroUno | All rights reserved</p>
	</footer>
    
    <script src="js/sidebar.js"></script>
    
</body>
</html>
