<?php
// Start the session
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] !== 1) { 
    // Redirect to login or another page if the user is not an admin (role_id = 1)
    header("Location: LoginPage.php");
    exit();
}

// Include the database connection file
require 'config.php'; // Or 'db_config.php' depending on your setup

// Handle delete action for deleting job posts
if (isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    $sqlDelete = "DELETE FROM JobPosting WHERE id = :id";
    $stmtDelete = $pdo->prepare($sqlDelete);
    $stmtDelete->bindParam(':id', $deleteId, PDO::PARAM_INT);
    if ($stmtDelete->execute()) {
        // Successfully deleted the job posting
        $_SESSION['success_message'] = "Job posting deleted successfully.";
    } else {
        $_SESSION['error_message'] = "Error deleting job posting.";
    }
    header("Location: AdminDashRejected.php");
    exit();
}

// Fetch rejected job postings (status = 'Rejected')
$sql = "SELECT * FROM JobPosting WHERE status = 'Rejected'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NumeroUno</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="./styles.css" rel="stylesheet">
</head>

<body id="admin-dash-reje">

    <!-- Navigation Bar -->
    <nav>
        <!-- Logo -->
        <div class="logo">
            <img src="NumeroUnoLogo.png" alt="Numero Uno Logo">
        </div>

        <!-- Left Navi Links (Home & Find Job) -->
        <div class="nav-left">
            <ul class="nav-links">
                <li><a href="HomePage.html">Home</a></li>
                <li><a href="AdminDashboardMain.php">Applications</a></li>
                <li><a href="AdminDashRepAndQue.php">Reports and Queries</a></li>
            </ul>
        </div>

        <!-- Right Navi Icons -->
        <div class="nav-right">
            <ul class="nav-links">
                <li class="dropdown">
                    <i class="ph ph-user" onclick="toggleDropdown('userDropdown')"></i>
                    <ul class="dropdown-menu" id="userDropdown">
                        <li><a href="LoginPage.html">Log-In</a></li>
                        <li><a href="AccountSelection.html">Sign-Up</a></li>
                        <li><a href="ApplicantDashboardManageProfile.html">My Account</a></li>
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
    <!-- End of Navi Bar -->

    <!-- Rejected Job Postings Section -->
    <div class="rejected-postings">
        <h2>Rejected</h2>

        <div class="job-postings">
            <?php if (count($result) > 0): ?>
                <?php foreach ($result as $row): ?>
                    <div class="job-container">
                        <i class="ph ph-user-circle"></i>
                        <div class="job-details">
                            <p class="company-name"><strong><?php echo htmlspecialchars($row['company_name']); ?></strong></p>
                            <p class="company-desc"><?php echo htmlspecialchars($row['company_description']); ?></p>
                            <p class="job-position">Open Job Position/s: <?php echo htmlspecialchars($row['job_position']); ?></p>
                        </div>
                        <div class="job-actions">
                            <form method="POST" action="AdminDashRejected.php">
                                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="delete-btn">DELETE</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No rejected job postings found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Show More Button -->
    <button id="show-more-btn-reje">Show More</button>

    <!-- JavaScript -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const jobPosts = document.querySelectorAll("#admin-dash-reje .job-container");
        const showMoreBtn = document.getElementById("show-more-btn-reje");

        if (jobPosts.length > 7) {
            for (let i = 7; i < jobPosts.length; i++) {
                jobPosts[i].classList.add("hidden");
            }

            showMoreBtn.addEventListener("click", function() {
                let hiddenPosts = document.querySelectorAll("#admin-dash-reje .hidden");
                let isHidden = hiddenPosts.length > 0;

                if (isHidden) {
                    hiddenPosts.forEach(post => post.classList.remove("hidden"));
                    this.textContent = "Show Less";
                } else {
                    for (let i = 7; i < jobPosts.length; i++) {
                        jobPosts[i].classList.add("hidden");
                    }
                    this.textContent = "Show More";
                }
            });
        } else {
            showMoreBtn.style.display = "none";
        }
    });
    </script>
</body>

</html>
