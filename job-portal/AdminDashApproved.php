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

<body id="admin-dash-appro">

    <!-- Sidebar Container -->
    <div class="admin-sidebar">
        <p class="admin-dashb">Admin Dashboard</p>
        <ul>
            <li><a href="AdminDashboardMain.php">Pending Approval</a></li>
            <li><a href="AdminDashApproved.php">Approved</a></li>
            <li><a href="AdminDashRejected.php">Rejected</a></li>
        </ul>
    </div>

    <!-- Approved Job Postings Section -->
    <div class="approved-postings">
        <h2>Approved</h2>

        <div class="job-postings">
            <?php
            // Sample job postings array (Replace with database query)
            $jobPostings = [
                ["company" => "Company A", "desc" => "Short description A", "position" => "Cashier"],
                ["company" => "Company B", "desc" => "Short description B", "position" => "Manager"],
                ["company" => "Company C", "desc" => "Short description C", "position" => "Sales Associate"],
            ];

            foreach ($jobPostings as $job) {
                echo '<div class="job-container">';
                echo '<i class="ph ph-user-circle"></i>';
                echo '<div class="job-details">';
                echo '<p class="company-name"><strong>' . htmlspecialchars($job['company']) . '</strong></p>';
                echo '<p class="company-desc">' . htmlspecialchars($job['desc']) . '</p>';
                echo '<p class="job-position">Open Job Position/s: ' . htmlspecialchars($job['position']) . '</p>';
                echo '</div>';
                echo '<div class="job-actions">';
                echo '<button class="accepted-btn">ACCEPTED</button>';
                echo '</div>';
                echo '</div>';
            }
            ?>

            <!-- Show More Button -->
            <button id="show-more-btn-appro">Show More</button>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const jobPosts = document.querySelectorAll("#admin-dash-appro .job-container");
            const showMoreBtn = document.getElementById("show-more-btn-appro");

            if (jobPosts.length > 7) {
                for (let i = 7; i < jobPosts.length; i++) {
                    jobPosts[i].classList.add("hidden");
                }

                showMoreBtn.addEventListener("click", function() {
                    let hiddenPosts = document.querySelectorAll("#admin-dash-appro .hidden");
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