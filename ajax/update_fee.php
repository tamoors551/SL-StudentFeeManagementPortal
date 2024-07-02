<?php
include '../includes/functions.php';

$fee_id = $_POST['fee_id'];
$student_id = $_POST['student_id'];
$amount = $_POST['amount'];
$month = $_POST['month'];
$status = $_POST['status'];

$response = update_fee($fee_id, $student_id, $amount, $month, $status);

if ($response === true) {
    echo json_encode(['status' => 'success', 'message' => 'Fee updated successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => $response]);
}
?>
