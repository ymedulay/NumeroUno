<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" id="manage-profile-page">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage My Profile - NumeroUno</title>
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body>
    <!-- Navbar -->
    <?php include 'nav.php'; ?>

    <!-- Sidebar -->
    <div class="sidebar-hover-area"></div>
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
        <div class="page-content">
            <img id="profile-pic" src="profile-placeholder.png" alt="User Profile Picture">
            <h2 id="display-name">User Name</h2>
            <input type="file" id="upload-profile-pic" style="display: none;">
            <button class="change-profile-pic" onclick="document.getElementById('upload-profile-pic').click();">
                Change Profile Picture
            </button>
        </div>

        <form id="profile-form" method="POST" action="process_profile.php">
            <div class="form-section-container">
                <h3>Personal Information</h3>
                <div class="form-grid two-columns">
                    <div>
                        <label for="first-name">First Name <span></span></label>
                        <input type="text" id="first-name" name="first_name" placeholder="e.g., John" required>
                    </div>
                    <div>
                        <label for="last-name">Last Name <span>*</span></label>
                        <input type="text" id="last-name" name="last_name" placeholder="e.g., Dela Cruz" required>
                    </div>
                    <div>
                        <label for="middle-initial">Middle Initial</label>
                        <input type="text" id="middle-initial" name="middle_initial">
                    </div>
                    <div>
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-section-container">
                <h3>Contact Information</h3>
                <div class="form-grid two-columns">
                    <div>
                        <label for="contact-no">Contact No. <span>*</span></label>
                        <input type="text" id="contact-no" name="contact_no" placeholder="e.g.,  09123456789" required>
                    </div>
                    <div>
                        <label for="email">Email Address <span>*</span></label>
                        <input type="email" id="email" name="email" placeholder="e.g.,  example@email.com" required>
                    </div>
                    <div class="full-width">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address">
                    </div>
                </div>
            </div>

            <div class="form-section-container">
                <h3>Educational Background</h3>
                <div class="form-grid two-columns">
                    <div>
                        <label for="education">Highest Level of Education</label>
                        <select id="education" name="education">
                            <option value="">Select</option>
                            <option value="High School">High School</option>
                            <option value="Associate Degree">Associate Degree</option>
                            <option value="Bachelor's Degree">Bachelor's Degree</option>
                            <option value="Master's Degree">Master's Degree</option>
                            <option value="Doctorate">Doctorate</option>
                        </select>
                    </div>
                    <div>
                        <label for="achievements">Achievements</label>
                        <input type="text" id="achievements" name="achievements" placeholder="Add more...">
                    </div>
                    <div>
                        <label for="graduation-year">Year Graduated</label>
                        <select id="graduation-year" name="graduation_year">
                            <option value="">Select</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                        </select>
                    </div>
                    <div>
                        <label for="specialization">Area of Specialization</label>
                        <input type="text" id="specialization" name="specialization">
                    </div>
                    <div>
                        <label for="skills">Skills</label>
                        <input type="text" id="skills" name="skills">
                    </div>
                </div>
            </div>

            <button type="submit" class="save-button">Save Profile</button>
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