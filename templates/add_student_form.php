<?php
// student_records.php
include '../includes/header.php';
include '../includes/navbar.php';
include '../includes/db.php';
include '../includes/functions.php';
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
    <style>
        .btn i {
            margin-right: 5px !important;
            vertical-align: middle !important;
        }

        .btn-export {
            margin-left: 10px;
        }

        .table-hover tbody tr:hover td,
        .table-hover tbody tr:hover th {
            background-color: red !important;
            color: white !important;
            font-size: 15px !important;
            font-weight: 500 !important;
            text-decoration: none !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-2">
                <?php include '../includes/sidebar.php'; ?>
            </div>

            <div class="col-10">
                <div class="container mt-5">
                    <h2>Add Student</h2>
                    <form id="addStudentForm">
                        <div class="row">
                            <div class="col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label for="class" class="form-label">Class</label>
                                    <input type="text" class="form-control" id="class" name="class" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label for="section" class="form-label">Section</label>
                                    <input type="text" class="form-control" id="section" name="section" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label for="father_name" class="form-label">Father's Name</label>
                                    <input type="text" class="form-control" id="father_name" name="father_name">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label for="contact" class="form-label">Contact</label>
                                    <input type="text" class="form-control" id="contact" name="contact">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label for="cnic" class="form-label">CNIC</label>
                                    <input type="text" class="form-control" id="cnic" name="cnic">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label for="dob" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="dob" name="dob">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select" id="gender" name="gender">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Student</button>
                    </form>
                </div>


                <div class="container mt-5">
                    <h2>Student Records</h2>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="myTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Father's Name</th>
                                    <th>Contact</th>
                                    <th>CNIC</th>
                                    <th>Date of Birth</th>
                                    <th>Gender</th>
                                    <th>Total Fees</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT students.*, 
                                           SUM(fees.amount) AS total_fees
                                        FROM students
                                        LEFT JOIN fees ON fees.student_id = students.id
                                        GROUP BY students.id
                                        ORDER BY students.id DESC";

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    $count = 1; // Initialize counter
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>{$count}</td>"; // Output serial number
                                        echo "<td>{$row['id']}</td>";
                                        echo "<td>{$row['name']}</td>";
                                        echo "<td>{$row['email']}</td>";
                                        echo "<td>{$row['phone']}</td>";
                                        echo "<td>{$row['address']}</td>";
                                        echo "<td>{$row['class']}</td>";
                                        echo "<td>{$row['section']}</td>";
                                        echo "<td>{$row['father_name']}</td>";
                                        echo "<td>{$row['contact']}</td>";
                                        echo "<td>{$row['cnic']}</td>";
                                        echo "<td>{$row['dob']}</td>";
                                        echo "<td>{$row['gender']}</td>";
                                        echo "<td>{$row['total_fees']}</td>";
                                        echo "<td><button class='btn btn-danger delete-student' data-id='{$row['id']}'>Delete</button></td>";
                                        echo "</tr>";
                                        $count++; // Increment counter for the next row
                                    }
                                } else {
                                    echo "<tr><td colspan='15'>No students found.</td></tr>";
                                }

                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 text-end">
            <button class="btn btn-primary btn-export" onclick="exportToExcel()"><i class="fas fa-file-excel"></i> Export to Excel</button>
            <button class="btn btn-danger btn-export" onclick="exportToPDF()"><i class="fas fa-file-pdf"></i> Export to PDF</button>
        </div>
    </div>

    <hr>

    <!-- jQuery, DataTables, Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

    <!-- Additional Libraries for Exporting -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

    <script>
        function exportToPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF('p', 'pt', 'a4');

            const table = document.getElementById('myTable');
            html2canvas(table).then((canvas) => {
                const imgData = canvas.toDataURL('image/png');
                const imgProps = doc.getImageProperties(imgData);
                const pdfWidth = doc.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                let position = 0;

                doc.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
                position -= pdfHeight;

                while (position >= -pdfHeight) {
                    doc.addPage();
                    doc.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
                    position -= pdfHeight;
                }

                doc.save('student_records.pdf');
            });
        }

        function exportToExcel() {
            var table = document.getElementById('myTable');
            var ws = XLSX.utils.table_to_sheet(table);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            XLSX.writeFile(wb, 'student_records.xlsx');
        }

        $(document).ready(function() {
            $('#myTable').DataTable({
                dom: '<"top-left"f><"top-right"l>rt<"bottom"ip>',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search..."
                }
            });

            $('#addStudentForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '../ajax/add_student.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        var res = JSON.parse(response);
                        if (res.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.message
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message
                            });
                        }
                    }
                });
            });

            $('.delete-student').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: '../ajax/delete_student.php',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        var res = JSON.parse(response);
                        if (res.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: res.message
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>