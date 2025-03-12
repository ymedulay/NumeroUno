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
    <title>Contact Us - NumeroUno</title>
    <link rel="icon" href="img/numerouno.png" type="image/x-icon">
    <link rel="icon" href="img/numerouno.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body id="contact-us-page">
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
            <li><a href="LoginPage.html">Login / Sign Up</a></li>
            <li><a href="AboutUs.html">About Us</a></li>
            <li><a href="ContactUs.php">Contact Us</a></li>
            <li><a href="FAQs.html">FAQS</a></li>
        </ul>
    </div>

<body>
    <h2>Applicant Details</h2>
    <p><strong>Job Title:</strong> <?php echo htmlspecialchars($application['jobTitle']); ?></p>
    <p><strong>Job Description:</strong> <?php echo htmlspecialchars($application['jobDescription']); ?></p>
    
    <h3>Applicant Information</h3>
    <p><strong>First Name:</strong> <?php echo htmlspecialchars($application['firstName']); ?></p>
    <p><strong>Last Name:</strong> <?php echo htmlspecialchars($application['lastName']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($application['email']); ?></p>
    <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($application['contact_no']); ?></p>
    <p><strong>Gender:</strong> <?php echo htmlspecialchars($application['gender']); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($application['address']); ?></p>

    <?php if (!empty($application['cvFilename'])): ?>
        <p><strong>Resume:</strong> <a href="uploads/<?php echo htmlspecialchars($application['cvFilename']); ?>" target="_blank">Download</a></p>
    <?php endif; ?>

    <div class="application-actions">
        <form method="post" action="update_application_status.php">
            <input type="hidden" name="application_id" value="<?php echo htmlspecialchars($application['id']); ?>">
            <button type="submit" name="action" value="accept" class="accept-btn">Accept</button>
            <button type="submit" name="action" value="reject" class="reject-btn">Reject</button>
        </form>
    </div>

    <a href="BusinessDashboard.php">Back to Dashboard</a>

    <script src="js/sidebar.js"></script>
    <script src="js/scroll.js"></script>
</body>
</html>