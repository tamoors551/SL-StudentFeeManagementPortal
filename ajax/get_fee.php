
<?php
include '../includes/db.php';

$sql = "SELECT f.id, s.name, f.amount, f.month, f.status FROM fees f JOIN students s ON f.student_id = s.id";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$fees = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $fees[] = $row;
    }
}

echo json_encode($fees);
?>
