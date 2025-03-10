<?php
require_once "config.php"; // Database connection

try {
    $sql = "SELECT jp.id, jp.jobTitle, jp.jobDescription, jp.salary, b.businessName 
            FROM jobposting jp
            JOIN business b ON jp.businessId = b.id
            WHERE jp.status = 'approved'
            ORDER BY jp.created_at DESC"; // Fetch only approved job postings

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($jobs); // Return job postings as JSON
} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
