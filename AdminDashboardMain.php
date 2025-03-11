<?php
session_start();

// Session validation
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role_id'])) {
    die("Access Denied. Please log in.");
}

// Restrict access based on role
$roleId = $_SESSION['role_id'];
$pageRole = 1; // 1 = Admin, 2 = Applicant, 3 = Business

if ($roleId != $pageRole) {
    echo "Access denied.";
    exit();
}

// Include database configuration
require_once 'config.php';

// Function to get pending job postings from the database
function getPendingJobPostings($pdo) {
    try {
        $query = "SELECT j.id, b.businessName, b.description AS business_description, j.jobTitle, j.jobDescription
                  FROM JobPosting j
                  JOIN Business b ON j.businessId = b.id
                  WHERE j.status = 'Pending Approval'
                  ORDER BY j.datePosted DESC";
        
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
        $newJobStatus = ($action === 'accept') ? 'Open' : 'Rejected'; // Changed from 'Closed' to 'Rejected'
        $adminAction = ($action === 'accept') ? 'Approved' : 'Rejected'; // Log the admin action
        
        try {
            // Begin transaction
            $pdo->beginTransaction();
            
            // Update job posting status in JobPosting table
            $updateJobStatusQuery = "UPDATE JobPosting SET status = :status WHERE id = :id";
            $stmt = $pdo->prepare($updateJobStatusQuery);
            $stmt->bindParam(':status', $newJobStatus, PDO::PARAM_STR);
            $stmt->bindParam(':id', $jobId, PDO::PARAM_INT);
            $stmt->execute();
            
            // Log the admin action in AdminActions table
            $adminId = $_SESSION['user_id'];
            $logActionQuery = "INSERT INTO adminactions (job_posting_id, admin_id, action) 
                              VALUES (:job_id, :admin_id, :action)";
            $logStmt = $pdo->prepare($logActionQuery);
            $logStmt->bindParam(':job_id', $jobId, PDO::PARAM_INT);
            $logStmt->bindParam(':admin_id', $adminId, PDO::PARAM_INT);
            $logStmt->bindParam(':action', $adminAction, PDO::PARAM_STR);
            $logStmt->execute();
            
            // Commit transaction
            $pdo->commit();
            
            // Set success message
            $_SESSION['success_message'] = "Job posting has been " . ($action === 'accept' ? 'approved' : 'rejected');
            
            // Redirect based on action
            if ($action === 'accept') {
                header("Location: AdminDashboardMain.php");
            } else {
                header("Location: AdminDashRejected.php");
            }
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
    <link rel="icon" href="img/numerouno.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="./styles.css" rel="stylesheet">
</head>

<body id="admin-dash-main">
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
			<li><a href="ContactUs.php">Contact Us</a></li>
			<li><a href="logout.php">Log out</a></li>
		</ul>
	</div>
	</nav>

	<!-- End of Navigation Bar -->

    <script src="https://unpkg.com/@phosphor-icons/web"></script>


    <div class="sidebar-hover-area"></div>

    <div class="admin-sidebar">
        <p class="admin-dashb">Admin Dashboard</p>
        <ul>
            <li><a href="AdminDashboardMain.php" class="active">Pending Approval</a></li>
            <li><a href="AdminDashApproved.php">Approved</a></li>
            <li><a href="AdminDashRejected.php">Rejected</a></li>
        </ul>
    </div>

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
                    <div class="job-container">
                        <i class="ph ph-user-circle"></i>
                        <div class="job-details">
                            <p class="company-name"><strong>BUSINESS / <?php echo htmlspecialchars($job['businessName']); ?></strong></p>
                            <p class="company-desc"><?php echo htmlspecialchars($job['business_description']); ?></p>
                            <p class="job-position">Open Job Position/s: <?php echo htmlspecialchars($job['jobTitle']); ?></p>
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
                        <button id="show-more-btn">Show More</button>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const jobPosts = document.querySelectorAll("#admin-dash-main .job-container");
            const showMoreBtn = document.getElementById("show-more-btn");

            if (jobPosts.length > 7) {
                for (let i = 7; i < jobPosts.length; i++) {
                    jobPosts[i].classList.add("hidden");
                }

                showMoreBtn.addEventListener("click", function() {
                    let hiddenPosts = document.querySelectorAll("#admin-dash-main .hidden");
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
            } else if (showMoreBtn) {
                showMoreBtn.style.display = "none";
            }
        });
    </script>

    <script src="js/sidebar.js"></script>
    <script src="js/scroll.js"></script>
</body>

</html>