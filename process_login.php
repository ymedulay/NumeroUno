<?php
session_start();
require 'config.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $stmt = $pdo->prepare("SELECT id, password, roleId FROM User WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            die("Invalid email or password");
        }

        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role_id'] = $user['roleId'];

        // Redirect based on role
        if ($user['roleId'] == 2) {
            header("Location: business_dashboard.php");
        } elseif ($user['roleId'] == 3) {
            header("Location: applicant_dashboard.php");
        } else {
            header("Location: admin_dashboard.php");
        }
        exit();
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
