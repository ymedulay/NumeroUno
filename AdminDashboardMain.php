<?php
session_start();

// Session validation
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role_id'])) {
    die("Access Denied. Please log in.");
}

// Restrict access based on role
$roleId = $_SESSION['role_id'];
$pageRole = 1; // Change this based on the dashboard (1 = Admin, 2 = Applicant, 3 = Business)

if ($roleId != $pageRole) {
    echo "Access denied.";
    exit();
}

// Include database configuration
require_once 'config.php';

// Function to get pending job postings from the database
function getPendingJobPostings($pdo) {
    try {
        $query = "SELECT j.id, c.name AS company_name, c.description, j.title AS job_position
                  FROM jobs j
                  JOIN companies c ON j.company_id = c.id
                  WHERE j.status = 'pending'
                  ORDER BY j.created_at DESC";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Log error
        error_log("Database error: " . $e->getMessage());
        return [];
    }
}

// Get pending job postings
$pendingJobs = getPendingJobPostings($pdo);

// Process form submission if this page is posted to
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job_id']) && isset($_POST['action'])) {
    $jobId = intval($_POST['job_id']);
    $action = $_POST['action'];
    
    if ($action === 'accept' || $action === 'reject') {
        $newStatus = ($action === 'accept') ? 'approved' : 'rejected';
        
        try {
            // Begin transaction
            $pdo->beginTransaction();
            
            // Update job status
            $query = "UPDATE jobs SET status = :status, updated_at = NOW() WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':status', $newStatus, PDO::PARAM_STR);
            $stmt->bindParam(':id', $jobId, PDO::PARAM_INT);
            $stmt->execute();
            
            // Log the admin action
            $adminId = $_SESSION['user_id'];
            $logQuery = "INSERT INTO admin_logs (admin_id, action, job_id, action_time) 
                         VALUES (:admin_id, :action, :job_id, NOW())";
            $logStmt = $pdo->prepare($logQuery);
            $logStmt->bindParam(':admin_id', $adminId, PDO::PARAM_INT);
            $logStmt->bindParam(':action', $action, PDO::PARAM_STR);
            $logStmt->bindParam(':job_id', $jobId, PDO::PARAM_INT);
            $logStmt->execute();
            
            // Commit transaction
            $pdo->commit();
            
            // Set success message
            $_SESSION['success_message'] = "Job posting has been " . $newStatus;
            
            // Redirect to the main dashboard page to refresh job listings
            header("Location: AdminDashboardMain.php");
            exit();
            
        } catch (PDOException $e) {
            // Roll back the transaction if something failed
            $pdo->rollBack();
            $_SESSION['error_message'] = "Error: " . $e->getMessage();
        }
    }
}

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

<body id="admin-dash-main">

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
            <li><a href="AdminDashboardMain.php" class="active">Pending Approval</a></li>
            <li><a href="AdminDashApproved.php">Approved</a></li>
            <li><a href="AdminDashRejected.php">Rejected</a></li>
        </ul>
    </div>

    <!-- Pending Job Postings Section -->
    <div class="page-content">
        <div class="pending-approvals">
            <h2>Pending Approvals</h2>

            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success">
                    <?php 
                    echo $_SESSION['success_message']; 
                    unset($_SESSION['success_message']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger">
                    <?php 
                    echo $_SESSION['error_message']; 
                    unset($_SESSION['error_message']);
                    ?>
                </div>
            <?php endif; ?>

            <div class="job-postings">
                <?php if (empty($pendingJobs)): ?>
                    <p>No pending job postings at this time.</p>
                <?php else: ?>
                    <?php foreach ($pendingJobs as $job): ?>
                        <div class="job-container">
                            <i class="ph ph-user-circle"></i>
                            <div class="job-details">
                                <p class="company-name"><strong>BUSINESS / <?php echo htmlspecialchars($job['company_name']); ?></strong></p>
                                <p class="company-desc"><?php echo htmlspecialchars($job['description']); ?></p>
                                <p class="job-position">Open Job Position/s: <?php echo htmlspecialchars($job['job_position']); ?></p>
                            </div>
                            <div class="job-actions">
                                <form method="POST" action="AdminDashboardMain.php" class="action-form">
                                    <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                    <button type="submit" name="action" value="accept" class="accept-btn">ACCEPT</button>
                                    <button type="submit" name="action" value="reject" class="reject-btn">REJECT</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php if (count($pendingJobs) > 7): ?>
                        <!-- Show More Button -->
                        <button id="show-more-btn">Show More</button>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div> <!-- for page content -->
    
    <!-- JAVA SCRIPTS -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const jobPosts = document.querySelectorAll("#admin-dash-main .job-container");
        const showMoreBtn = document.getElementById("show-more-btn");

        if (jobPosts.length > 7) {
            for (let i = 7; i < jobPosts.length; i++) {
                jobPosts[i].classList.add("hidden"); // Initially hide excess job posts
            }

            showMoreBtn.addEventListener("click", function() {
                let hiddenPosts = document.querySelectorAll("#admin-dash-main .hidden");
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
        } else if (showMoreBtn) {
            showMoreBtn.style.display = "none"; // Hide the button if 7 or fewer job postings
        }
    });
    </script>
</body>
</html>
