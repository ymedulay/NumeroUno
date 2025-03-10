<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (empty($_POST)) {
            throw new Exception("Error: No form data received.");
        }

        // Ensure required fields exist
        if (!isset($_POST['userId']) || empty($_POST['userId'])) {
            throw new Exception("Error: Missing required field - userId");
        }

        $userId = $_POST['userId'];
        $resume = $_POST['resume'] ?? NULL; // If resume is optional

        // Insert into database
        $sql = "INSERT INTO applicant (userId, resume) VALUES (:userId, :resume)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':userId' => $userId,
            ':resume' => $resume
        ]);

        // Redirect to Home Page after successful application
        header("Location: HomePage.php");
        exit(); // Ensure script stops execution after redirect

    } catch (Exception $e) {
        echo "<div style='text-align: center; padding: 20px; font-size: 18px; color: red;'>
                ❌ Database error: " . $e->getMessage() . "
              </div>";
    }
}
?>
