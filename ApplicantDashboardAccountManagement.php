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
    <link rel="icon" href="img/numerouno.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body>
	<!-- Navigation Bar -->
	<nav>
		<div class="logo">
			<a href="HomePage.php"><img src="img/numerouno.png" alt="Numero Uno Logo"></a>
		</div>

		<div class="nav-right">
			<!-- Correct Find Jobs Button -->
			<a href="FindJobPage.php" class="find-jobs-btn">Find Jobs</a>

			<!-- Menu Icon -->
			<div class="menu-icon">
				<i class="ph ph-list"></i>
			</div>
		</div>
	</nav>


	<!-- Sidebar (Initially Hidden) -->
	<div id="sideMenu" class="sidebar">
		<ul>
			<li><a href="AboutUs.php">About Us</a></li>
			<li><a href="ContactUs.php">Contact Us</a></li>
            <li><a href="FAQs.php">FAQs</a></li>
			<li><a href="logout.php">Log out</a></li>
		</ul>
	</div>
	</nav>

	<!-- End of Navigation Bar -->

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

    <footer class="footer">
		<p>Copyright © 2025, NumeroUno | All rights reserved</p>
	</footer>

    <script src="js/sidebar.js"></script>
</body>

</html>