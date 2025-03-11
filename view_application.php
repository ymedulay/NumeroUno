<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) { // Ensure only business users can access
    die("Unauthorized access.");
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Application ID is required.");
}

$applicationId = $_GET['id'];
$businessId = $_SESSION['user_id']; // The logged-in business user

try {
    $sql = "SELECT ja.*, 
                   jp.jobTitle, jp.jobDescription, 
                   u.firstName, u.lastName, u.email, u.contact_no, u.address, u.gender, 
                   ja.cvFilename 
            FROM jobapplication ja
            JOIN jobposting jp ON ja.jobPostingId = jp.id
            JOIN user u ON ja.applicantId = u.id
            WHERE ja.id = ? AND jp.businessId = ?"; // Ensures the business owns the job posting
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$applicationId, $businessId]);
    $application = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$application) {
        die("Application not found or you do not have permission to view this application.");
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Applicant Application</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Applicant Details</h2>

    <p><strong>Job Title:</strong> <?php echo htmlspecialchars($application['jobTitle']); ?></p>
    <p><strong>Job Description:</strong> <?php echo htmlspecialchars($application['jobDescription']); ?></p>
    
    <h3>Applicant Information</h3>
    <p><strong>First Name:</strong> <?php echo htmlspecialchars($application['firstName']); ?></p>
    <p><strong>Last Name:</strong> <?php echo htmlspecialchars($application['lastName']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($application['email']); ?></p>
    <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($application['contactNumber']); ?></p>
    <p><strong>Gender:</strong> <?php echo htmlspecialchars($application['gender']); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($application['homeAddress']); ?></p>

    <?php if (!empty($application['cvFilename'])): ?>
        <p><strong>Resume:</strong> <a href="uploads/<?php echo htmlspecialchars($application['cvFilename']); ?>" target="_blank">Download</a></p>
    <?php endif; ?>

    <a href="business_dashboard.php">Back to Dashboard</a>
</body>
</html>
