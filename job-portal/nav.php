	<!-- Navigation Bar -->
	<nav>
		<!-- Logo -->
		<div class="logo">
			<img src="assets/images/NumeroUnoLogo.png" alt="Numero Uno Logo">
		</div>

		<!-- Left Navi Links (Home & Find Job) -->
		<div class="nav-left">
			<ul class="nav-links">
				<li><a href="index.php">Home</a></li>
				<li><a href="FindJobPage.php">Find Job</a></li>
			</ul>
		</div>

		<!-- Right Navi Icons -->
		<div class="nav-right">
			<ul class="nav-links">
				<li class="dropdown">
					<i class="ph ph-user" onclick="toggleDropdown('userDropdown')"></i>
					<ul class="dropdown-menu" id="userDropdown">
						<li><a href="LoginPage.php">Log-In</a></li>
						<li><a href="AccountSelection.php">Sign-Up</a></li>
						<li><a href="ApplicantDashboardManageProfile.php">My Account</a></li>
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
			if (!event.target.matches('.ph, .ph *')) { // Adjust to allow clicking on the icon itself
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