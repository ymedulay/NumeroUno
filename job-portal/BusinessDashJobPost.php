<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Job Postings - NumeroUno</title>
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body id="business-dash-job-post">

    <?php include 'nav.php'; ?>

    <div class="admin-sidebar">
        <p class="admin-dashb">Business Dashboard</p>
        <ul>
            <li><a href="BusinessDashboard.php">My Dashboard</a></li>
            <li><a href="BusinessDashManageProfile.php">Manage Business Profile</a></li>
            <li><a href="BusinessDashJobPost.php">Post Job Posting</a></li>
            <li><a href="BusinessDashPostManage.php">Post Management</a></li>
        </ul>
    </div>

    <div class="main-content-wrapper">
        <div class="page-content">
            <h1>Post Job Postings</h1>
        </div>

        <form class="profile-form" action="process_job_post.php" method="POST">
            <div class="form-section-container">
                <h2>Job Information</h2>
                <div class="form-grid two-columns">
                    <div>
                        <label for="jobTitle">Job Title</label>
                        <input type="text" id="jobTitle" name="jobTitle" placeholder="Job Title" required>
                    </div>
                    <div>
                        <label for="businessName">Business Name</label>
                        <input type="text" id="businessName" name="businessName" placeholder="Business Name" required>
                    </div>
                    <div>
                        <label for="description">Job Description:</label>
                        <textarea id="description" name="description" placeholder="Type your Job description here..." rows="4" required></textarea>
                        <label for="cvRequired">Check if CV is required</label>
                        <input type="checkbox" id="cvRequired" name="cvRequired">
                    </div>
                </div>
            </div>

            <div class="form-section-container">
                <div class="form-grid two-columns">
                    <div>
                        <label for="jobLocation">Job Location</label>
                        <input type="text" id="jobLocation" name="jobLocation" placeholder="e.g Barangay Concepcion Uno, Marikina City " required>
                    </div>
                    <div>
                        <label for="salaryRange">Salary Range</label>
                        <input type="text" id="salaryRange" name="salaryRange" placeholder="₱10,000 - ₱15,000" required>
                    </div>
                    <div>
                        <label for="qualifications">Qualifications</label>
                        <textarea id="qualifications" name="qualifications" placeholder="Type your Job qualifications here..." rows="3" required></textarea>
                    </div>
                    <div>
                        <label for="employmentType">Employment Type</label>
                        <select id="employmentType" name="employmentType" required>
                            <option value="">Select</option>
                            <option value="full-time">Full-Time</option>
                            <option value="part-time">Part-Time</option>
                            <option value="contract">Contract</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="submit-btn">Post</button>
        </form>
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