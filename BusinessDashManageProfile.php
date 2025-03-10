<?php
session_start();
require_once "config.php"; // Ensure this file is included

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role_id'])) {
    die("Access Denied. Please log in.");
}

// Restrict access based on role
$roleId = $_SESSION['role_id'];
$pageRole = 2; 

if ($roleId != $pageRole) {
    echo "Access denied.";
    exit();
}

// Ensure the PDO database connection is available
if (!isset($pdo)) {
    die("Database connection error.");
}

// Fetch business details using PDO
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM Business WHERE userId = :userId"; // Ensure column name is correct

$stmt = $pdo->prepare($sql);
$stmt->bindParam(":userId", $user_id, PDO::PARAM_INT); // Ensure parameter name matches query
$stmt->execute();
$business = $stmt->fetch(PDO::FETCH_ASSOC);
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
            <img src="NumeroUnoLogo.png" alt="Numero Uno Logo">
        </div>
        <div class="nav-left">
            <ul class="nav-links">
                <li><a href="HomePage.html">Home</a></li>
                <li><a href="FindJobPage.html">Find Job</a></li>
            </ul>
        </div>
        <div class="nav-right">
            <ul class="nav-links">
                <li class="dropdown">
                    <i class="ph ph-user" onclick="toggleDropdown('userDropdown')"></i>
                    <ul class="dropdown-menu" id="userDropdown">
                        <li><a href="BusinessDashboard.php">My Dashboard</a></li>
                        <li><a href="BusinessDashManageProfile.php">Manage Profile</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <i class="ph ph-gear" onclick="toggleDropdown('settingsDropdown')"></i>
                    <ul class="dropdown-menu" id="settingsDropdown">
                        <li><a href="AboutUs.html">About Us</a></li>
                        <li><a href="ContactUs.html">Contact Us</a></li>
                        <li><a href="FAQs.html">FAQs</a></li>
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
            <img id="profile-pic" src="<?php echo !empty($business['profileImage']) ? htmlspecialchars($business['profileImage']) : 'BusinessLogo.jpg'; ?>" alt="Business Logo">
            <h2 id="display-name"><?php echo htmlspecialchars($business['businessName'] ?? ''); ?></h2>
            <form class="profile-form" method="post" action="business_update.php" enctype="multipart/form-data">
                <input type="file" id="upload-profile-pic" name="profile_picture" style="display: none;" accept="image/*">
                <button type="button" class="change-profile-pic" onclick="document.getElementById('upload-profile-pic').click();">
                    Change Profile Picture
                </button>
        </div>

            <div class="form-section-container">
                <h2>Business Information</h2>
                <div class="form-grid two-columns">
                    <div>
                        <label for="business-name">Business Name:</label>
                        <input type="text" id="business-name" name="business-name" value="<?php echo htmlspecialchars($business['businessName'] ?? ''); ?>" required>
                    </div>
                    <div>
                        <label for="business-type">Business Type:</label>
                        <select id="business-type" name="business-type" required>
                            <option value="">Select</option>
                            <option value="Sole Proprietorship" <?php if(($business['businessType'] ?? '') == 'Sole Proprietorship') echo 'selected'; ?>>Sole Proprietorship</option>
                            <option value="Partnership" <?php if(($business['businessType'] ?? '') == 'Partnership') echo 'selected'; ?>>Partnership</option>
                            <option value="LLC" <?php if(($business['businessType'] ?? '') == 'LLC') echo 'selected'; ?>>Limited Liability Company (LLC)</option>
                            <option value="Corporation" <?php if(($business['businessType'] ?? '') == 'Corporation') echo 'selected'; ?>>Corporation</option>
                        </select>
                    </div>
                    <div>
                        <label for="description">Business Description:</label>
                        <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($business['description'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>
            
            <div class="form-section-container">
                <h2>Contact Information</h2>
                <div class="form-grid two-columns">
                    <div>
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($business['address'] ?? ''); ?>" required>
                    </div>
                    <div>
                        <label for="contact">Contact No.:</label>
                        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($business['phoneNumber'] ?? ''); ?>" required>
                    </div>
                    <div>
                        <label for="email">Email Address:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($business['contactEmail'] ?? ''); ?>" required>
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
        
        // Add preview functionality for the profile picture
        document.getElementById('upload-profile-pic').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    document.getElementById('profile-pic').src = e.target.result;
                }
                
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
</body>
</html>