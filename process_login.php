<?php
session_start();
require 'config.php'; // Ensure this file establishes a database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Fetch user from database using PDO
    $stmt = $pdo->prepare("SELECT id, password, roleId FROM user WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $user['id'];
        $hashed_password = $user['password'];
        $roleId = $user['roleId'];

        // Verify password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['role_id'] = $roleId;

            // Redirect based on role
            if ($roleId == 1) {
                header("Location: AdminDashboardMain.php");
            } elseif ($roleId == 2) {
                header("Location: BusinessDashboard.php");
            } elseif ($roleId == 3) {
                header("Location: ApplicantDashboard.php");
            } else {
                echo "Invalid role.";
                exit();
            }
            exit();
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "User not found.";
    }
}
?>
