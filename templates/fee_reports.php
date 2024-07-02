<?php
// templates/fee_reports.php
include '../includes/header.php';
include '../includes/navbar.php';
include '../includes/db.php';

$sql = "SELECT * FROM fees";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Reports</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
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
                    <h2>Fee Reports</h2>
                    <table class="table table-striped table-hover " id="feeTable">
                        <thead class="table-dark">
                            <tr>
                                <th>Sr.</th>
                                <th>ID</th>
                                <th>Student ID</th>
                                <th>Amount</th>
                                <th>Month</th>
                                <th>Status</th>
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
                                        <td><?= $row['student_id'] ?></td>
                                        <td><?= $row['amount'] ?></td>
                                        <td><?= $row['month'] ?></td>
                                        <td><?= $row['status'] ?></td>
                                        <td>
                                            <button class="btn btn-danger delete-fee" data-id="<?= $row['id'] ?>"><i class="fas fa-trash"></i> Delete</button>

                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7">No fee records found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Export buttons -->
                <div class="container">
                    <div class="row">
                        <div class="d-flex justify-content-end mt-3">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#feeTable').DataTable();
        });

        function exportToExcel() {
            var table = $('#feeTable').DataTable();
            var data = table.rows().data().toArray();
            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.json_to_sheet(data);
            XLSX.utils.book_append_sheet(wb, ws, 'Fee Reports');
            XLSX.writeFile(wb, 'fee_reports.xlsx');
        }

        function exportToPDF() {
            var doc = new jsPDF('p', 'pt', 'letter');
            var options = {
                backgroundColor: 'white',
                scale: 3
            };
            html2canvas(document.getElementById('feeTable'), options).then(function(canvas) {
                var imgData = canvas.toDataURL('image/png');
                var imgWidth = 210;
                var imgHeight = canvas.height * imgWidth / canvas.width;
                doc.addImage(imgData, 'PNG', 15, 15, imgWidth - 30, imgHeight - 30);
                doc.save('fee_reports.pdf');
            });
        }

        $(document).on('click', '.delete-fee', function() {
            var feeId = $(this).data('id');
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
                        url: '../ajax/delete_fee.php',
                        data: {
                            fee_id: feeId
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
    </script>
    <br><br>
    <?php include '../includes/footer.php'; ?>

</body>

</html>