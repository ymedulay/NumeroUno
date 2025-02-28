<?php include 'nav.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NumeroUno</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>

<body id="admin-dash-main">

    <!-- Sidebar -->
    <div class="sidebar-hover-area"></div>
    <div class="admin-sidebar">
        <p class="admin-dashb">Admin Dashboard</p>
        <ul>
            <li><a href="AdminDashboardMain.php">Pending Approval</a></li>
            <li><a href="AdminDashApproved.php">Approved</a></li>
            <li><a href="AdminDashRejected.php">Rejected</a></li>
        </ul>
    </div>

    <!-- Page Content -->
    <div class="page-content">
        <div class="pending-approvals">
            <h2>Pending Approvals</h2>
            <div class="job-postings">
                <?php
                // Sample job postings array (replace with database query later)
                $jobPostings = [
                    ["name" => "Company A", "desc" => "Short description", "position" => "Cashier"],
                    ["name" => "Company B", "desc" => "Short description", "position" => "Sales Associate"],
                    ["name" => "Company C", "desc" => "Short description", "position" => "Manager"],
                    ["name" => "Company D", "desc" => "Short description", "position" => "Clerk"],
                    ["name" => "Company E", "desc" => "Short description", "position" => "Accountant"],
                    ["name" => "Company F", "desc" => "Short description", "position" => "Receptionist"],
                    ["name" => "Company G", "desc" => "Short description", "position" => "HR Assistant"],
                    ["name" => "Company H", "desc" => "Short description", "position" => "Security Guard"]
                ];

                foreach ($jobPostings as $index => $job) {
                    $hiddenClass = $index >= 7 ? 'hidden' : '';
                    echo "<div class='job-container $hiddenClass'>
                            <i class='ph ph-user-circle'></i>
                            <div class='job-details'>
                                <p class='company-name'><strong>{$job['name']}</strong></p>
                                <p class='company-desc'>{$job['desc']}</p>
                                <p class='job-position'>Open Job Position/s: {$job['position']}</p>
                            </div>
                            <div class='job-actions'>
                                <button class='accept-btn'>ACCEPT</button>
                                <button class='reject-btn'>REJECT</button>
                            </div>
                          </div>";
                }
                ?>

                <button id="show-more-btn">Show More</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
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
            } else {
                showMoreBtn.style.display = "none";
            }
        });
    </script>
</body>

</html>