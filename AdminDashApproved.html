<?php
// Start the session and include database connection
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] !== 1) {
    header("Location: LoginPage.php");
    exit();
}

require 'config.php';  // Include database connection

// Handle Create Job Posting (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'create') {
    $businessName = $_POST['business_name'];
    $companyDesc = $_POST['company_desc'];
    $jobPosition = $_POST['job_position'];

    // Insert job posting into the database
    $sql = "INSERT INTO JobPosting (business_name, company_desc, job_position, status) VALUES (?, ?, ?, 'Open')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$businessName, $companyDesc, $jobPosition]);

    header("Location: AdminDashboardMain.php");
    exit();
}

// Handle Edit Job Posting (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $jobId = $_POST['job_id'];
    $businessName = $_POST['business_name'];
    $companyDesc = $_POST['company_desc'];
    $jobPosition = $_POST['job_position'];

    // Update job posting in the database
    $sql = "UPDATE JobPosting SET business_name = ?, company_desc = ?, job_position = ? WHERE job_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$businessName, $companyDesc, $jobPosition, $jobId]);

    header("Location: AdminDashboardMain.php");
    exit();
}

// Handle Delete Job Posting (GET request)
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $jobId = $_GET['id'];

    // Delete job posting from the database
    $sql = "DELETE FROM JobPosting WHERE job_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$jobId]);

    header("Location: AdminDashboardMain.php");
    exit();
}

// Fetch approved job postings (status = 'Open')
$sql = "SELECT * FROM JobPosting WHERE status = 'Open'";
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

<body id="admin-dash-appro">

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
                <li><a href="AdminDashboardMain.html">Applications</a></li>
				<li><a href="AdminDashRepAndQue.html">Reports and Queries</a></li>
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

    <!-- Phosphor Icons CDN -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Dropdown Toggle Script -->
    <script>
        function toggleDropdown(id) {
		document.querySelectorAll(".dropdown-menu").forEach(menu => {
			if (menu.id !== id) menu.classList.remove("show");
		});
		document.getElementById(id).classList.toggle("show");
	}


       // Close dropdown if user clicks outside
		window.onclick = function(event) {
			if (!event.target.matches('.ph, .ph *')) {  // Adjust to allow clicking on the icon itself
				let dropdowns = document.getElementsByClassName("dropdown-menu");
				for (let i = 0; i < dropdowns.length; i++) {
					let openDropdown = dropdowns[i];
					if (openDropdown.classList.contains('show')) {
						openDropdown.classList.remove('show');
					}
				}
			}
		}
    </script>

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
                    $businessName = $row['business_name'];  // Assuming there's a business_name column
                    $companyDesc = $row['company_desc'];    // Assuming there's a company_desc column
                    $jobPosition = $row['job_position'];    // Assuming there's a job_position column
            ?>
                <div class="job-container">
                    <i class="ph ph-user-circle"></i>
                    <div class="job-details">
                        <p class="company-name"><strong><?php echo htmlspecialchars($businessName); ?></strong></p>
                        <p class="company-desc"><?php echo htmlspecialchars($companyDesc); ?></p>
                        <p class="job-position">Open Job Position/s: <?php echo htmlspecialchars($jobPosition); ?></p>
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
	
</body>
</html>
