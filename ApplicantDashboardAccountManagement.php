<?php
session_start();
require 'config.php'; // Database connection

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: LoginPage.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $pdo->prepare("SELECT email, password, recovery_email, recovery_contact FROM user WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_changes'])) {
        $email = $_POST['email'];
        $new_password = $_POST['password'];
        $recovery_email = isset($_POST['recovery_email']) ? $_POST['recovery_email'] : null;
        $recovery_contact = isset($_POST['recovery_contact']) ? $_POST['recovery_contact'] : null;

        // If a new password is provided, hash it. Otherwise, keep the old password.
        $password = !empty($new_password) ? password_hash($new_password, PASSWORD_DEFAULT) : $user['password'];

        // Update the user record
        $stmt = $pdo->prepare("UPDATE user SET email = ?, password = ?, recovery_email = ?, recovery_contact = ? WHERE id = ?");
        $stmt->execute([$email, $password, $recovery_email, $recovery_contact, $user_id]);

        echo "<script>alert('Changes saved successfully!'); window.location.href='ApplicantDashboardAccountManagement.php';</script>";
    } elseif (isset($_POST['delete_account'])) {
        // Delete the user account
        $stmt = $pdo->prepare("DELETE FROM user WHERE id = ?");
        $stmt->execute([$user_id]);

        // Destroy session and redirect
        session_destroy();
        echo "<script>alert('Your account has been deleted.'); window.location.href='HomePage.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en" id="account-management-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management - NumeroUno</title>
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>
<body>
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
                <li class="dropdown-container">
                    <i class="ph ph-user" onclick="toggleDropdown('userDropdown')"></i>
                    <ul class="dropdown-menu" id="userDropdown">
                        <li><a href="ApplicantDashboard.php">My Dashboard</a></li>
                        <li><a href="ApplicantDashboardAccountManagement.php">Account Management</a></li>
                        <li><a href="Logout.php">Logout</a></li>
                    </ul>
                </li>
                <li class="dropdown-container">
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
    <div class="main-content">
        <h1>Account Management</h1>

        <!-- Account Security -->
        <form method="POST">
            <div class="account-container">
                <h3>Account Security</h3>
                <p class="section-subtitle">Login Credentials</p>
                <div class="form-grid">
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                    <input type="password" name="password" placeholder="New Password (optional)">
                </div>

                <p class="section-subtitle">Password Recovery Options</p>
                <div class="recovery-options">
                    <div class="checkbox-group">
                        <label>
                            <input type="checkbox" name="recovery_email" value="<?= htmlspecialchars($user['recovery_email'] ?? '') ?>" <?= !empty($user['recovery_email']) ? 'checked' : '' ?>>
                            Recovery Email Address
                        </label>
                        <input type="email" name="recovery_email" value="<?= htmlspecialchars($user['recovery_email'] ?? '') ?>">
                    </div>

                    <div class="checkbox-group">
                        <label>
                            <input type="checkbox" name="recovery_contact" value="<?= htmlspecialchars($user['recovery_contact'] ?? '') ?>" <?= !empty($user['recovery_contact']) ? 'checked' : '' ?>>
                            Recovery Contact No.
                        </label>
                        <input type="text" name="recovery_contact" value="<?= htmlspecialchars($user['recovery_contact'] ?? '') ?>">
                    </div>
                </div>
                
                <button type="submit" name="save_changes" class="save-button">Save Changes</button>
            </div>
        </form>

        <!-- Account Deletion -->
        <form method="POST">
            <div class="account-container delete-container">
                <div class="delete-content">
                    <div>
                        <h3>Account Deletion</h3>
                        <p>This action permanently deletes your account and cannot be undone.</p>
                    </div>
                    <button type="submit" name="delete_account" class="delete-button">Delete My Account</button>
                </div>
            </div>
        </form>
    </div>

    <!-- JavaScript for Dropdowns -->
    <script>
        function toggleDropdown(id) {
            let dropdown = document.getElementById(id);
            let allDropdowns = document.querySelectorAll('.dropdown-menu');
            allDropdowns.forEach(menu => {
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
