<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: LoginPage.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$jobPostingId = isset($_POST['jobPostingId']) ? $_POST['jobPostingId'] : null;

// Validate that we have a job posting ID
if (!$jobPostingId) {
    die("Error: No job posting ID provided.");
}

// Fetch user details
$stmt = $pdo->prepare("SELECT firstName, lastName, email FROM user WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Error: User information could not be retrieved.");
}

// Handle Job Application
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $birthdate = trim($_POST['birthdate']);
    $gender = trim($_POST['gender']);
    $contactNumber = trim($_POST['contact-number']);
    $homeAddress = trim($_POST['home-address']);
    $jobType = trim($_POST['job-type']);
    $startDate = trim($_POST['start-date']);
    $firstName = $user['firstName'];
    $lastName = $user['lastName'];
    $email = $user['email'];
    
    // Check for required fields
    if (empty($birthdate) || empty($gender) || empty($contactNumber) || empty($homeAddress) || empty($jobType) || empty($startDate)) {
        die("Error: All fields are required.");
    }
    
    // Handle file upload for CV
    $cvFilename = null;
    $resume = null;
    
    if (isset($_FILES['cv-upload']) && $_FILES['cv-upload']['size'] > 0) {
        $allowed = array('pdf', 'doc', 'docx');
        $filename = $_FILES['cv-upload']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (!in_array($ext, $allowed)) {
            die("Error: Only PDF, DOC, and DOCX files are allowed for CV upload.");
        }
        
        // Create uploads directory if it doesn't exist
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Generate unique filename
        $newFilename = uniqid('cv_') . '.' . $ext;
        $fullPath = $uploadDir . $newFilename;
        
        // Move uploaded file
        if (!move_uploaded_file($_FILES['cv-upload']['tmp_name'], $fullPath)) {
            die("Error: Failed to upload CV file.");
        }
        
        $cvFilename = $newFilename;
        $resume = $fullPath; // Store the full path in the resume field
    }
    
    // Store application in database
    try {
        $stmt = $pdo->prepare("INSERT INTO JobApplication 
            (applicantId, JobPostingId, birthdate, gender, contactNumber, homeAddress, 
             JobType, startDate, cvFilename, resume, status, firstName, lastName, email) 
            VALUES (:applicantId, :jobPostingId, :birthdate, :gender, :contactNumber, :homeAddress, 
                   :jobType, :startDate, :cvFilename, :resume, 'Pending', :firstName, :lastName, :email)");
        
        $stmt->bindParam(":applicantId", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":jobPostingId", $jobPostingId, PDO::PARAM_INT);
        $stmt->bindParam(":birthdate", $birthdate);
        $stmt->bindParam(":gender", $gender);
        $stmt->bindParam(":contactNumber", $contactNumber);
        $stmt->bindParam(":homeAddress", $homeAddress);
        $stmt->bindParam(":jobType", $jobType);
        $stmt->bindParam(":startDate", $startDate);
        $stmt->bindParam(":cvFilename", $cvFilename);
        $stmt->bindParam(":resume", $resume);
        $stmt->bindParam(":firstName", $firstName);
        $stmt->bindParam(":lastName", $lastName);
        $stmt->bindParam(":email", $email);
        
        $stmt->execute();
        
        // Set success message and redirect
        $_SESSION['success_message'] = "Your job application has been submitted successfully!";
        header("Location: FindJobPage.php");
        exit();
        
    } catch (PDOException $e) {
        die("Database Error: " . $e->getMessage());
    }
} else {
    // If not POST request, redirect to job listings
    header("Location: FindJobPage.php");
    exit();
}
?>