# Student Fee Management Portal

This project is aimed at managing student records and fee payments efficiently.

## Features

- Add, edit, and delete student records.
- Manage student fees with monthly reports.
- Generate PDF reports for student fees.
- User authentication with login, logout, and registration.

## Setup Instructions

1. Clone the repository.
2. Import `sql/database.sql` into your MySQL database.
3. Configure database credentials in `includes/db.php`.
4. Ensure PHP and MySQL are installed on your server.
5. Start the project by navigating to `index.php` in your browser.

## Technologies Used

- PHP (MySQLi)
- MySQL
- Ajax
- jQuery
- Bootstrap 5.3
- SweetAlert
- FPDF (for PDF generation)

## Directory Structure

INSERT INTO `students` (`id`, `name`, `email`, `phone`, `address`, `class`, `section`, `created_on`) VALUES (NULL, 'ali', 'ali@gmail.com', '03051818043', 'bwn', '12 class', 'ali', '2024-06-26 20:24:55');

INSERT INTO `fees` (`id`, `student_id`, `amount`, `month`, `status`, `created_on`) VALUES ('1', '7', '10000', 'june', '1', '2024-06-26 20:26:04');


project_root/
├── ajax
│   ├── add_student.php
│   ├── delete_fee.php
│   ├── delete_student.php
│   ├── get_fee.php
│   ├── manage_fee.php
│   ├── other_ajax_handlers.php
│   ├── update_fee.php
│   └── update_student.php
├── assets
│   ├── css
│   │   └── style.css
│   ├── img
│   │   └── logo.png
│   └── js
│       └── scripts.js
├── includes
│   ├── auth.php
│   ├── db.php
│   ├── footer.php
│   ├── functions.php
│   ├── header.php
│   ├── navbar.php
│   └── sidebar.php
├── sql
│   └── database.sql
├── templates
│   ├── add_student_form.php
│   ├── fee_reports.php
│   ├── login.php
│   ├── manage_fee_form.php
│   ├── monthly_fee_reports.php
│   ├── register.php
│   └── student_records.php
├── dashboard.php
├── generate_pdf.php
├── index.php
├── logout.php
└── README.md



<?php
// templates/student_records.php
include '../includes/header.php';
    
include '../includes/navbar.php';
include '../includes/sidebar.php';
include '../includes/db.php';

$sql = "SELECT students.*, GROUP_CONCAT(fees.amount) AS total_fees
        FROM students
        LEFT JOIN fees ON students.id = fees.student_id
        GROUP BY students.id";

$result = $conn->query($sql);
?>

<div class="container mt-5">
    <h2>Student Records</h2>
    <table class="table table-striped" id="feeTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Class</th>
                <th>Section</th>
                <th>Total Fees</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['phone'] ?></td>
                        <td><?= $row['address'] ?></td>
                        <td><?= $row['class'] ?></td>
                        <td><?= $row['section'] ?></td>
                        <td><?= $row['total_fees'] ?></td>
                        <td>
                            <button class="btn btn-danger delete-student" data-id="<?= $row['id'] ?>">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No students found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="container">
    <div class="row">
    <div class="d-flex justify-content-end mt-5">
    <button class="btn btn-primary" onclick="printDiv('feeTable')">Print</button>
</div>

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    
function printDiv(divId) {
    // Get the contents of the specified div
    var divContents = document.getElementById(divId).innerHTML;
    // Get the original contents of the body
    var originalContents = document.body.innerHTML;

    // Replace the body's contents with the div's contents
    document.body.innerHTML = divContents;

    // Print the document
    window.print();

    // Restore the original contents of the body
    document.body.innerHTML = originalContents;
}
</script>
<script>
    $(document).ready(function() {
        $('.delete-student').click(function() {
            var studentId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '../ajax/delete_student.php',
                        data: { student_id: studentId },
                        success: function(response) {
                            var res = JSON.parse(response);
                            if (res.status == 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    res.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    res.message,
                                    'error'
                                );
                            }
                        }
                    });
                }
            });
        });
    });
</script>

<?php include '../includes/footer.php'; ?>


-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `class` varchar(50) NOT NULL,
  `section` varchar(50) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--



-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `month` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `teacher_name` varchar(100) NOT NULL,
  `subject_taught` varchar(100) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--


Certainly! Let's integrate the additional functionalities into your dashboard.php while ensuring all components work seamlessly together. Below is the updated dashboard.php file that includes:

