<?php
session_start();
require_once "config.php"; // Ensure database connection is included

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role_id'])) {
    die("Access Denied. Please log in.");
}

// Restrict access based on role
$roleId = $_SESSION['role_id'];
$pageRole = 2; // Ensure only business users can update

if ($roleId != $pageRole) {
    echo "Access denied.";
    exit();
}

// Ensure database connection is available
if (!isset($pdo)) {
    die("Database connection error.");
}

// Retrieve business details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM business WHERE userId = :userId";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":userId", $user_id, PDO::PARAM_INT);
$stmt->execute();
$business = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$business) {
    die("Business profile not found.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $businessName = $_POST["business-name"];
    $businessType = $_POST["business-type"];
    $description = $_POST["description"];
    $address = $_POST["address"];
    $contact = $_POST["contact"];
    $email = $_POST["email"];

    // Update business details without profile image
    $updateSQL = "UPDATE Business SET businessName = :businessName, businessType = :businessType, 
                description = :description, address = :address, phoneNumber = :contact, 
                contactEmail = :email WHERE userId = :userId";

    $updateStmt = $pdo->prepare($updateSQL);
    $updateStmt->bindParam(":businessName", $businessName, PDO::PARAM_STR);
    $updateStmt->bindParam(":businessType", $businessType, PDO::PARAM_STR);
    $updateStmt->bindParam(":description", $description, PDO::PARAM_STR);
    $updateStmt->bindParam(":address", $address, PDO::PARAM_STR);
    $updateStmt->bindParam(":contact", $contact, PDO::PARAM_STR);
    $updateStmt->bindParam(":email", $email, PDO::PARAM_STR);
    $updateStmt->bindParam(":userId", $user_id, PDO::PARAM_INT);

    if ($updateStmt->execute()) {
        // Redirect back to profile page with success message
        header("Location: BusinessDashManageProfile.php?success=1");
        exit();
    } else {
        echo "Error updating profile: ";
        print_r($updateStmt->errorInfo());
    }
}
?>
