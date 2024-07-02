<?php
// templates/student_records.php
include '../includes/header.php';
include '../includes/navbar.php';
include '../includes/db.php';

$sql = "SELECT students.*, GROUP_CONCAT(fees.amount) AS total_fees
        FROM students
        LEFT JOIN fees ON students.id = fees.student_id
        GROUP BY students.id";

$result = $conn->query($sql);
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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

<!-- Bootstrap JS (only if you need it separately) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>

    <style>
        .btn i {
    margin-right: 5px !important; /* Adjust the spacing as needed */
    vertical-align: middle !important; /* Ensures the icon is vertically centered */
}
.btn-export {
            margin-left: 10px;
        }
        .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
            background-color: red !important;
            /* Light blue color */
            color: white !important;
            font-size: 20px !important;
            font-weight: 500 !important;
            text-decoration: none !important;

        }

    </style>

</head>

<body>

    <div class="container">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-2">
                <?php include '../includes/sidebar.php'; ?>
            </div>

            <!-- Main Content -->
            <div class="col-10">
                <div class="container mt-5">
                    <h2>Student Records</h2>
                    <table class="table table-striped table-bordered table-hover" id="studentTable">
                        <thead class="table-dark">
                            <tr>
                                <th>Sr.</th>
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
                            $serialNumber = 1; // Initialize serial number counter
                            if ($result->num_rows > 0) :
                                while ($row = $result->fetch_assoc()) :
                            ?>
                                    <tr>
                                        <td><?= $serialNumber++ ?></td>
                                        <td><?= $row['id'] ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= $row['email'] ?></td>
                                        <td><?= $row['phone'] ?></td>
                                        <td><?= $row['address'] ?></td>
                                        <td><?= $row['class'] ?></td>
                                        <td><?= $row['section'] ?></td>
                                        <td><?= $row['total_fees'] ?></td>
                                        <td>
                                            <button class="btn btn-danger delete-student" data-id="<?= $row['id'] ?>" >
                                            <i class="fas fa-trash"></i>  Delete
                                            </button>

                                            

                                           
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="10">No students found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-end mt-3">
                            <button class="btn btn-primary btn-export" onclick="exportToExcel('feeTable')"><i class="fas fa-file-excel"></i> Export to Excel</button>
                            <button class="btn btn-danger btn-export" onclick="exportToPDF('feeTable')"><i class="fas fa-file-pdf"></i> Export to PDF</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- jQuery, DataTables, Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Libraries for Exporting -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html-docx-js/dist/html-docx.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    
    <script>
    $(document).ready(function() {
        $('#studentTable').DataTable();
    });
</script>

    
    <script>
       

        function exportToPDF() {
            var doc = new jsPDF();
            doc.html(document.getElementById('studentTable'), {
                callback: function(doc) {
                    doc.save('student_records.pdf');
                }
            });
        }

        function exportToExcel() {
            var table = document.getElementById('studentTable');
            var ws = XLSX.utils.table_to_sheet(table);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            XLSX.writeFile(wb, 'student_records.xlsx');
        }

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
                            data: {
                                student_id: studentId
                            },
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
    <br><br><br>
    <?php include '../includes/footer.php'; ?>
</body>

</html>