<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$business_id = null;

// Fetch the business ID
try {
    $stmt = $pdo->prepare("SELECT id FROM Business WHERE userId = :user_id");
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $business = $stmt->fetch(PDO::FETCH_ASSOC);
        $business_id = $business['id'];
    } else {
        die("Error: No business profile found. Please create a business profile first.");
    }
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

// Handle Job Posting
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jobTitle = trim($_POST['jobTitle']);
    $jobDescription = trim($_POST['description']);
    $jobLocation = trim($_POST['jobLocation']);
    $salaryRange = trim($_POST['salaryRange']);
    $qualifications = trim($_POST['qualifications']);
    $employmentType = trim($_POST['employmentType']);
    
    if (empty($jobTitle) || empty($jobDescription) || empty($qualifications)) {
        $error_message = "Job title, description, and qualifications are required.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO JobPosting 
                (businessId, jobTitle, jobDescription, jobLocation, salaryRange, requirements, employmentType, status) 
                VALUES (:business_id, :jobTitle, :description, :jobLocation, :salaryRange, :qualifications, :employmentType, 'Pending Approval')");

            $stmt->bindParam(":business_id", $business_id, PDO::PARAM_INT);
            $stmt->bindParam(":jobTitle", $jobTitle, PDO::PARAM_STR);
            $stmt->bindParam(":description", $jobDescription, PDO::PARAM_STR);
            $stmt->bindParam(":qualifications", $qualifications, PDO::PARAM_STR);
            $stmt->bindParam(":jobLocation", $jobLocation, PDO::PARAM_STR);
            $stmt->bindParam(":salaryRange", $salaryRange, PDO::PARAM_STR);
            $stmt->bindParam(":employmentType", $employmentType, PDO::PARAM_STR);
            $stmt->execute();

            $_SESSION['success_message'] = "Job posted successfully. Awaiting admin approval.";
            header("Location: BusinessDashPostManage.php");
            exit();
        } catch (PDOException $e) {
            $error_message = "Error posting job: " . $e->getMessage();
        }
    }
}
?>
