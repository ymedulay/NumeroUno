<?php
session_start();
require 'config.php'; // Ensure this file is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Use the constants defined in config.php
        $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8", DB_USERNAME, DB_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $isBusiness = isset($_POST['business_name']);

        if (empty($email) || empty($password)) {
            die("Email and password are required.");
        }

        if ($isBusiness) {
            // Business Sign-up
            $businessName = trim($_POST['business_name'] ?? '');
            if (empty($businessName)) {
                die("Business name is required.");
            }

            $stmt = $pdo->prepare("SELECT id FROM Business WHERE businessName = ? OR contactEmail = ?");
            $stmt->execute([$businessName, $email]);

            if ($stmt->rowCount() > 0) {
                die("Business name or email already exists.");
            }

            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO User (firstName, lastName, email, password, roleId) VALUES (?, ?, ?, ?, 2)");
            $stmt->execute(['', '', $email, $passwordHash]);
            $userId = $pdo->lastInsertId();

            $stmt = $pdo->prepare("INSERT INTO Business (userId, businessName, contactEmail) VALUES (?, ?, ?)");
            $stmt->execute([$userId, $businessName, $email]);

            $pdo->commit();
        } else {
            // Applicant Sign-up
            $fullname = trim($_POST['fullname'] ?? '');
            $nameParts = explode(' ', $fullname, 2);
            $firstName = $nameParts[0];
            $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

            $stmt = $pdo->prepare("SELECT id FROM User WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                die("Email already exists.");
            }

            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO User (firstName, lastName, email, password, roleId) VALUES (?, ?, ?, ?, 3)");
            $stmt->execute([$firstName, $lastName, $email, $passwordHash]);
            $userId = $pdo->lastInsertId();

            $stmt = $pdo->prepare("INSERT INTO Applicant (userId) VALUES (?)");
            $stmt->execute([$userId]);

            $pdo->commit();
        }

        // Redirect to login page after signup
        header("Location: LoginPage.html");
        exit();
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        die("Error: " . $e->getMessage());
    }
}
