<?php
session_start();
require_once "config.php";


// Initialize filter variables
$search = isset($_GET['search']) ? $_GET['search'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$experience = isset($_GET['experience']) ? $_GET['experience'] : '';
$otherCategory = isset($_GET['other_category']) ? $_GET['other_category'] : '';

// Build the SQL query with dynamic filtering
$sql = "SELECT jp.id, jp.jobTitle, b.businessName, jp.jobDescription, jp.salaryRange, jp.jobLocation, jp.employmentType, jp.requirements 
        FROM jobposting jp 
        JOIN business b ON jp.businessId = b.id
        WHERE 1=1";
$params = [];

// Add search conditions
if (!empty($search)) {
    $sql .= " AND (jp.jobTitle LIKE ? OR jp.jobDescription LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($location)) {
    $sql .= " AND jp.jobLocation LIKE ?";
    $params[] = "%$location%";
}

// Handle category filtering through requirements or employmentType field
if (!empty($category)) {
    if ($category === "Service") {
        $sql .= " AND (jp.employmentType = 'Service' OR jp.requirements LIKE ?)";
        $params[] = "%Service%";
    } else if ($category === "House work") {
        $sql .= " AND (jp.employmentType = 'House work' OR jp.requirements LIKE ?)";
        $params[] = "%House work%";
    } else if ($category === "Others" && !empty($otherCategory)) {
        $sql .= " AND (jp.employmentType LIKE ? OR jp.requirements LIKE ?)";
        $params[] = "%$otherCategory%";
        $params[] = "%$otherCategory%";
    }
}

// Handle experience level filtering through requirements field
if (!empty($experience)) {
    $sql .= " AND jp.requirements LIKE ?";
    $params[] = "%Experience Level: $experience%";
}

// Fetch job postings from the database
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching jobs: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NumeroUno</title>
    <link rel="icon" href="img/numerouno.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="./styles.css" rel="stylesheet">
</head>

<body id="findJobPage">
    <!-- Navigation Bar -->
    <nav>
        <div class="logo">
            <a href="HomePage.php"><img src="img/numerouno.png" alt="Numero Uno Logo"></a>
        </div>

        <div class="nav-right">

            <!-- Menu Icon -->
            <div class="menu-icon">
                <i class="ph ph-list"></i>
            </div>
        </div>
    </nav>


    <!-- Sidebar (Initially Hidden) -->
    <div id="sideMenu" class="sidebar">
        <ul>
            <li><a href="LoginPage.html">Login / Sign Up</a></li>
            <li><a href="AboutUs.html">About Us</a></li>
            <li><a href="ContactUs.php">Contact Us</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    </nav>

    <!-- End of Navigation Bar -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <form id="searchForm" action="FindJobPage.php" method="GET">
        <div class="search-container">
            <div class="search-box-container">
                <i class="ph ph-magnifying-glass"></i>
                <input type="text" class="search-box" name="search" placeholder="Search Job" value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <div class="search-box-container">
                <input type="text" class="search-box" name="location" placeholder="Location" value="<?php echo htmlspecialchars($location); ?>">
                <i class="ph ph-gps-fix"></i>
            </div>
        </div>
        <div class="find-job-container">
            <div class="vertical-panel">
                <p>Categories</p>
                <label><input type="radio" name="category" value="Service" <?php echo ($category === 'Service') ? 'checked' : ''; ?>> Service</label><br>
                <label><input type="radio" name="category" value="House work" <?php echo ($category === 'House work') ? 'checked' : ''; ?>> House work</label><br>
                <label><input type="radio" name="category" value="Others" <?php echo ($category === 'Others') ? 'checked' : ''; ?>> Others
                    <input type="text" name="other_category" placeholder="Please specify" id="other-category"
                        style="display: <?php echo ($category === 'Others') ? 'block' : 'none'; ?>;"
                        value="<?php echo htmlspecialchars($otherCategory); ?>">
                </label>
                <button type="button" class="clear-all-btn" onclick="clearSelections()">Clear All</button>
            </div>
            <div class="job-postings">
                <?php if (count($jobs) > 0) { ?>
                    <?php foreach ($jobs as $job) { ?>
                        <div class="job-posting">
                            <h3><?php echo htmlspecialchars($job['jobTitle']); ?></h3>
                            <p class="business-name"><?php echo htmlspecialchars($job['businessName']); ?></p>
                            <p class="job-description"><?php echo htmlspecialchars($job['jobDescription']); ?></p>
                            <p class="salary">₱<?php echo htmlspecialchars($job['salaryRange']); ?> / month</p>
                            <a href="FindJobDetails.php?id=<?php echo $job['id']; ?>" class="view-btn">View Here</a>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="no-results">
                        <p>No job postings found matching your criteria.</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </form>

    <script>
        // Handle the "Others" category input display
        const othersRadio = document.querySelector('input[value="Others"]');
        const otherInput = document.getElementById('other-category');

        othersRadio.addEventListener('change', function() {
            if (this.checked) {
                otherInput.style.display = 'block';
            }
        });

        document.querySelectorAll('input[name="category"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value !== "Others") {
                    otherInput.style.display = 'none';
                }
                submitSearch(); // Auto-submit when category changes
            });
        });

        // Auto-submit form when experience level changes
        document.querySelectorAll('input[name="experience"]').forEach(radio => {
            radio.addEventListener('change', function() {
                submitSearch();
            });
        });

        // Function to clear all selections and refresh results
        function clearSelections() {
            document.querySelectorAll('.vertical-panel input[type="radio"]').forEach(radio => {
                radio.checked = false;
            });
            document.getElementById('other-category').style.display = 'none';
            document.getElementById('other-category').value = '';
            document.querySelector('input[name="search"]').value = '';
            document.querySelector('input[name="location"]').value = '';

            // Submit the form to refresh the results
            document.getElementById('searchForm').submit();
        }

        // Function to submit the search form
        function submitSearch() {
            document.getElementById('searchForm').submit();
        }

        // Handle enter key press in search inputs
        document.querySelectorAll('.search-box').forEach(input => {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    submitSearch();
                }
            });
        });

        // Handle enter key press in other-category input
        document.getElementById('other-category').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                submitSearch();
            }
        });
    </script>

    <script src="js/sidebar.js"></script>
    <script src="js/scroll.js"></script>
</body>

</html>