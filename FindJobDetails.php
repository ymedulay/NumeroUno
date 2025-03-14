<?php
session_start();
require_once "config.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: LoginPage.html");
    exit();
}

$userId = $_SESSION['user_id'];
$jobPostingId = isset($_GET['id']) ? $_GET['id'] : null;

// Fetch user details from the database
$stmt = $pdo->prepare("SELECT id, firstName, lastName, email FROM user WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if user exists
if (!$user) {
    die("<p style='color: red;'>Error: User not found.</p>");
}

// Fetch job details
$job = null;
if ($jobPostingId) {
    $jobStmt = $pdo->prepare("SELECT jobTitle, jobDescription, salaryRange, employmentType, jobLocation, requireResume FROM jobposting WHERE id = ?");
    $jobStmt->execute([$jobPostingId]);
    $job = $jobStmt->fetch(PDO::FETCH_ASSOC);
}

// Check if job exists
if (!$job) {
    die("<p style='color: red;'>Error: Job not found or invalid job ID.</p>");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Job Application - NumeroUno</title>
    <link rel="icon" href="img/numerouno.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="./styles.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body id="find-job-deets">
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
            <li><a href="ApplicantDashboard.php">My Dashboard</a></li>
            <li><a href="AboutUs.php">About Us</a></li>
            <li><a href="ContactUs.php">Contact Us</a></li>
            <li><a href="FAQs.php">FAQs</a></li>
            <li><a href="logout.php">Log out</a></li>
        </ul>
    </div>
    </nav>

    <!-- End of Navigation Bar -->



    <div class="job-content-container">
        <div class="job-description-wrapper">
            <p class="job-details-title">
                <strong><?= htmlspecialchars($job['jobTitle']) ?></strong>
            </p>
            <p class="job-description"><?php echo htmlspecialchars($job['jobDescription']); ?></p>
            <?php if ($job['requireResume']) echo '<p class="cv-requirement">*This job requires a curriculum vitae (CV).</p>'; ?>
        </div>
    </div>

    <div class="other-details-wrapper">
        <p class="other-details-title">OTHER DETAILS</p>
        <div class="other-details-container">
            <div class="detail-box">
                <p class="detail-label">Hourly Pay</p>
                <p class="detail-text">₱<?php echo htmlspecialchars($job['salaryRange']); ?> / hour</p>
            </div>
            <div class="detail-box">
                <p class="detail-label">Job Type</p>
                <p class="detail-text"><?php echo htmlspecialchars($job['employmentType']); ?></p>
            </div>
            <div class="detail-box">
                <p class="detail-label">Location</p>
                <p class="detail-text"><?php echo htmlspecialchars($job['jobLocation']); ?></p>
            </div>
        </div>
    </div>

    <div class="application-form">
        <h2 class="form-title">JOB APPLICATION FORM</h2>
        <form action="submit_form.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="jobPostingId" value="<?php echo htmlspecialchars($jobPostingId); ?>">
            <input type="hidden" name="userId" value="<?php echo isset($user['id']) ? htmlspecialchars($user['id']) : ''; ?>">

            <!-- Name Fields (Read-Only) -->
            <div class="name-container">
                <div class="input-group-name">
                    <label for="first-name">First Name:</label>
                    <input type="text" value="<?php echo htmlspecialchars($user['firstName'] ?? ''); ?>" readonly>
                </div>
                <div class="input-group-name">
                    <label>Last Name:</label>
                    <input type="text" value="<?php echo htmlspecialchars($user['lastName'] ?? ''); ?>" readonly>
                </div>
            </div>

            <!-- Birthdate & Gender -->
            <div class="birth-gender-container">
                <div class="input-group-birthgender">
                    <label for="birthdate">Birthdate:</label>
                    <input type="date" id="birthdate" name="birthdate" required>
                </div>
                <div class="input-group-birthgender">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="" disabled selected>Select your gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="prefer-not">Prefer not to state</option>
                    </select>
                </div>
            </div>

            <!-- Contact Number & Email -->
            <div class="contact-email-container">
                <div class="input-group-contactemail">
                    <label for="contact-number">Contact Number:</label>
                    <input type="tel" id="contact-number" name="contact-number" pattern="[0-9]{11}" placeholder="e.g., 09123456789" required>
                </div>
                <div class="input-group-contactemail">
                    <label>Email Address:</label>
                    <input type="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" readonly>
                </div>
            </div>

            <!-- Home Address -->
            <div class="home-address-container">
                <div class="input-group-homeaddress">
                    <label for="home-address">Home Address:</label>
                    <input type="text" id="home-address" name="home-address" placeholder="Apartment/Building/House No., Street Name, Barangay, City" required>
                </div>
            </div>

            <!-- Job Type & Start Date -->
            <div class="jobtype-startdate-container">
                <div class="input-group-jobtype">
                    <label for="job-type">Job Type:</label>
                    <select id="job-type" name="job-type" required>
                        <option value="" disabled selected>Select job type</option>
                        <option value="part-time">Part-time</option>
                        <option value="full-time">Full-time</option>
                    </select>
                </div>
                <div class="input-group-jobtype">
                    <label for="start-date">Available Start Date:</label>
                    <input type="date" id="start-date" name="start-date" required>
                </div>
            </div>

            <!-- CV Upload -->
            <div class="cv-upload-container">
                <label for="cv-upload">Upload CV:</label>
                <input type="file" id="cv-upload" name="cv-upload" accept=".pdf,.doc,.docx" <?php echo $job['requireResume'] ? 'required' : ''; ?>>
            </div>

            <!-- Submit Button -->
            <div class="submit-container">
                <button class="submit-btn" type="submit">Submit</button>
            </div>
        </form>
    </div>

    <footer class="footer">
        <p>Copyright © 2025, NumeroUno | All rights reserved</p>
    </footer>

    <script src="js/sidebar.js"></script>
</body>

</html>