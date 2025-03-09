<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NumeroUno</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="./styles.css" rel="stylesheet">
</head>

<body id="find-job-deets">

     <!-- Navigation Bar -->
    <nav>
        <!-- Logo -->
        <div class="logo">
            <img src="NumeroUnoLogo.png" alt="Numero Uno Logo">
        </div>

        <!-- Left Navi Links (Home & Find Job) -->
        <div class="nav-left">
            <ul class="nav-links">
                <li><a href="HomePage.html">Home</a></li>
                <li><a href="FindJobPage.html">Find Job</a></li>
            </ul>
        </div>

		<!-- Right Navi Icons -->
        <div class="nav-right">
            <ul class="nav-links">
                <li class="dropdown">
                    <i class="ph ph-user" onclick="toggleDropdown('userDropdown')"></i> 
                    <ul class="dropdown-menu" id="userDropdown">
                        <li><a href="HomePage.html">Log-In</a></li>
						<li><a href="AccountSelection.html">Sign-Up</a></li>
                        <li><a href="ApplicantDashboardManageProfile.html">My Account</a></li>
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
    <!-- End of Navi Bar -->

    <!-- Phosphor Icons CDN -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Dropdown Toggle Script -->
    <script>
        function toggleDropdown(id) {
		document.querySelectorAll(".dropdown-menu").forEach(menu => {
			if (menu.id !== id) menu.classList.remove("show");
		});
		document.getElementById(id).classList.toggle("show");
	}


       // Close dropdown if user clicks outside
		window.onclick = function(event) {
			if (!event.target.matches('.ph, .ph *')) {  // Adjust to allow clicking on the icon itself
				let dropdowns = document.getElementsByClassName("dropdown-menu");
				for (let i = 0; i < dropdowns.length; i++) {
					let openDropdown = dropdowns[i];
					if (openDropdown.classList.contains('show')) {
						openDropdown.classList.remove('show');
					}
				}
			}
		}
    </script>
	
	<!-- Horizontal Container for Job Title -->
	<div class="job-title-wrapper">
		<div class="job-title-container">
			<p class="job-title">JOB TITLE</p>
		</div>
	</div>

	<!-- Container for Job Illustration and Job Description -->
	<div class="job-content-container">
		<!-- Job illustration image -->
		<div class="job-illustration-wrapper">
			<img src="BusinessProfile.png" alt="Default Business Profile" class="job-image">
		</div>

		<!-- Job Description Container -->
		<div class="job-description-wrapper">
			<p class="job-details-title">Job Details</p>
			<p class="job-description">
				We are seeking a skilled and dedicated Shoemaker to join our growing team in Barangay Concepcion Uno, Marikina City, the heart of the Philippine shoe manufacturing industry. As a Shoemaker, you will be responsible for crafting high-quality footwear, from traditional designs to modern innovations. If you have a passion for craftsmanship and take pride in producing exceptional products, this is the perfect opportunity for you.
			</p>
			<p class="cv-requirement">*This job requires a curriculum vitae (CV).</p> <!-- Added text -->
		</div>
	</div>

	<!-- Other Details Container -->
	<div class="other-details-wrapper">
		<p class="other-details-title">Other Details</p>
		<div class="other-details-container">
			<div class="detail-box">
				<p class="detail-label">Hourly Pay</p>
				<p class="detail-text">₱₱₱ / hour</p> <!-- Placeholder -->
			</div>
			<div class="detail-box">
				<p class="detail-label">Job Type</p>
				<p class="detail-text">Part-time / Full-time</p> <!-- Placeholder -->
			</div>
			<div class="detail-box">
				<p class="detail-label">Location</p>
				<p class="detail-text">Barangay Concepcion Uno, Marikina City</p> <!-- Placeholder -->
			</div>
		</div>
	</div>

    <!-- Application Section -->
    <div class="application-wrapper">
        <p class="application-text">If you’re interested in this job posting, click the button to be directed to the Application form.</p>
        <a href="FindJobAppli.html" class="apply-button">Apply Here</a>
    </div>
	
</body>
</html>
