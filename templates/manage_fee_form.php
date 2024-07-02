<?php
// Include necessary files and initialize database connection
include '../includes/header.php';
include '../includes/navbar.php';
include '../includes/db.php';

// Fetch students for the dropdown
$students_sql = "SELECT id, name FROM students";
$students_result = $conn->query($students_sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Fee</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .form-control {
            background-color: #495057;
            color: white;
            border-color: #6c757d;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .btn-export {
            margin-left: 10px;
        }

        .table-hover tbody tr:hover td,
        .table-hover tbody tr:hover th {
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
        <div class="row mt-5">
            <div class="col-md-2">
                <?php include '../includes/sidebar.php'; ?>
            </div>
            <div class="col-md-10">
                <div class="container">
                    <h2>Manage Fee</h2>
                    <form id="manageFeeForm">
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student</label>
                            <select class="form-control" id="student_id" name="student_id" required>
                                <option value="">Select Student</option>
                                <?php while ($student = $students_result->fetch_assoc()) : ?>
                                    <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                        <div class="mb-3">
                            <label for="month" class="form-label">Month</label>
                            <?php
                            // Get the current year and month
                            $currentYear = date('Y');
                            $currentMonth = date('m');
                            ?>
                            <input type="month" class="form-control" id="month" name="month" required
                                value="<?php echo $currentYear . '-' . $currentMonth; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Paid">Paid</option>
                                <option value="Unpaid">Unpaid</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                    <div class="mt-5">
                        <h2>Existing Fees</h2>
                        <table class="table table-bordered table-striped table-hover " id="feeTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>Sr.</th>
                                    <th>Student</th>
                                    <th>Amount</th>
                                    <th>Month</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- AJAX will populate this table -->
                            </tbody>
                        </table>
                        <div class="container">
                            <div class="row">
                                <div class="col-12 text-end mt-3">
                                    <button class="btn btn-primary btn-export"
                                        onclick="exportToExcel('feeTable')"><i
                                            class="fas fa-file-excel"></i> Export to Excel</button>
                                    <!-- <button class="btn btn-danger btn-export"
                                        onclick="exportToPDF('feeTable')"><i
                                            class="fas fa-file-pdf"></i> Export to PDF</button> -->
                                </div>
                            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize DataTable
            $('#feeTable').DataTable();

            // Handle form submission
            $('#manageFeeForm').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: '../ajax/manage_fee.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        var res = JSON.parse(response);
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.message
                            });
                            loadFees();
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

            // Initial load of existing fees
            loadFees();
        });

        function loadFees() {
            $.ajax({
                url: '../ajax/get_fee.php',
                type: 'GET',
                success: function (response) {
                    var fees = JSON.parse(response);
                    var tbody = '';
                    $.each(fees, function (index, fee) {
                        tbody += '<tr>';
                        tbody += '<td>' + (index + 1) + '</td>'; // add 1 to index to start from 1 instead of 0
                        tbody += '<td>' + fee.name + '</td>';
                        tbody += '<td>' + fee.amount + '</td>';
                        tbody += '<td>' + fee.month + '</td>';
                        tbody += '<td>' + fee.status + '</td>';
                        tbody += '<td><button class="btn btn-danger" onclick="deleteFee(' + fee.id + ')"><i class="fas fa-trash"></i> Delete</button></td>';
                        tbody += '</tr>';
                    });
                    $('#feeTable tbody').html(tbody);
                }
            });
        }

        function deleteFee(feeId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../ajax/delete_fee.php',
                        type: 'POST',
                        data: {
                            id: feeId
                        },
                        success: function (response) {
                            var res = JSON.parse(response);
                            if (res.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: res.message
                                });
                                loadFees();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: res.message
                                });
                            }
                        }
                    });
                }
            });
        }

        function exportToExcel(tableId) {
            var wb = XLSX.utils.table_to_book(document.getElementById(tableId), {
                sheet: "Sheet JS"
            });
            XLSX.writeFile(wb, "fee_table.xlsx");
        }
    </script>
</body>
<?php include '../includes/footer.php'; ?>

</html>
