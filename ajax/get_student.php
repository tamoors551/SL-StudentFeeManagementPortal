<?php
include '../includes/functions.php';


$student_id = $_POST['student_id'];

$response = get_student($student_id);

if (is_array($response)) {
    echo json_encode(['status' => 'success', 'data' => $response]);
} else {
    echo json_encode(['status' => 'error', 'message' => $response]);
}
?>
<?php
include '../includes/db.php';

$sql = "SELECT id, name FROM students";
$result = $conn->query($sql);

$students = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

echo json_encode($students);
?>
