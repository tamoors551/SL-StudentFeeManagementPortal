<?php
// includes/functions.php
include 'db.php';


function add_student($name, $email, $phone, $address, $class, $section, $father_name, $contact, $cnic, $dob, $gender) {
    global $conn;

    // Escape inputs to prevent SQL injection
    $name = $conn->real_escape_string($name);
    $email = $conn->real_escape_string($email);
    $phone = $conn->real_escape_string($phone);
    $address = $conn->real_escape_string($address);
    $class = $conn->real_escape_string($class);
    $section = $conn->real_escape_string($section);
    $father_name = $conn->real_escape_string($father_name);
    $contact = $conn->real_escape_string($contact);
    $cnic = $conn->real_escape_string($cnic);
    $dob = $conn->real_escape_string($dob);
    $gender = $conn->real_escape_string($gender);

    // Check if email already exists
    $check_sql = "SELECT * FROM students WHERE email='$email'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        return "Email already exists.";
    }

    // Insert the new student record
    $insert_sql = "INSERT INTO students (name, email, phone, address, class, section, created_on, father_name, contact, cnic, dob, gender) 
                   VALUES ('$name', '$email', '$phone', '$address', '$class', '$section', NOW(), '$father_name', '$contact', '$cnic', '$dob', '$gender')";

    if ($conn->query($insert_sql) === TRUE) {
        return true;
    } else {
        return "Error: " . $conn->error;
    }
}


function add_fee($student_id, $amount, $month, $status) {
    global $conn;

    // Escape inputs to prevent SQL injection
    $student_id = $conn->real_escape_string($student_id);
    $amount = $conn->real_escape_string($amount);
    $month = $conn->real_escape_string($month);
    $status = $conn->real_escape_string($status);

    $insert_sql = "INSERT INTO fees (student_id, amount, month, status, created_on) 
                   VALUES ('$student_id', '$amount', '$month', '$status', NOW())";

    if ($conn->query($insert_sql) === TRUE) {
        return true;
    } else {
        return "Error: " . $conn->error;
    }
}

function delete_student($student_id) {
    global $conn;

    // Escape input to prevent SQL injection
    $student_id = $conn->real_escape_string($student_id);

    $delete_sql = "DELETE FROM students WHERE id='$student_id'";

    if ($conn->query($delete_sql) === TRUE) {
        return true;
    } else {
        return "Error: " . $conn->error;
    }
}

function delete_fee($fee_id) {
    global $conn;

    // Escape input to prevent SQL injection
    $fee_id = $conn->real_escape_string($fee_id);

    $delete_sql = "DELETE FROM fees WHERE id='$fee_id'";

    if ($conn->query($delete_sql) === TRUE) {
        return true;
    } else {
        return "Error: " . $conn->error;
    }
}

function get_student($student_id) {
    global $conn;

    // Escape input to prevent SQL injection
    $student_id = $conn->real_escape_string($student_id);

    $select_sql = "SELECT * FROM students WHERE id='$student_id'";
    $result = $conn->query($select_sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return "Student not found.";
    }
}

function update_student($student_id, $name, $email, $phone, $address, $class, $section) {
    global $conn;

    // Escape inputs to prevent SQL injection
    $student_id = $conn->real_escape_string($student_id);
    $name = $conn->real_escape_string($name);
    $email = $conn->real_escape_string($email);
    $phone = $conn->real_escape_string($phone);
    $address = $conn->real_escape_string($address);
    $class = $conn->real_escape_string($class);
    $section = $conn->real_escape_string($section);

    $update_sql = "UPDATE students SET name='$name', email='$email', phone='$phone', address='$address', class='$class', section='$section' WHERE id='$student_id'";

    if ($conn->query($update_sql) === TRUE) {
        return true;
    } else {
        return "Error: " . $conn->error;
    }
}

function get_fee($fee_id) {
    global $conn;

    // Escape input to prevent SQL injection
    $fee_id = $conn->real_escape_string($fee_id);

    $select_sql = "SELECT * FROM fees WHERE id='$fee_id'";
    $result = $conn->query($select_sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return "Fee record not found.";
    }
}

function update_fee($fee_id, $student_id, $amount, $month, $status) {
    global $conn;

    // Escape inputs to prevent SQL injection
    $fee_id = $conn->real_escape_string($fee_id);
    $student_id = $conn->real_escape_string($student_id);
    $amount = $conn->real_escape_string($amount);
    $month = $conn->real_escape_string($month);
    $status = $conn->real_escape_string($status);

    $update_sql = "UPDATE fees SET student_id='$student_id', amount='$amount', month='$month', status='$status' WHERE id='$fee_id'";

    if ($conn->query($update_sql) === TRUE) {
        return true;
    } else {
        return "Error: " . $conn->error;
    }
}


// here is extra code for fu...............
// Edit Student
function edit_student($id, $name, $email, $phone, $address, $class, $section) {
    global $conn;
    $updated_on = date('Y-m-d h:i:s A');

    $sql = "UPDATE students SET name='$name', email='$email', phone='$phone', address='$address', class='$class', section='$section', updated_on='$updated_on' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return "Error updating record: " . $conn->error;
    }
}


// Edit Fee
function edit_fee($id, $student_id, $amount, $month, $status) {
    global $conn;
    $updated_on = date('Y-m-d h:i:s A');

    $sql = "UPDATE fees SET student_id='$student_id', amount='$amount', month='$month', status='$status', updated_on='$updated_on' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return "Error updating record: " . $conn->error;
    }
}

function fetch_all_students() {
    global $conn;

    $sql = "SELECT s.*, f.amount, f.month, f.status FROM students s LEFT JOIN fees f ON s.id = f.student_id";
    $result = $conn->query($sql);

    $students = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    }
    return $students;
}

// Fetch Monthly Fees Report
function fetch_monthly_fees_report() {
    global $conn;

    $sql = "SELECT s.name, f.amount, f.month, f.status FROM students s JOIN fees f ON s.id = f.student_id WHERE f.month = MONTH(CURRENT_DATE())";
    $result = $conn->query($sql);

    $report = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $report[] = $row;
        }
    }
    return $report;
}
?>