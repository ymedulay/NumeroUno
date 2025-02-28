<?php
session_start();
// check if the user is logged in as a business
if (!isset($_SESSION['business_logged_in'])) {
    header("Location: LoginPage.php");
    exit();
}

// dummy business information for now
$businessInfo = [
    "name" => "[Business Name]",
    "address" => "[Address]",
    "contact" => "[Contact No.]",
    "email" => "[Email]",
    "type" => "[Business Type]",
    "description" => "[Short Description]"
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Dashboard - NumeroUno</title>
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body id="business-dash-main">
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

    <div class="page-content">
        <h1>Business Dashboard</h1>
        <div class="profile-section">
            <img src="assets/images/business.png" alt="Business Logo">
            <h2><?php echo $businessInfo['name']; ?></h2>
        </div>
        <div class="info-section">
            <div class="info-box">
                <h2>Business Information</h2>
                <p><strong>Name:</strong> <?php echo $businessInfo['name']; ?></p>
                <p><strong>Address:</strong> <?php echo $businessInfo['address']; ?></p>
                <p><strong>Contact:</strong> <?php echo $businessInfo['contact']; ?></p>
                <p><strong>Email:</strong> <?php echo $businessInfo['email']; ?></p>
                <p><strong>Type:</strong> <?php echo $businessInfo['type']; ?></p>
                <p><strong>Description:</strong> <?php echo $businessInfo['description']; ?></p>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown(id) {
            document.querySelectorAll(".dropdown-menu").forEach(menu => {
                if (menu.id !== id) menu.classList.remove("show");
            });
            document.getElementById(id).classList.toggle("show");
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