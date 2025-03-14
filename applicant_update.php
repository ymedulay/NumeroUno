<?php
session_start();
require 'config.php'; // Ensure database connection is available

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$stmt = $pdo->prepare("SELECT email, recovery_email, recovery_contact FROM user WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_changes'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $recovery_email = isset($_POST['recovery_email']) ? trim($_POST['recovery_email']) : null;
        $recovery_contact = isset($_POST['recovery_contact']) ? trim($_POST['recovery_contact']) : null;

        // Check if email is not empty
        if (!empty($email)) {
            $query = "UPDATE User 
            SET email = ?, recovery_email = ?, recovery_contact = ?, middleInitial = ?, degree = ?, company = ?, jobTitle = ?";
            $params = [$email, $recovery_email, $recovery_contact, $middleInitial, $degree, $company, $jobTitle, $user_id];


            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $query .= ", password = ?";
                array_splice($params, 3, 0, $hashed_password);
            }

            $query .= " WHERE id = ?";
            $stmt = $pdo->prepare($query);

            if ($stmt->execute($params)) {
                $_SESSION['success_message'] = "Account details updated successfully.";
            
                // Refresh session variables
                $_SESSION['email'] = $email;
                $_SESSION['middleInitial'] = $middleInitial;
                $_SESSION['degree'] = $degree;
                $_SESSION['company'] = $company;
                $_SESSION['jobTitle'] = $jobTitle;
            } else {
                $_SESSION['error_message'] = "Failed to update account details.";
            }
        }
    }

    if (isset($_POST['delete_account'])) {
        $stmt = $pdo->prepare("DELETE FROM user WHERE id = ?");
        if ($stmt->execute([$user_id])) {
            session_destroy();
            header("Location: Goodbye.php"); // Redirect after account deletion
            exit();
        } else {
            $_SESSION['error_message'] = "Failed to delete account.";
        }
    }

    header("Location: ApplicantDashboardAccountManagement.php");
    exit();
}
?>
