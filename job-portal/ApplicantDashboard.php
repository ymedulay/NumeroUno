<?php
session_start();

// Dummy user data for demonstration (replace with database query later)
$user = [
    'first_name' => 'John',
    'middle_initial' => 'D.',
    'last_name' => 'Doe',
    'email' => 'johndoe@example.com',
    'degree' => 'Bachelor of Science in Computer Science',
    'company' => 'Tech Corp',
    'job_title' => 'Software Developer',
    'profile_pic' => 'ProfilePic.jpg'
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Dashboard - NumeroUno</title>
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body id="applicant-dash-main">
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

    <div class="page-content">
        <div class="profile-section">
            <img src="<?php echo $user['profile_pic']; ?>" alt="User Profile Picture">
            <h2><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h2>
        </div>
        <div class="info-section">
            <div class="info-box">
                <h2>User Information</h2>
                <p><strong>First Name:</strong> <?php echo $user['first_name']; ?></p>
                <p><strong>Middle Initial:</strong> <?php echo $user['middle_initial']; ?></p>
                <p><strong>Last Name:</strong> <?php echo $user['last_name']; ?></p>
                <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            </div>
            <div class="info-box">
                <h2>Educational Background</h2>
                <p><strong>Highest Degree:</strong> <?php echo $user['degree']; ?></p>
            </div>
            <div class="info-box">
                <h2>Job Experience</h2>
                <p><strong>Company:</strong> <?php echo $user['company']; ?></p>
                <p><strong>Job Title:</strong> <?php echo $user['job_title']; ?></p>
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