<?php
// \templates\monthly_fee_reports.php
include '../includes/header.php';
include '../includes/navbar.php';
include '../includes/db.php';

$sql = "SELECT students.name, students.class, students.section, fees.amount, fees.month, fees.status, fees.created_on 
        FROM fees 
        JOIN students ON fees.student_id = students.id 
        WHERE MONTH(fees.created_on) = MONTH(CURRENT_DATE()) 
        AND YEAR(fees.created_on) = YEAR(CURRENT_DATE())
        ORDER BY fees.created_on DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Fee Reports</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
            <div class="col-2">
                <?php include '../includes/sidebar.php'; ?>
            </div>
            <div class="col-10">
                <div class="container mt-5">
                    <h2>Monthly Fee Reports</h2>
                    <?php if ($result->num_rows > 0) : ?>
                        <table id="feeTable" class="table table-bordered table-striped table-hover  ">
                            <thead class="table-dark">
                                <tr>
                                    <th>Sr.</th>
                                    <th>Student Name</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Amount</th>
                                    <th>Month</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $serialNumber = 1;
                                while ($row = $result->fetch_assoc()) :
                                ?>
                                    <tr>
                                        <td><?= $serialNumber++ ?></td>
                                        <td><?= $row['name']; ?></td>
                                        <td><?= $row['class']; ?></td>
                                        <td><?= $row['section']; ?></td>
                                        <td><?= $row['amount']; ?></td>
                                        <td><?= $row['month']; ?></td>
                                        <td><?= $row['status']; ?></td>
                                        <td><?= date('d-m-Y h:i A', strtotime($row['created_on'])); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <div class="container">
                            <div class="row">
                                <div class="d-flex justify-content-end mt-3 mb-3">
                                    <button class="btn btn-primary btn-export" onclick="exportToExcel('feeTable')"><i class="fas fa-file-excel"></i> Export to Excel</button>
                                    <button class="btn btn-danger btn-export" onclick="exportToPDF('feeTable')"><i class="fas fa-file-pdf"></i> Export to PDF</button>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <p>No fee records found for this month.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#feeTable').DataTable();
        });

        function exportToPDF(tableId) {
            var doc = new jsPDF('p', 'pt', 'letter');
            var elem = document.getElementById(tableId);
            var options = {
                backgroundColor: 'white',
                scale: 3
            };
            html2canvas(elem, options).then(function(canvas) {
                var imgData = canvas.toDataURL('image/png');
                var imgWidth = 210;
                var imgHeight = canvas.height * imgWidth / canvas.width;
                doc.addImage(imgData, 'PNG', 15, 15, imgWidth - 30, imgHeight - 30);
                doc.save('monthly_fee_report.pdf');
            });
        }

        function exportToExcel(tableId) {
            var table = document.getElementById(tableId);
            var ws = XLSX.utils.table_to_sheet(table);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            XLSX.writeFile(wb, 'monthly_fee_report.xlsx');
        }
    </script>



    <br><br>
    <?php
    $conn->close();
    include '../includes/footer.php';
    ?>
</body>

</html>