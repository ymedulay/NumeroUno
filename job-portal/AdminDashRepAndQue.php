<?php
session_start();

// Check if user is logged in (Example condition, modify as needed)
$user_logged_in = isset($_SESSION['user']);
$user = $user_logged_in ? $_SESSION['user'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NumeroUno - Reports & Queries</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>

<body id="admin-dash-repandque">

    <?php include 'nav.php'; ?>

    <!-- Search Bar -->
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
        <?php
        // Placeholder for reports (Replace with database queries)
        $reports = [
            ["user" => "John Doe", "report" => "Issue with job listing", "status" => "PROCESSING"],
            ["user" => "Jane Smith", "report" => "Account login problem", "status" => "RESOLVED"],
        ];

        foreach ($reports as $report) { ?>
            <div class="report-container">
                <i class="ph ph-user-circle"></i>
                <div class="report-details">
                    <p><strong><?php echo htmlspecialchars($report['user']); ?></strong></p>
                    <p><?php echo htmlspecialchars($report['report']); ?></p>
                    <div class="status-container">
                        <p>Status of Report:</p>
                        <div class="status-buttons">
                            <button class="status <?php echo strtolower($report['status']); ?>"><?php echo strtoupper($report['status']); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Queries Section -->
    <h2>Queries</h2>
    <div class="queries-section">
        <?php
        // Placeholder for queries (Replace with database queries)
        $queries = [
            ["user" => "Alice Brown", "question" => "How do I update my profile?"],
            ["user" => "Bob White", "question" => "Where can I see my application status?"],
        ];

        foreach ($queries as $query) { ?>
            <div class="query-container">
                <i class="ph ph-user-circle"></i>
                <div class="query-details">
                    <p><strong><?php echo htmlspecialchars($query['user']); ?></strong></p>
                    <p><?php echo htmlspecialchars($query['question']); ?></p>
                    <input type="text" placeholder="Type your answer...">
                </div>
            </div>
        <?php } ?>
    </div>

    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        function toggleDropdown(id) {
            document.querySelectorAll(".dropdown-menu").forEach(menu => {
                if (menu.id !== id) menu.classList.remove("show");
            });
            document.getElementById(id).classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.ph, .ph *')) {
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
</body>

</html>