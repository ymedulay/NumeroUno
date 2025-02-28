<?php include 'nav.php'; ?>

<!DOCTYPE html>
<html lang="en" id="application-status-page">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status - NumeroUno</title>
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body>
    <!-- Sidebar -->
    <div class="admin-sidebar">
        <p class="admin-dashb">Applicant Dashboard</p>
        <ul>
            <li><a href="ApplicantDashboard.php">My Dashboard</a></li>
            <li><a href="ApplicantDashboardManageProfile.php">Manage My Profile</a></li>
            <li><a href="ApplicantDashboardApplicationStatus.php">Application Status</a></li>
            <li><a href="ApplicantDashboardAccountManagement.php">Account Management</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content-wrapper">
        <h2>Applied Jobs</h2>

        <?php
        // Sample array of applied jobs. Replace this with a database query.
        $applied_jobs = [
            ["title" => "Software Developer", "status" => "PENDING"],
            ["title" => "Graphic Designer", "status" => "PENDING"]
        ];

        foreach ($applied_jobs as $job) {
            echo '<div class="application-card">';
            echo '    <div class="job-image-placeholder"></div>';
            echo '    <div class="job-info">';
            echo '        <p class="job-title">' . htmlspecialchars($job["title"]) . '</p>';
            echo '        <div class="application-status">';
            echo '            <p>Application Status</p>';
            echo '            <span class="status-indicator pending">● ' . htmlspecialchars($job["status"]) . '</span>';
            echo '        </div>';
            echo '    </div>';
            echo '</div>';
        }
        ?>
    </div>

    <script>
        function toggleDropdown(id) {
            let dropdown = document.getElementById(id);
            let allDropdowns = document.querySelectorAll('.dropdown-menu');
            allDropdowns.forEach(menu => {
                if (menu !== dropdown) menu.classList.remove("show");
            });
            dropdown.classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.ph')) {
                let dropdowns = document.getElementsByClassName("dropdown-menu");
                for (let i = 0; i < dropdowns.length; i++) {
                    let openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        };
    </script>
</body>

</html>