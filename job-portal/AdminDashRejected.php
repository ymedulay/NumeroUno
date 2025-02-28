<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NumeroUno</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>

<body id="admin-dash-reje">

    <?php include 'nav.php'; ?>

    <div class="sidebar-hover-area"></div>

    <div class="admin-sidebar">
        <p class="admin-dashb">Admin Dashboard</p>
        <ul>
            <li><a href="AdminDashboardMain.php">Pending Approval</a></li>
            <li><a href="AdminDashApproved.php">Approved</a></li>
            <li><a href="AdminDashRejected.php">Rejected</a></li>
        </ul>
    </div>

    <div class="rejected-postings">
        <h2>Rejected</h2>
        <div class="job-postings">
            <?php
            $jobs = array_fill(0, 10, [
                'company_name' => 'BUSINESS / COMPANY NAME',
                'company_desc' => 'Short company description',
                'job_position' => 'Open Job Position/s: Cashier'
            ]);

            foreach ($jobs as $index => $job) {
                $hiddenClass = $index >= 7 ? 'hidden' : '';
                echo "<div class='job-container $hiddenClass'>
                        <i class='ph ph-user-circle'></i>
                        <div class='job-details'>
                            <p class='company-name'><strong>{$job['company_name']}</strong></p>
                            <p class='company-desc'>{$job['company_desc']}</p>
                            <p class='job-position'>{$job['job_position']}</p>
                        </div>
                        <div class='job-actions'>
                            <button class='rejected-btn'>REJECTED</button>
                        </div>
                      </div>";
            }
            ?>
            <button id="show-more-btn-reje">Show More</button>
        </div>
    </div>

    <script src="https://unpkg.com/@phosphor-icons/web"></script>
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
</body>

</html>