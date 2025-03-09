<?php
session_start();
require 'config.php'; // Database connection

// for checking (not sure if needed)
// Form submission for Contact us Page
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $reviewCheck = isset($_POST['reviewCheck']) ? 1 : 0; // 1 if checked, 0 if not

    // Insert data into the database
    $stmt = $pdo->prepare("INSERT INTO ContactMessages (name, contact, email, message, reviewCheck) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $contact, $email, $message, $reviewCheck]);

    // Redirect or show a success message
    header("Location: ContactUs.php?status=success");
    exit();
}
?>

