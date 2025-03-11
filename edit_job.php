<?php
session_start();
require_once 'config.php'; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['business_id'])) {
    header("Location: login.php");
    exit();
}

$business_id = $_SESSION['business_id'];

// Check if job ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: Job ID is missing.");
}

$job_id = intval($_GET['id']);

// Fetch job details
try {
    $stmt = $pdo->prepare("SELECT jobTitle FROM JobPosting WHERE id = :job_id AND businessId = :business_id");
    $stmt->bindParam(":job_id", $job_id, PDO::PARAM_INT);
    $stmt->bindParam(":business_id", $business_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        die("Error: Job not found.");
    }

    $job = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

// Handle form submission for updating job
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_job'])) {
    $new_job_title = trim($_POST['job_title']);

    if (empty($new_job_title)) {
        $error = "Job title cannot be empty.";
    } else {
        try {
            $update_stmt = $pdo->prepare("UPDATE JobPosting SET jobTitle = :job_title WHERE id = :job_id AND businessId = :business_id");
            $update_stmt->bindParam(":job_title", $new_job_title, PDO::PARAM_STR);
            $update_stmt->bindParam(":job_id", $job_id, PDO::PARAM_INT);
            $update_stmt->bindParam(":business_id", $business_id, PDO::PARAM_INT);
            $update_stmt->execute();

            header("Location: BusinessDashPostManage.php"); // Redirect after update
            exit();
        } catch (PDOException $e) {
            die("Error updating job: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job - NumeroUno</title>
    <link rel="icon" href="img/numerouno.png" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="edit-job-container">
        <h1>Edit Job Posting</h1>

        <?php if (isset($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="job_title">Job Title:</label>
            <input type="text" id="job_title" name="job_title" value="<?= htmlspecialchars($job['jobTitle']) ?>" required>
            <button type="submit" name="update_job">Update Job</button>
        </form>
        <a href="BusinessDashPostManage.php">Cancel</a>
    </div>

    <script src="js/sidebar.js"></script>
    <script src="js/scroll.js"></script>

</body>

</html>