Total number of students
Total number of fees records
Total number of teachers
Status of fee payments (Paid, Unpaid)
Total sum of paid and unpaid fees
Total number of registered users
Total number of logged-in users
Explanation:
Database Connection: PHP code establishes a connection to your MySQL database using mysqli.
Data Fetching: Queries are used to fetch:
Total number of students (SELECT COUNT(*) FROM students)
Total number of fees records (SELECT COUNT(*) FROM fees)
Total number of teachers (SELECT COUNT(*) FROM teacher)
Total sum of paid fees (SELECT SUM(amount) FROM fees WHERE status = 'Paid')
Total sum of unpaid fees (SELECT SUM(amount) FROM fees WHERE status = 'Unpaid')
Total number of registered users (SELECT COUNT(*) FROM users)
Simulated total number of logged-in users (for demonstration purposes)
HTML Structure: Uses Bootstrap for layout and styling. Cards are used to display each metric on the dashboard.
CSS: Custom styles are included for the dashboard cards and hover effects.
JavaScript: Minimal JavaScript is included for Bootstrap's functionality (not directly related to data fetching).
This setup ensures all data is fetched from your database and displayed accurately on the dashboard. Adjustments can be made as per your specific requirements or database structure. If you need further customization or have more questions, feel free to ask!








Let's create a specific example for a user to be inserted into your users table.

Example Credentials:
Username: testuser
Password: Test@1234



<!-- start this is the code for add data table : and its process: -->
To integrate DataTables for your student records table and ensure all functionalities work smoothly, let's consolidate your existing code and enhance it for optimal performance. Here's a combined PHP and HTML file (student_records.php) that includes DataTables integration, AJAX form submission, and delete functionality:

php
Copy code
<?php
// student_records.php
include '../includes/header.php';
include '../includes/navbar.php';
include '../includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-2">
                <?php include '../includes/sidebar.php'; ?>
            </div>
            <div class="col-10">
                <div class="container mt-5">
                    <h2>Student Records</h2>
                    <table class="table table-striped table-bordered" id="myTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Total Fees</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT students.*, GROUP_CONCAT(fees.amount) AS total_fees
                                    FROM students
                                    LEFT JOIN fees ON students.id = fees.student_id
                                    GROUP BY students.id";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>{$row['id']}</td>";
                                    echo "<td>{$row['name']}</td>";
                                    echo "<td>{$row['email']}</td>";
                                    echo "<td>{$row['phone']}</td>";
                                    echo "<td>{$row['address']}</td>";
                                    echo "<td>{$row['class']}</td>";
                                    echo "<td>{$row['section']}</td>";
                                    echo "<td>{$row['total_fees']}</td>";
                                    echo "<td><button class='btn btn-danger delete-student' data-id='{$row['id']}'>Delete</button></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='9'>No students found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="container mt-3">
                    <h2>Add Student</h2>
                    <form id="addStudentForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="class" class="form-label">Class</label>
                            <input type="text" class="form-control" id="class" name="class" required>
                        </div>
                        <div class="mb-3">
                            <label for="section" class="form-label">Section</label>
                            <input type="text" class="form-control" id="section" name="section" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Student</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery, DataTables, Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();

            $('#addStudentForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '../ajax/add_student.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        var res = JSON.parse(response);
                        if (res.status == 'success') {
                            Swal.fire('Success!', res.message, 'success');
                            // Optionally, reload the DataTable after adding a student
                            $('#myTable').DataTable().ajax.reload();
                        } else {
                            Swal.fire('Error!', res.message, 'error');
                        }
                    }
                });
            });

            $('.delete-student').click(function() {
                var studentId = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '../ajax/delete_student.php',
                            data: { student_id: studentId },
                            success: function(response) {
                                var res = JSON.parse(response);
                                if (res.status == 'success') {
                                    Swal.fire('Deleted!', res.message, 'success').then(() => {
                                        // Reload the DataTable after deleting a student
                                        $('#myTable').DataTable().ajax.reload();
                                    });
                                } else {
                                    Swal.fire('Error!', res.message, 'error');
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
Explanation:
PHP Section: Includes necessary PHP code for database connection and querying student records.
HTML Section: Displays a form to add students and a table to show student records.
JavaScript Section: Initializes DataTables for the student records table and integrates AJAX for adding and deleting students. SweetAlert is used for confirmation dialogs.
Integration: DataTables is initialized on #myTable, enhancing it with pagination, search, and other features automatically.
Ensure your ../ajax/add_student.php and ../ajax/delete_student.php handle AJAX requests properly to add and delete students from the database.

This file combines everything you need in a single place to manage student records effectively with DataTables and Bootstrap styling.


<!-- End this is the code for add data table : and its process: -->
