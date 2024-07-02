<?php
// ajax/delete_fee.php
include '../includes/functions.php';

$fee_id = $_POST['fee_id'];

$response = delete_fee($fee_id);

if ($response === true) {
    echo json_encode(['status' => 'success', 'message' => 'Fee deleted successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => $response]);
}


// session_start();
// include '../includes/db.php';

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $fee_id = $_POST['fee_id'];

//     $sql = "DELETE FROM fees WHERE id='$fee_id'";
//     if ($conn->query($sql) === TRUE) {
//         echo json_encode(['status' => 'success', 'message' => 'Fee deleted successfully']);
//     } else {
//         echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
//     }

//     $conn->close();
// }
?>
