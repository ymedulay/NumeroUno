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
		<div class="logo">
			<a href="HomePage.html"><img src="numerouno.png" alt="Numero Uno Logo"></a>
		</div>

		<div class="nav-right">
			<!-- Correct Find Jobs Button -->
			<a href="FindJobPage.html" class="find-jobs-btn">Find Jobs</a>

			<!-- Menu Icon -->
			<div class="menu-icon">
				<i class="ph ph-list"></i>
			</div>
		</div>
	</nav>


	<!-- Sidebar (Initially Hidden) -->
	<div id="sideMenu" class="sidebar">
		<ul>
			<li><a href="#">About Us</a></li>
			<li><a href="#">Contact Us</a></li>
			<li><a href="#">FAQs</a></li>
		</ul>
	</div>
	</nav>

	<!-- End of Navigation Bar -->

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

	<!-- Container for Job Illustration and Job Description -->
	<div class="job-content-container">
		<!-- Job illustration image -->
		<div class="job-illustration-wrapper">
			<img src="Job hunt-rafiki.png" alt="Default Business Profile" class="job-image">
		</div>

		<!-- Job Description Container -->
		<div class="job-description-wrapper">
			<p class="job-details-title">JOB DETAILS</p>
			<p class="job-description">
				We are seeking a skilled and dedicated Shoemaker to join our growing team in Barangay Concepcion Uno, Marikina City, the heart of the Philippine shoe manufacturing industry. As a Shoemaker, you will be responsible for crafting high-quality footwear, from traditional designs to modern innovations. If you have a passion for craftsmanship and take pride in producing exceptional products, this is the perfect opportunity for you.
			</p>
			<p class="cv-requirement">*This job requires a curriculum vitae (CV).</p> <!-- Added text -->
		</div>
	</div>

	<!-- Other Details Container -->
	<div class="other-details-wrapper">
		<p class="other-details-title">OTHER DETAILS</p>
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

	 <!-- Application Form Container -->
	<div class="application-form">
	    <h2 class="form-title">JOB APPLICATION FORM</h2>

	<!-- Start of Form -->
    <form action="submit_form.php" method="POST">
	
	    <!-- Name Fields -->
	    <div class="name-container">
	        <div class="input-group-name">
	            <label for="first-name">First Name:</label>
	            <input type="text" id="first-name" name="first-name" placeholder="ex. John" required>
	        </div>
	        <div class="input-group-name">
	            <label for="last-name">Last Name:</label>
	            <input type="text" id="last-name" name="last-name" placeholder="ex. Dela Cruz" required>
	        </div>
	    </div>
		
		<!-- Birthdate & Gender Fields -->
        <div class="birth-gender-container">
            <div class="input-group-birthgender">
                <label for="birthdate">Birthdate:</label>
                <input type="date" id="birthdate" name="birthdate" required>
            </div>
            <div class="input-group-birthgender">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="" disabled selected>Select your gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="prefer-not">Prefer not to state</option>
                </select>
            </div>
		</div>
		
		<!-- Contact & Email Fields -->
		<div class="contact-email-container">
			<div class="input-group-contactemail">
				<label for="contact-number">Contact Number:</label>
				<input type="tel" id="contact-number" name="contact-number" pattern="[0-9]{11}" placeholder="e.g., 09123456789" required>
			</div>
			<div class="input-group-contactemail">
				<label for="email">Email Address:</label>
				<input type="email" id="email" name="email" placeholder="e.g., example@email.com" required>
			</div>
		</div>
		
		<!-- Home Address Field -->
		<div class="home-address-container">
			<div class="input-group-homeaddress">
				<label for="home-address">Home Address:</label>
				<input type="text" id="home-address" name="home-address" placeholder="Apartment/Building/House No., Street Name, Barangay, City" required>
			</div>
		</div>
		
		<!-- Job Type & Available Start Date Fields -->
		<div class="jobtype-startdate-container">
			<div class="input-group-jobtype">
				<label for="job-type">Job Type:</label>
				<select id="job-type" name="job-type" required>
					<option value="" disabled selected>Select job type</option>
					<option value="part-time">Part-time</option>
					<option value="full-time">Full-time</option>
				</select>
			</div>
			<div class="input-group-jobtype">
				<label for="start-date">Available Start Date:</label>
				<input type="date" id="start-date" name="start-date" required>
			</div>
		</div>
		
		<!-- CV Upload Container -->
		<div class="cv-upload-container">
			<label for="cv-upload">Upload CV:</label>
			<input type="file" id="cv-upload" name="cv-upload" accept=".pdf,.doc,.docx" required>
		</div>

		</form>

			<!-- Submit Button (Bottom Left) -->
			<div class="submit-container">
				<button class="submit-btn" type="submit" form="job-application-form">Submit</button>
			</div>
		
	</div> <!-- for applic form div -->
	
	<script src="sidebar.js"></script>

</body>
</html>
