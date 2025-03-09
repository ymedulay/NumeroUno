<?php
session_start();
require 'config.php'; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: LoginPage.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle job posting submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitJob'])) {
        // Job posting submission
        $jobTitle = $_POST['jobTitle'];
        $businessName = $_POST['businessName'];
        $description = $_POST['description'];
        $cvRequired = isset($_POST['cvRequired']) ? 1 : 0;
        $jobLocation = $_POST['jobLocation'];
        $salaryRange = $_POST['salaryRange'];
        $qualifications = $_POST['qualifications'];
        $employmentType = $_POST['employmentType'];

        // Insert into database
        $stmt = $pdo->prepare("
            INSERT INTO JobPostings (user_id, jobTitle, businessName, description, cvRequired, jobLocation, salaryRange, qualifications, employmentType, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$user_id, $jobTitle, $businessName, $description, $cvRequired, $jobLocation, $salaryRange, $qualifications, $employmentType]);

        echo "<script>alert('Job posted successfully!'); window.location.href='BusinessDashPostManage.php';</script>";
    }

    // Handle other button actions (e.g., Cancel or Update) here
    if (isset($_POST['cancelJob'])) {
        // Code to cancel or clear form data
        echo "<script>alert('Job posting cancelled.'); window.location.href='BusinessDashPostManage.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Job Postings - NumeroUno</title>
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body id="business-dash-job-post">  

    <!-- Navbar -->
    <nav>
        <div class="logo">
            <img src="NumeroUnoLogo.png" alt="Numero Uno Logo">
        </div>
        <div class="nav-left">
            <ul class="nav-links">
                <li><a href="HomePage.php">Home</a></li>
                <li><a href="FindJobPage.php">Find Job</a></li>
            </ul>
        </div>
        <div class="nav-right">
            <ul class="nav-links">
                <li class="dropdown">
                    <i class="ph ph-user" onclick="toggleDropdown('userDropdown')"></i>
                    <ul class="dropdown-menu" id="userDropdown">
                        <li><a href="BusinessDashboard.php">My Dashboard</a></li>
                        <li><a href="BusinessDashManageProfile.php">Manage Profile</a></li>
                        <li><a href="Logout.php">Logout</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <i class="ph ph-gear" onclick="toggleDropdown('settingsDropdown')"></i>
                    <ul class="dropdown-menu" id="settingsDropdown">
                        <li><a href="AboutUs.php">About Us</a></li>
                        <li><a href="ContactUs.php">Contact Us</a></li>
                        <li><a href="FAQs.php">FAQs</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

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
    <div class="main-content-wrapper">
        <div class="page-content">
            <h1>Post Job Postings</h1>
        </div>

        <form method="POST" class="profile-form">
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
                        <label for="cvRequired">
                            <input type="checkbox" id="cvRequired" name="cvRequired"> Check if CV is required
                        </label>
                    </div>
                </div>
            </div>
        
            <div class="form-section-container">
                <div class="form-grid two-columns">
                    <div>
                        <label for="jobLocation">Job Location</label>
                        <input type="text" id="jobLocation" name="jobLocation" placeholder="e.g Barangay Concepcion Uno, Marikina City" required>
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
    
        window.onclick = function (event) {
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
