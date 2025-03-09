<?php
session_start();
require 'config.php'; // Database connection

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: LoginPage.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch existing business profile
$stmt = $pdo->prepare("SELECT * FROM BusinessProfiles WHERE user_id = ?");
$stmt->execute([$user_id]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $businessName = $_POST['business-name'];
    $businessType = $_POST['business-type'];
    $description = $_POST['description'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    if ($profile) {
        // Update existing profile
        $stmt = $pdo->prepare("
            UPDATE BusinessProfiles 
            SET business_name=?, business_type=?, description=?, address=?, contact=?, email=? 
            WHERE user_id=?
        ");
        $stmt->execute([$businessName, $businessType, $description, $address, $contact, $email, $user_id]);
    } else {
        // Insert new profile
        $stmt = $pdo->prepare("
            INSERT INTO BusinessProfiles (user_id, business_name, business_type, description, address, contact, email) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$user_id, $businessName, $businessType, $description, $address, $contact, $email]);
    }

    echo "<script>alert('Profile updated successfully!'); window.location.href='BusinessDashManageProfile.php';</script>";
}
?>

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

    <!-- Navbar -->
    <nav>
        <div class="logo">
            <img src="numerouno.png" alt="Numero Uno Logo">
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
            <h1>Business Manage Profile</h1>
            <img id="profile-pic" src="<?= isset($profile['profile_image']) ? $profile['profile_image'] : 'BusinessLogo.jpg'; ?>" alt="Business Logo">
            <h2 id="display-name"><?= isset($profile['business_name']) ? htmlspecialchars($profile['business_name']) : 'User Name'; ?></h2>
            <input type="file" id="upload-profile-pic" style="display: none;">
            <button class="change-profile-pic" onclick="document.getElementById('upload-profile-pic').click();">
                Change Profile Picture
            </button>
        </div>

        <form method="POST" class="profile-form">
            <div class="form-section-container">
                <h2>Business Information</h2>
                <div class="form-grid two-columns">
                    <div>
                        <label for="business-name">Business Name:</label>
                        <input type="text" id="business-name" name="business-name" value="<?= htmlspecialchars($profile['business_name'] ?? '') ?>" required>
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
                        <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($profile['description'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        
            <div class="form-section-container">
                <h2>Contact Information</h2>
                <div class="form-grid two-columns">
                    <div>
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" value="<?= htmlspecialchars($profile['address'] ?? '') ?>" required>
                    </div>
                    <div>
                        <label for="contact">Contact No.:</label>
                        <input type="text" id="contact" name="contact" value="<?= htmlspecialchars($profile['contact'] ?? '') ?>" required>
                    </div>
                    <div>
                        <label for="email">Email Address:</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($profile['email'] ?? '') ?>" required>
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
