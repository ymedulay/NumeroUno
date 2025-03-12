<?php
require_once "config.php";

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the application ID and action from the form
    $application_id = $_POST['id'];
    $action = $_POST['action'];

    // Validate the action (optional, but recommended)
    if ($action != "accept" && $action != "reject") {
        echo "Invalid action.";
        exit;
    }

    // Determine the new status
    $new_status = ($action == "accept") ? "Accepted" : "Rejected";

    try {
        // Update the application status in the database
        $sql = "UPDATE jobapplication SET status = :status WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':status', $new_status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $application_id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect back to the view_application.php with a success message
        header("Location: view_application.php?id=" . $application_id . "&status_updated=true");
        exit;

    } catch (PDOException $e) {
        // Handle database errors
        echo "Database error: " . $e->getMessage();
        exit;
    }
} else {
    // If it's not a POST request, redirect to an error page or the dashboard
    header("Location: BusinessDashboard.php"); // Or an error page
    exit;
}
?>

