<?php
// ajax/delete_student.php
include '../includes/functions.php';

$student_id = $_POST['student_id'];

$response = delete_student($student_id);

if ($response === true) {
    echo json_encode(['status' => 'success', 'message' => 'Student deleted successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => $response]);
}
?>
