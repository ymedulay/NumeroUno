<?php
session_start();
require 'config.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: LoginPage.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user profile details
$stmt = $pdo->prepare("SELECT firstName, lastName, middle_initial, gender, contact_no, address, email FROM user WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "<script>alert('User not found!'); window.location.href='Logout.php';</script>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first-name']);
    $last_name = trim($_POST['last-name']);
    $middle_initial = trim($_POST['middle-initial']) ?? null;
    $gender = trim($_POST['gender']) ?? null;
    $contact_no = trim($_POST['contact-no']) ?? null;
    $address = trim($_POST['address']) ?? null;
    $email = trim($_POST['email']);

    // Check if email is unique
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM user WHERE email = ? AND id != ?");
    $stmt->execute([$email, $user_id]);
    if ($stmt->fetchColumn() > 0) {
        echo "<script>alert('Email is already in use!'); window.history.back();</script>";
        exit();
    }

    // Update profile
    $stmt = $pdo->prepare("UPDATE user SET firstName = ?, lastName = ?, middle_initial = ?, gender = ?, contact_no = ?, address = ?, email = ? WHERE id = ?");
    if ($stmt->execute([$first_name, $last_name, $middle_initial, $gender, $contact_no, $address, $email, $user_id])) {
        header("Location: ApplicantDashboardManageProfile.php?success=1");
        exit();
    } else {
        echo "<script>alert('Error updating profile. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en" id="manage-profile-page">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage My Profile - NumeroUno</title>
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
        <div class="admin-sidebar">
        <p class="admin-dashb">Applicant Dashboard</p>
        <ul>
            <li><a href="ApplicantDashboard.php">My Dashboard</a></li>
            <li><a href="ApplicantDashboardManageProfile.php">Manage My Profile</a></li>
            <li><a href="ApplicantDashboardApplicationStatus.php">Application Status</a></li>
            <li><a href="ApplicantDashboardAccountManagement.php">Account Management</a></li>
        </ul>
    </div>
        <div class="nav-right">
            <ul class="nav-links">
                <li class="dropdown">
                    <i class="ph ph-user" onclick="toggleDropdown('userDropdown')"></i>
                    <ul class="dropdown-menu" id="userDropdown">
                        <li><a href="ApplicantDashboard.php">My Dashboard</a></li>
                        <li><a href="ApplicantDashboardAccountManagement.php">Account Management</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="main-content-wrapper">
        <div class="page-content">
            <img id="profile-pic" src="profile-placeholder.png" alt="User Profile Picture">
            <h2 id="display-name"><?= htmlspecialchars($user['firstName'] . ' ' . $user['lastName']) ?></h2>
        </div>

        <form method="POST" id="profile-form">
            <div class="form-section-container">
                <h3>Personal Information</h3>
                <div class="form-grid two-columns">
                    <div>
                        <label for="first-name">First Name <span>*</span></label>
                        <input type="text" id="first-name" name="first-name" value="<?= htmlspecialchars($user['firstName']) ?>" required>
                    </div>
                    <div>
                        <label for="last-name">Last Name <span>*</span></label>
                        <input type="text" id="last-name" name="last-name" value="<?= htmlspecialchars($user['lastName']) ?>" required>
                    </div>
                    <div>
                        <label for="middle-initial">Middle Initial</label>
                        <input type="text" id="middle-initial" name="middle-initial" value="<?= htmlspecialchars($user['middle_initial'] ?? '') ?>">
                    </div>
                    <div>
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="">Select</option>
                            <option value="Male" <?= $user['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= $user['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-section-container">
                <h3>Contact Information</h3>
                <div class="form-grid two-columns">
                    <div>
                        <label for="contact-no">Contact No. <span>*</span></label>
                        <input type="text" id="contact-no" name="contact-no" value="<?= htmlspecialchars($user['contact_no'] ?? '') ?>" required>
                    </div>
                    <div>
                        <label for="email">Email Address <span>*</span></label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                    <div class="full-width">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
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

    window.onclick = function (event) {
        if (!event.target.matches('.ph')) {
            document.querySelectorAll(".dropdown-menu").forEach(menu => menu.classList.remove('show'));
        }
    };
</script>

</body>
</html>
