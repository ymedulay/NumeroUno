<?php
session_start();
require_once 'config.php'; // Ensure this connects to your database

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}

$user_id = intval($_SESSION['user_id']);
$business_id = null;

try {
    // Fetch the business ID associated with the logged-in user
    $stmt = $pdo->prepare("SELECT id FROM Business WHERE userId = :user_id");
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $business_id = $row['id'];
        $_SESSION['business_id'] = $business_id; // Store in session
    } else {
        die("Error: No business profile found. You need to create a business profile first.");
    }
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

// Fetch job postings for this business
try {
    $stmt = $pdo->prepare("SELECT id, jobTitle FROM JobPosting WHERE businessId = :business_id");
    $stmt->bindParam(":business_id", $business_id, PDO::PARAM_INT);
    $stmt->execute();
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching jobs: " . $e->getMessage());
}

// Handle deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_job'])) {
    $job_id = $_POST['job_id'];
    try {
        $delete_stmt = $pdo->prepare("DELETE FROM JobPosting WHERE id = :job_id AND businessId = :business_id");
        $delete_stmt->bindParam(":job_id", $job_id, PDO::PARAM_INT);
        $delete_stmt->bindParam(":business_id", $business_id, PDO::PARAM_INT);
        $delete_stmt->execute();
        header("Location: BusinessDashPostManage.php"); // Refresh after delete
        exit();
    } catch (PDOException $e) {
        die("Error deleting job: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Management - NumeroUno</title>
    <link rel="icon" href="img/numerouno.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body id="business-dash-post-manage">

    <!-- Navbar -->
    <nav>
        <div class="logo">
            <img src="NumeroUnoLogo.png" alt="Numero Uno Logo">
        </div>
        <div class="nav-left">
            <ul class="nav-links">
                <li><a href="HomePage.html">Home</a></li>
                <li><a href="FindJobPage.html">Find Job</a></li>
            </ul>
        </div>
        <div class="nav-right">
            <ul class="nav-links">
                <li class="dropdown">
                    <i class="ph ph-user" onclick="toggleDropdown('userDropdown')"></i>
                    <ul class="dropdown-menu" id="userDropdown">
                        <li><a href="BusinessDashboard.php">My Dashboard</a></li>
                        <li><a href="BusinessDashManageProfile.php">Manage Profile</a></li>
                        <li><a href="#">Logout</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <i class="ph ph-gear" onclick="toggleDropdown('settingsDropdown')"></i>
                    <ul class="dropdown-menu" id="settingsDropdown">
                        <li><a href="AboutUs.html">About Us</a></li>
                        <li><a href="ContactUs.html">Contact Us</a></li>
                        <li><a href="FAQs.html">FAQs</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

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
    <div class="page-content">
        <div class="post-management">
            <h1>Post Management</h1>
            <h2>Jobs Posted</h2>

            <div class="job-postings">
                <?php if (!empty($jobs)): ?>
                    <?php foreach ($jobs as $job): ?>
                        <div class="job-container">
                            <div class="job-details">
                                <p class="company-name"><strong><?= htmlspecialchars($job['jobTitle']) ?></strong></p>
                            </div>
                            <div class="job-actions">
                                <a href="edit_job.php?id=<?= $job['id'] ?>" class="edit-btn">EDIT</a>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                                    <button type="submit" name="delete_job" class="delete-btn" onclick="return confirm('Are you sure you want to delete this job?');">DELETE</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No job postings available.</p>
                <?php endif; ?>
            </div>

            <h2>View Applicants</h2>
            <div class="job-container">
                <div class="job-details">
                    <p class="company-name"><strong>Application</strong></p>
                </div>
                <div class="job-actions">
                    <button class="view-btn">VIEW</button>
                </div>
            </div>

            <div class="job-container">
                <div class="job-details">
                    <p class="company-name"><strong>Application</strong></p>
                </div>
                <div class="job-actions">
                    <button class="view-btn">VIEW</button>
                </div>
            </div>
        </div>
    </div> <!-- End page content -->

    <script src="js/sidebar.js"></script>
    <script src="js/scroll.js"></script>

</body>

</html>