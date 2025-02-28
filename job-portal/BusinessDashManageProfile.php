<?php include 'nav.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage My Profile - NumeroUno</title>
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body id="business-dash-manage-prof">

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
            <h1>Business Manage Profile</h1>
            <img id="profile-pic" src="BusinessLogo.jpg" alt="Business Logo">
            <h2 id="display-name">User Name</h2>
            <input type="file" id="upload-profile-pic" style="display: none;">
            <button class="change-profile-pic" onclick="document.getElementById('upload-profile-pic').click();">
                Change Profile Picture
            </button>
        </div>

        <form class="profile-form" action="process_profile.php" method="POST">
            <div class="form-section-container">
                <h2>Business Information</h2>
                <div class="form-grid two-columns">
                    <div>
                        <label for="business-name">Business Name:</label>
                        <input type="text" id="business-name" name="business-name" placeholder="Business Name" required>
                    </div>
                    <div>
                        <label for="business-type">Business Type:</label>
                        <select id="business-type" name="business-type" required>
                            <option value="">Select</option>
                            <option value="Sole Proprietorship">Sole Proprietorship</option>
                            <option value="Partnership">Partnership</option>
                            <option value="LLC">Limited Liability Company (LLC)</option>
                            <option value="Corporation">Corporation</option>
                        </select>
                    </div>
                    <div>
                        <label for="description">Business Description:</label>
                        <textarea id="description" name="description" placeholder="Type your business description here..." rows="4" required></textarea>
                    </div>
                </div>
            </div>

            <div class="form-section-container">
                <h2>Contact Information</h2>
                <div class="form-grid two-columns">
                    <div>
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" required>
                    </div>
                    <div>
                        <label for="contact">Contact No.:</label>
                        <input type="text" id="contact" name="contact" placeholder="e.g., 09123456789" required>
                    </div>
                    <div>
                        <label for="email">Email Address:</label>
                        <input type="email" id="email" name="email" placeholder="e.g., example@email.com" required>
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