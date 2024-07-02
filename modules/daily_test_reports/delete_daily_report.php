<?php
// Include database connection
include_once 'includes/db.php';

// Example data fetching (replace with your actual implementation)
$report_id = $_GET['report_id']; // Assuming you pass report_id via GET method

// Soft delete from database
$sql = "UPDATE daily_test_reports SET status = 0, deleted_at = current_timestamp() WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $report_id);
$stmt->execute();

// Redirect to confirmation page
header('Location: templates/delete_report_confirmation.php');
exit;
?>
