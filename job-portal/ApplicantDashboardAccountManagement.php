<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" id="account-management-page">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management - NumeroUno</title>
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body>
    <?php include 'nav.php'; ?>

    <div class="admin-sidebar">
        <p class="admin-dashb">Applicant Dashboard</p>
        <ul>
            <li><a href="ApplicantDashboard.php">My Dashboard</a></li>
            <li><a href="ApplicantDashboardManageProfile.php">Manage My Profile</a></li>
            <li><a href="ApplicantDashboardApplicationStatus.php">Application Status</a></li>
            <li><a href="ApplicantDashboardAccountManagement.php">Account Management</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Account Management</h1>
        <div class="account-container">
            <h3>Account Security</h3>
            <p class="section-subtitle">Login Credentials</p>
            <div class="form-grid">
                <input type="email" placeholder="Email Address">
                <input type="password" placeholder="Password">
            </div>

            <p class="section-subtitle">Password Recovery Options</p>
            <div class="recovery-options">
                <div class="checkbox-group">
                    <label>
                        <input type="checkbox"> Recovery Email Address
                    </label>
                    <input type="email" placeholder="Recovery Email Address">
                </div>
                <div class="checkbox-group">
                    <label>
                        <input type="checkbox"> Recovery Contact No.
                    </label>
                    <input type="text" placeholder="Recovery Contact No.">
                </div>
            </div>
            <button class="save-button">Save Changes</button>
        </div>

        <div class="account-container delete-container">
            <div class="delete-content">
                <div>
                    <h3>Account Deletion</h3>
                    <p>This action permanently deletes your account and cannot be undone.</p>
                </div>
                <button class="delete-button">Delete My Account</button>
            </div>
        </div>
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