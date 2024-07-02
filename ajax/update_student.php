<?php
include '../includes/functions.php';

$student_id = $_POST['student_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$class = $_POST['class'];
$section = $_POST['section'];

$response = update_student($student_id, $name, $email, $phone, $address, $class, $section);

if ($response === true) {
    echo json_encode(['status' => 'success', 'message' => 'Student updated successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => $response]);
}
?>
