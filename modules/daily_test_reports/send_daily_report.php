<?php
// Include database connection
include_once 'includes/db.php';
include_once 'includes/whatsapp_sender.php';

// Example data fetching (replace with your actual implementation)
$students = [
    ['id' => 1, 'name' => 'Student 1', 'phone' => '+1234567890', 'test_subject' => 'Mathematics', 'test_score' => 85.5],
    ['id' => 2, 'name' => 'Student 2', 'phone' => '+1987654321', 'test_subject' => 'Science', 'test_score' => 78.5],
    // Add more students as needed
];

// Insert test reports into database and send messages via WhatsApp
foreach ($students as $student) {
    $test_date = date('Y-m-d');
    $test_type = 'Daily Test';
    $remarks = 'Good performance';
    
    // Insert into database
    $sql = "INSERT INTO daily_test_reports (student_id, test_date, test_subject, test_type, test_score, remarks)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssds", $student['id'], $test_date, $student['test_subject'], $test_type, $student['test_score'], $remarks);
    $stmt->execute();
    
    // Send WhatsApp message
    $message = "Hello {$student['name']}, your {$test_type} result for {$student['test_subject']} is {$student['test_score']}.";
    sendWhatsAppMessage($student['phone'], $message); // Call function from whatsapp_sender.php
}

// Redirect to confirmation page
header('Location: templates/report_sent_confirmation.php');
exit;
?>
