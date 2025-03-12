<?php
// Start the session and check user authentication
session_start();

// Include database connection (Assuming you have a db_connection.php file)
include 'config.php';

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] !== 1) {
    // Redirect to login or another page if the user is not an admin (role_id = 1)
    header("Location: LoginPage.php");
    exit();
}

// Fetch reports and queries from the database (for demonstration purposes)
$reports = []; // Array to store fetched reports
$queries = []; // Array to store fetched queries

// Sample fetching reports (Replace with actual DB query)
$query = "SELECT * FROM reports LIMIT 10"; // Adjust SQL query as per your need
$stmt = $pdo->prepare($query);
$stmt->execute();
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Sample fetching queries (Replace with actual DB query)
$query2 = "SELECT * FROM queries LIMIT 10"; // Adjust SQL query as per your need
$stmt2 = $pdo->prepare($query2);
$stmt2->execute();
$queries = $stmt2->fetchAll(PDO::FETCH_ASSOC);
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

<body id="admin-dash-repandque">
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


    <!-- Search Bar Container -->
    <div class="search-container">
        <div class="search-bar">
            <input type="text" placeholder="Search">
        </div>
        <div class="search-icons">
            <i class="ph ph-sliders"></i>
            <i class="ph ph-funnel"></i>
        </div>
    </div>

    <!-- Reports Section -->
    <h2>Reports</h2>
    <div class="reports-section">
        <?php foreach ($reports as $report) { ?>
            <div class="report-container">
                <i class="ph ph-user-circle"></i>
                <div class="report-details">
                    <p><strong><?php echo $report['user_name']; ?></strong></p>
                    <p><?php echo $report['report_description']; ?></p>
                    <div class="status-container">
                        <p>Status of Report:</p>
                        <div class="status-buttons">
                            <button class="status processing">PROCESSING</button>
                            <button class="status resolved">RESOLVED</button>
                            <button class="status dismissed">DISMISSED</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Hidden Reports -->
        <div class="report-container hidden">
            <i class="ph ph-user-circle"></i>
            <div class="report-details">
                <p><strong>USER</strong></p>
                <p>Report</p>
                <div class="status-container">
                    <p>Status of Report:</p>
                    <div class="status-buttons">
                        <button class="status processing">PROCESSING</button>
                        <button class="status resolved">RESOLVED</button>
                        <button class="status dismissed">DISMISSED</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button class="show-more-btn show-more-btn-reports" onclick="toggleReports()">Show More</button>

    <!-- Queries Section -->
    <h2>Queries</h2>
    <div class="queries-section">
        <?php foreach ($queries as $query) { ?>
            <div class="query-container">
                <i class="ph ph-user-circle"></i>
                <div class="query-details">
                    <p><strong><?php echo $query['user_name']; ?></strong></p>
                    <p><?php echo $query['query_description']; ?></p>
                    <input type="text" placeholder="Type your answer...">
                </div>
            </div>
        <?php } ?>

        <!-- Hidden Queries -->
        <div class="query-container hidden">
            <i class="ph ph-user-circle"></i>
            <div class="query-details">
                <p><strong>USER</strong></p>
                <p>Question</p>
                <input type="text" placeholder="Type your answer...">
            </div>
        </div>
    </div>

    <button class="show-more-btn show-more-btn-queries" onclick="toggleQueries()">Show More</button>

    <script>
        function toggleReports() {
            let hiddenReports = document.querySelectorAll('.reports-section .hidden');
            let button = document.querySelector('.show-more-btn-reports');

            hiddenReports.forEach(report => {
                report.style.display = (report.style.display === "none" || report.style.display === "") ? "flex" : "none";
            });

            button.innerText = button.innerText === "Show More" ? "Show Less" : "Show More";
        }

        function toggleQueries() {
            let hiddenQueries = document.querySelectorAll('.queries-section .hidden');
            let button = document.querySelector('.show-more-btn-queries');

            hiddenQueries.forEach(query => {
                query.style.display = (query.style.display === "none" || query.style.display === "") ? "flex" : "none";
            });

            button.innerText = button.innerText === "Show More" ? "Show Less" : "Show More";
        }
    </script>

    <script src="js/sidebar.js"></script>
    <script src="js/scroll.js"></script>

</body>

</html>