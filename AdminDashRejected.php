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

    // Fetch rejected job postings (status = 'Rejected')
    // Fetch rejected job postings (status = 'Rejected')
    $sql = "SELECT j.*, b.businessName as company_name, b.description as company_description 
            FROM JobPosting j
            JOIN Business b ON j.businessId = b.id
            WHERE j.status = 'Rejected'";
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

<body id="admin-dash-reje">
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
                            <p class="job-position"><?php echo htmlspecialchars($row['jobTitle'] ?? 'N/A'); ?></p>
                            <p class="company-desc"><?php echo htmlspecialchars($row['jobDescription']); ?></p>
                        </div>
                        <div class="job-actions">
                            <button class="rejected-btn">REJECTED</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No rejected job postings found.</p>
            <?php endif; ?>
        </div>
    </div>

    <footer class="footer">
		<p>Copyright © 2025, NumeroUno | All rights reserved</p>
	</footer>

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

    <script src="js/sidebar.js"></script>
    <script src="js/scroll.js"></script>
</body>

</html>