<?php
// ajax/manage_fee.php
include '../includes/functions.php';

$student_id = $_POST['student_id'];
$amount = $_POST['amount'];
$month = $_POST['month'];
$status = $_POST['status'];

$response = add_fee($student_id, $amount, $month, $status);

if ($response === true) {
    echo json_encode(['status' => 'success', 'message' => 'Fee added successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => $response]);
}
?>

<?php
session_start();
include '../includes/db.php';

$sql = "SELECT f.id, s.name, f.amount, f.month, f.status FROM fees f JOIN students s ON f.student_id = s.id";
$result = $conn->query($sql);

$fees = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $fees[] = $row;
    }
}

echo json_encode($fees);

$conn->close();
?>


<?php
/*
// ajax/manage_fee.php
include '../includes/functions.php';

$student_id = $_POST['student_id'];
$amount = $_POST['amount'];
$month = $_POST['month'];
$status = $_POST['status'];

$response = add_fee($student_id, $amount, $month, $status);

if ($response === true) {
    echo json_encode(['status' => 'success', 'message' => 'Fee added successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => $response]);
}
*/  
?>
