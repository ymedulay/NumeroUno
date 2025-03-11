<?php
// Start the session
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] !== 1) {
    // Redirect to login or another page if the user is not an admin (role_id = 1)
    header("Location: LoginPage.html");
    exit();
}

// Include the database connection file
require 'config.php';

$sql = "SELECT jp.*, b.businessName 
        FROM JobPosting jp
        INNER JOIN Business b ON jp.businessId = b.id
        WHERE jp.status = 'Open'";
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
    <link rel="icon" href="img/numerouno.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="./styles.css" rel="stylesheet">
</head>

<body id="admin-dash-appro">

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
			<li><a href="ContactUs.html">Contact Us</a></li>
			<li><a href="logout.php">Log out</a></li>
		</ul>
	</div>
	</nav>

	<!-- End of Navigation Bar -->

    <!-- Phosphor Icons CDN -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Hover area to trigger the sidebar (keep it very narrow) -->
    <div class="sidebar-hover-area"></div>

    <!-- Sidebar Container -->
    <div class="admin-sidebar">
        <p class="admin-dashb">Admin Dashboard</p>
        <ul>
            <li><a href="AdminDashboardMain.php">Pending Approval</a></li>
            <li><a href="AdminDashApproved.php">Approved</a></li>
            <li><a href="AdminDashRejected.php">Rejected</a></li>
        </ul>
    </div>

    <!-- Job Postings -->
    <div class="approved-postings">
        <h2>Approved</h2>

        <div class="job-postings">
            <?php
            // Check if there are any approved job postings
            if (count($result) > 0) {
                // Loop through each job posting and display them
                foreach ($result as $row) {
                    $businessName = $row['businessName'];
                    $companyDesc = $row['jobDescription'];
            ?>
                    <div class="job-container">
                        <i class="ph ph-user-circle"></i>
                        <div class="job-details">
                            <p class="company-name"><strong><?php echo htmlspecialchars($businessName); ?></strong></p>
                            <p class="company-desc"><?php echo htmlspecialchars($companyDesc); ?></p>
                            <p class="job-position">Open Job Position/s: <?php echo htmlspecialchars($row['jobPosition'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="job-actions">
                            <button class="accepted-btn">ACCEPTED</button>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p>No approved job postings available.</p>";
            }
            ?>

            <!-- Show More Button -->
            <button id="show-more-btn-appro">Show More</button>
        </div>
    </div>


    <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const jobPosts = document.querySelectorAll("#admin-dash-appro .job-container");
            const showMoreBtn = document.getElementById("show-more-btn-appro");

            if (jobPosts.length > 7) {
                for (let i = 7; i < jobPosts.length; i++) {
                    jobPosts[i].classList.add("hidden"); // Initially hide excess job posts
                }

                showMoreBtn.addEventListener("click", function() {
                    let hiddenPosts = document.querySelectorAll("#admin-dash-appro .hidden");
                    let isHidden = hiddenPosts.length > 0;

                    if (isHidden) {
                        hiddenPosts.forEach(post => post.classList.remove("hidden")); // Show all
                        this.textContent = "Show Less";
                    } else {
                        for (let i = 7; i < jobPosts.length; i++) {
                            jobPosts[i].classList.add("hidden"); // Hide excess
                        }
                        this.textContent = "Show More";
                    }
                });
            } else {
                showMoreBtn.style.display = "none"; // Hide the button if 7 or fewer job postings
            }
        });
    </script>

    <script src="js/sidebar.js"></script>
    <script src="js/scroll.js"></script>

</body>

</html>