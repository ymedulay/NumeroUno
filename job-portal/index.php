<?php include 'nav.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NumeroUno</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>

<body id="homePage" class="home-page">

    <!-- Hero Section (Text + Image) -->
    <div class="hero-section">
        <!-- Text Section -->
        <div class="hero-text">
            <p>Introducing</p>
            <h2>NumeroUno</h2>
            <p class="description">Placeholder text for website description.</p>
        </div>

        <!-- Image Section -->
        <div class="hero-image">
            <img src="assets/images/Job hunt-amico.png" alt="Job Hunt Image">
        </div>
    </div>

    <!-- Search Box -->
    <div class="main-container">
        <div class="search-box-container">
            <i class="ph ph-magnifying-glass"></i>
            <input type="text" class="search-box" placeholder="What job are you looking for?">
        </div>
        <div class="search-box-container">
            <i class="ph ph-navigation-arrow"></i>
            <input type="text" class="search-box" placeholder="Location">
        </div>
    </div>

    <!-- Recent Job Postings -->
    <div class="homepage-job-postings">
        <h2 align="left">Recently posted jobs</h2>
        <div class="job-postings-grid">
            <div class="job-card">
                <h3>Job Title</h3>
                <p>Company ABC</p>
                <p>📍 Loc</p>
            </div>
            <div class="job-card">
                <h3>Job Title</h3>
                <p>Company XYZ</p>
                <p>📍 Loc</p>
            </div>
            <div class="job-card">
                <h3>Job Title</h3>
                <p>Company LMN</p>
                <p>📍 Loc</p>
            </div>
        </div>

        <a href="FindJobPage.php">
            <button class="view-more">View More</button>
        </a>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-container">
        <h3>USER REVIEWS</h3>
        <div class="reviews-slider">
            <button class="prev-btn">❜</button>
            <div class="reviews-images">
                <img src="assets/images/UserReview1.png" alt="User Review">
                <img src="assets/images/UserReview2.png" alt="User Review">
                <img src="assets/images/UserReview3.png" alt="User Review">
                <img src="assets/images/UserReview4.png" alt="User Review">
                <img src="assets/images/UserReview5.png" alt="User Review">
            </div>
            <button class="next-btn">❛</button>
        </div>
    </div>

    <!-- JavaScript Files -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="scripts.js"></script>

    <footer class="footer">
        <p>Copyright &copy; 2025</p>
    </footer>
</body>

</html>