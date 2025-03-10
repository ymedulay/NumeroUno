<?php include 'nav.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Management - NumeroUno</title>
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body id="business-dash-post-manage">

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
                <?php
                // Placeholder for dynamically fetched job posts
                for ($i = 0; $i < 3; $i++): ?>
                    <div class="job-container">
                        <div class="job-details">
                            <p class="company-name"><strong>JOB POST</strong></p>
                        </div>
                        <div class="job-actions">
                            <button class="edit-btn">EDIT</button>
                            <button class="delete-btn">DELETE</button>
                        </div>
                    </div>
                <?php endfor; ?>
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
        </div>
    </div>

    <script>
        function toggleDropdown(id) {
            let dropdown = document.getElementById(id);
            let allDropdowns = document.querySelectorAll('.dropdown-menu');

            allDropdowns.forEach((menu) => {
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