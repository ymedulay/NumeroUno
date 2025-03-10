<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NumeroUno</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>

<body id="findJobPage">

    <?php include 'nav.php'; ?>

    <!-- Search Boxes Below Navigation -->
    <div class="search-container">
        <div class="search-box-container">
            <i class="ph ph-magnifying-glass"></i>
            <input type="text" class="search-box" placeholder="Search Job">
        </div>
        <div class="search-box-container">
            <input type="text" class="search-box" placeholder="Location">
            <i class="ph ph-gps-fix"></i> <!-- GPS icon -->
        </div>
    </div>

    <!-- LEFT & RIGHT PANELS -->
    <div class="find-job-container">
        <!-- Left Panel -->
        <div class="vertical-panel">
            <p>Categories</p>
            <label>
                <input type="radio" name="category" value="Service"> Service
            </label>
            <br>
            <label>
                <input type="radio" name="category" value="House work"> House work
            </label>
            <br>
            <label>
                <input type="radio" name="category" value="Others"> Others
                <input type="text" placeholder="Please specify" id="other-category" style="display: none;">
            </label>

            <p>Experience Level</p>
            <div class="experience-level">
                <label><input type="radio" name="experience" value="1"> 1</label>
                <label><input type="radio" name="experience" value="2"> 2</label>
                <label><input type="radio" name="experience" value="3"> 3</label>
                <label><input type="radio" name="experience" value="4"> 4</label>
                <label><input type="radio" name="experience" value="5"> 5</label>
            </div>

            <button class="clear-all-btn" onclick="clearSelections()">Clear All</button>
        </div>

        <!-- Right Panel (Job Postings) -->
        <div class="job-postings">
            <div class="job-posting">
                <h3>Shoemaker</h3>
                <p class="business-name">Marikina Handcrafted Shoes</p>
                <p class="job-description">Help create high-quality handcrafted shoes, a local Marikina tradition.</p>
                <p class="salary">₱₱₱ / month</p>
                <a href="FindJobDetails.html" class="view-btn">View Here</a>
            </div>

            <div class="job-posting">
                <h3>Barangay Health Worker</h3>
                <p class="business-name">Barangay Health Center</p>
                <p class="job-description">Assist in community health programs and provide medical aid to residents.</p>
                <p class="salary">₱₱₱ / month</p>
                <a href="FindJobDetails.html" class="view-btn">View Here</a>
            </div>

            <div class="job-posting">
                <h3>Food Vendor</h3>
                <p class="business-name">Mang Juan's Street Eats</p>
                <p class="job-description">Prepare and sell street food such as kwek-kwek, fish balls, and banana cue.</p>
                <p class="salary">₱₱₱ / month</p>
                <a href="FindJobDetails.html" class="view-btn">View Here</a>
            </div>

            <div class="job-posting household-helper">
                <h3>Household Helper</h3>
                <p class="business-name">Private Household</p>
                <p class="job-description">Assist in household chores such as cleaning and cooking.</p>
                <p class="salary">₱₱₱ / month</p>
                <a href="FindJobDetails.html" class="view-btn">View Here</a>
            </div>

            <div class="job-posting">
                <h3>Tricycle Driver</h3>
                <p class="business-name">Local Transport Service</p>
                <p class="job-description">Drive passengers safely around the community.</p>
                <p class="salary">₱₱₱ / month</p>
                <a href="FindJobDetails.html" class="view-btn">View Here</a>
            </div>
        </div>
    </div>

    <!-- JavaScript Scripts -->
    <script>
        // Show input field when "Others" is selected
        const othersRadio = document.querySelector('input[value="Others"]');
        const otherInput = document.getElementById('other-category');

        othersRadio.addEventListener('change', function() {
            if (this.checked) {
                otherInput.style.display = 'block'; // Show the input box
            }
        });

        // Hide the input field when another option is selected
        document.querySelectorAll('input[name="category"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value !== "Others") {
                    otherInput.style.display = 'none'; // Hide input box
                }
            });
        });

        // Clear All button function
        function clearSelections() {
            document.querySelectorAll('.vertical-panel input[type="radio"]').forEach(radio => {
                radio.checked = false;
            });
        }
    </script>

</body>

</html>