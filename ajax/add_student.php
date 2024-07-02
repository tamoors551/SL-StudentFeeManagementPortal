<?php
// ajax/add_student.php
include '../includes/functions.php';

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$class = $_POST['class'];
$section = $_POST['section'];
$father_name = $_POST['father_name'];
$contact = $_POST['contact'];
$cnic = $_POST['cnic'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];

$response = add_student($name, $email, $phone, $address, $class, $section, $father_name, $contact, $cnic, $dob, $gender);

if ($response === true) {
    echo json_encode(['status' => 'success', 'message' => 'Student added successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => $response]);
}
?>
